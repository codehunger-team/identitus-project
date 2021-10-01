<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registrar;
use App\Models\Domain;
use App\Models\Category;
use App\Models\Contract;
use App\Models\GracePeriod;
use App\Models\PeriodType;
use App\Models\OptionExpiration;
use App\Models\CounterOffer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Front\ReviewController;

class DomainController extends Controller
{
    public function domains_overview()
    {

        // if remove
        if ($removeId = \Request::get('remove')) {

            // remove from db
            $d = Domain::findOrFail($removeId);
            $d->delete();

            return redirect('admin/domains')->with('msg', 'Successfully removed domain "' . $d->domain . '"');
        }

        $registrars = Registrar::get();

        $domains = Domain::orderBy('id', 'DESC')->get();

        // append domain age to the list
        $domains->map(function ($d) {
            $d->domain_age = Domain::computeAge($d->reg_date, 0);
        });

        return view('admin.domain.domains-overview')
            ->with('active', 'domains')
            ->with('domains', $domains)
            ->with('registrars', $registrars);
    }

    // add domain name listing
    public function add_domain()
    {
        $categories = Category::all()->toArray();
        $registrars = Registrar::get();
        return view('admin.domain.add-domain', compact('registrars', 'categories'));
    }

    // bulk upload
    public function bulk_upload()
    {
        return view('admin.domain.bulk-upload')->with('active', 'bulk');
    }

    // bulk upload processing
    public function bulk_upload_process(Request $r)
    {
        // Get current data from domain table
        $domainsArray = Domain::select('domain')->pluck('domain')->toArray();
        // validate file
        $this->validate($r, ['csv' => 'required|file']);
        // process the csv
        $csv_file = $r->file('csv')->getPathname();
        $handle = fopen($csv_file, 'r');
        $row = 1;
        // insert array
        $insert = [];
        while (($data = fgetcsv($handle, 0, ",")) !== false) {
            // get lines count
            $num = count($data);
            // increase rows
            $row++;
            // setup fields
            $i['domain'] = $data[0];
            $i['pricing'] = intval($data[1]);
            $i['discount'] = intval($data[2]);
            $i['registrar_id'] = $data[3];
            $i['category'] = $data[4];
            $i['user_id'] = $data[5];
            $i['status'] = $data[6];

            $i['reg_date'] = $data[7];
            $i['short_description'] = $data[8];
            $i['full_description'] = $data[9];
            $i['tags'] = $data[10];
            $i['domain_logo'] = 'default-logo.jpg';

            $i['first_payment'] = $data[11];
            $i['period_payment'] = $data[12];
            $i['period_type_id'] = $data[13];
            $i['number_of_periods'] = $data[14];
            $i['option_price'] = $data[15];

            $insert[] = $i;
            // $contracts[] = $contract;
        } // the csv lines loop
        unset($insert[0]);
        // dd($insert);
        foreach ($insert as $data) {

            try {
                $convertedDate = date('Y-m-d', strtotime(str_replace('-', '/', $data['reg_date'])));
                //creating domain collection
                $domain['domain'] = $data['domain'];
                $domain['pricing'] = $data['pricing'];
                $domain['registrar_id'] = $data['registrar_id'];
                $domain['reg_date'] = $convertedDate;
                $domain['short_description'] = $data['short_description'];
                $domain['description'] = $data['full_description'];
                $domain['tags'] = $data['tags'];
                $domain['domain_status'] = $data['status'];
                $domain['domain_logo'] = $data['domain_logo'];
                $domain['discount'] = $data['discount'];
                $domain['category'] = $data['category'];
                $domain['user_id'] = $data['user_id'];

                //check for domain already present or not
                if (in_array($data['domain'], $domainsArray)) {
                    Domain::where('domain', $data['domain'])->update($domain);
                    $updatedColumnDomainId = Domain::where('domain', $data['domain'])->pluck('id')->first();
                    $domain_id = $updatedColumnDomainId;
                } else {
                    //getting domain ID after insertion
                    $domain_id = Domain::create($domain)->id;
                }

                //creating contract collection.
                $contract['first_payment'] = $data['first_payment'];
                $contract['period_payment'] = $data['period_payment'];
                $contract['period_type_id'] = $data['period_type_id'];
                $contract['number_of_periods'] = $data['number_of_periods'];
                $contract['option_price'] = $data['option_price'];
                $contract['domain_id'] = $domain_id;
                $contract['lessor_id'] = $data['user_id'];
                $contract['lease_total'] = $data['first_payment'] + ($data['number_of_periods'] * $data['period_payment']);

                if (isset($updatedColumnDomainId)) {
                    contract::where('domain_id', $updatedColumnDomainId)->update($contract);
                } else {
                    contract::create($contract);
                }
            } catch (Exception $e) {

                return redirect('admin/bulk-domains')->with('msg', $e);
            }
        }

        // close handle to the temp file
        fclose($handle);
        $row = $row - 2;
        return redirect('admin/bulk-domains')->with('msg', 'Found <strong>' . $row . '</strong> total domains');
    }

    // add domain to database
    public function add_domain_process(Request $r)
    {
        //validation
        $this->validate($r, [
            'domain' => 'required|unique:domains,domain',
            'pricing' => 'required|numeric|min:1',
            'reg_date' => 'required|date_format:Y-m-d',
            'domain_logo' => 'image',
            'discount' => 'numeric',
        ]);
        $r['user_id'] = \Auth::user()->id;

        if (isset($r['tags'])) {
            $r['tags'] = implode(",", $r['tags']);
        }

        // save this domain
        $d = Domain::create($r->except(['sb', '_token', '_wysihtml5_mode']));

        // add domain logo ( if any )
        if ($r->hasFile('domain_logo')) {

            // set file info
            $file = $r->file('domain_logo');
            $filename = Str::slug($r->domain) . '.' . $file->getClientOriginalExtension();

            // move file
            $file->move(base_path() . '/domain-logos/', $filename);

            // create thumbnail & save
            $img = \Image::make(base_path() . '/domain-logos/' . $filename);
            $img->resize(null, 98, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save(base_path() . '/domain-logos/thumbnail-' . $filename);

            // set logo in db
            $d->domain_logo = $filename;
            $d->save();
        } else {
            $d->domain_logo = 'default-logo.jpg';
            $d->save();
        }

        // redirect with message
        return redirect('/admin/manage-domain/' . $d->id)->with('msg', 'Domain successfully created.');
    }

    // manage domain name listing
    public function manage_domain($domainId)
    {

        $domain = Domain::where('id', $domainId)->first();
        $categories = Category::all()->toArray();
        $tags = explode(",", $domain->tags);
        $registrars = Registrar::get();
        return view('admin.domain.manage-domain')
            ->with('d', $domain)
            ->with('categories', $categories)
            ->with('tags', $tags)
            ->with('registrars', $registrars);
    }

    public function manage_domain_update(Request $r, $domainName)
    {
        $domain = new Domain;
        $domainID = $domain->where('domain', $domainName)->pluck('id')->first();
        // dd($domainID);
        // validate min fields
        $this->validate($r, [
            'domain' => 'required|unique:domains,domain,' . $domainID,
            'pricing' => 'required|numeric',
            'discount' => 'numeric',
        ]);

        // update domain age
        $domain->domain_status = $r->domain_status;

        if (isset($r['tags'])) {
            $r['tags'] = implode(",", $r['tags']);
        }

        //  $domain->save();

        // updated domain logo ( if any )
        if ($r->hasFile('domain_logo')) {

            // set file info
            $file = $r->file('domain_logo');
            $filename = Str::slug($r->domain) . '.' . $file->getClientOriginalExtension();

            // move file
            $file->move(base_path() . '/domain-logos/', $filename);

            // create thumbnail & save
            $img = \Image::make(base_path() . '/domain-logos/' . $filename);
            $img->resize(null, 98, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $img->save(base_path() . '/domain-logos/thumbnail-' . $filename);
            // set logo in db
            $domain->domain_logo = $filename;
            $domain->save();
        }
        // update db
        Domain::where('id', $domainID)->update($r->except(['sb', '_token', '_wysihtml5_mode']));
        // redirect with message
        return redirect('admin/manage-domain/' . $domainID)
            ->with('msg', 'Domain details successfully Updated.');
    }

    //set terms
    public function set_terms($domainName)
    {

        $DomainValidate = Domain::where('domain', $domainName)->where('user_id', Auth::user()->id)->first();
        
        if ($DomainValidate) {
            $graces = GracePeriod::all();
            $periods = PeriodType::all();
            $options = OptionExpiration::all();
            $domainId = Domain::where('domain', $domainName)->first()->id;
            $contracts = Contract::where('domain_id', $domainId)->first();
            $isLease = Domain::where('domain', $domainName)->first()->domain_status;

            $isInNegotiation = CounterOffer::where('domain_name', $domainName)->first();
            if($isInNegotiation) {
                $isInNegotiation->lease_total = $isInNegotiation->first_payment + ($isInNegotiation->number_of_periods * $isInNegotiation->period_payment);
            } 

            if (empty($contracts)) {
                $contracts = [];
            }
            return view('admin.domain.set-terms', compact('isInNegotiation','graces', 'periods', 'options', 'domainId', 'contracts', 'domainName', 'isLease'));
        } else {
            abort(404);
        }
    }

    // add terms
    public function add_terms(Request $request, ReviewController $reviewController)
    {

        try {
            $this->validate($request, [
                'first_payment' => 'required|numeric',
                'number_of_periods' => 'required|numeric',
                'period_payment' => 'required|numeric',

            ]);
            $data = [
                'period_payment' => $request->period_payment,
                'period_type_id' => $request->period_type_id,
                'number_of_periods' => $request->number_of_periods,
                'option_price' => $request->option_price,
                'option_expiration' => 6,
                'grace_period_id' => 4,
                'domain_id' => $request->domain_id,
                'lessor_id' => Auth::id(),
                'first_payment' => $request->first_payment,
                'auto_change_rate' => 0,
                'accrual_rate' => 0,
                'lease_total' => $request->first_payment + ($request->number_of_periods * $request->period_payment),
            ];
            \Session::put('form_data', $data);
            $domainName = Domain::where('id', $request->domain_id)->pluck('domain')->first();
            
            $reviewController->createPdf($domainName,$request);
            $params = $this->docusignClickWrap($domainName);

            if ($params['created_time']) {
                \Session::put('docusign', $params);
            }
            return redirect('admin/set-terms/' . $request->domain)->withInput();
        } catch (Exception $e) {
            return redirect('admin/set-terms/' . $request->domain)->with('msg', $e->getMessage());
        }
    }
}
