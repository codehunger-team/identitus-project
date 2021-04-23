<?php

namespace App\Http\Controllers\User\Lessor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Domain;
use App\Models\Category;
use App\Models\Registrar;
use App\Models\Contract;

class DomainController extends Controller
{
    /**
     * Manage Domain
     * 
     */
    public function domain()
    {
        $userId = Auth::id();
        $domains = Domain::where('user_id', $userId)->get();

        $registrars = Registrar::get();

        // append domain age to the list
        $domains->map(function ($d) {
            $d->domain_age = Domain::computeAge($d->reg_date, 0);
        });

        return view('user.lessor.domain.domain')
            ->with('active', 'domains')
            ->with('domains', $domains)
            ->with('registrars', $registrars);

    }

    /**
     * Add Domain
     * 
     */
    public function addDomain()
    {
        $categories = Category::get();
        $registrars = Registrar::get();
        return view('user.lessor.domain.add-domain', compact('categories', 'registrars'));
    }

    /**
     * Store Domain
     * 
     */
    public function storeDomain(Request $r)
    {

        $this->validate($r, ['domain' => 'required|unique:domains,domain',
            'pricing' => 'required|numeric|min:1',
            'reg_date' => 'required|date_format:Y-m-d',
            'discount' => 'numeric',
        ]);

        $request = $r->except(['sb', '_token', '_wysihtml5_mode']);

        $request['user_id'] = Auth::id();

        if (isset($request['tags'])) {
            $request['tags'] = implode(",", $request['tags']);
        }
        // save this domain
        $d = Domain::create($request);

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
        return redirect('/user/domain')->with('msg', 'Domain successfully created.');

    }

    /**
     * Manage Domain Listing
     * 
     */
    public function manage_domain($domainId)
    {
        $domain = Domain::where('id', $domainId)->first();
        $tags = explode(",", $domain->tags);
        $categories = Category::all()->toArray();
        $registrars = Registrar::get();

        return view('user.lessor.domain.manage-domain')
            ->with('d', $domain)
            ->with('categories', $categories)
            ->with('tags', $tags)
            ->with('registrars', $registrars);

    }

    /**
     * Update Domain Listings
     * 
     */
    public function manage_domain_update(Request $r, $domainId)
    {   

        $domain = new \App\Models\Domain;
                // validate min fields
        $this->validate($r, [
            'domain' => 'required|unique:domains,domain,' . $domainId,
            'pricing' => 'required|numeric|min:1',
            'reg_date' => 'required|date_format:Y-m-d',
            'discount' => 'numeric',
        ]);
        // update domain age
        $domain->domain_status = $r->domain_status;

        if (isset($r['tags'])) {
            $r['tags'] = implode(",", $r['tags']);
        }

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
        Domain::where('id', $domainId)->update($r->except(['sb', '_token', '_wysihtml5_mode']));
        
        // redirect with message
        return redirect('user/manage-domain/' . $domainId)
            ->with('msg', 'Domain details successfully saved.');

    }

    /**
     * Delete Domain
     * 
     */  
    public function domain_delete($domainId)
    {
        Domain::where('id', $domainId)->delete();
        return redirect()->back()->with('msg', 'Domain Deleted Successfully.');
    }

    /**
     * Add Terms
     * 
     */  
    public function add_terms(Request $request)
    {

        $this->validate($request, ['first_payment' => 'required|numeric',
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

        $contractData = Contract::where('domain_id', $request->domain_id)->first();

        if ($contractData) {
            $contractData->update($data);
            return redirect('user/set-terms/' . $request->domain)->with('msg', 'Successfully updated');

        } else {
            Contract::create($data);
            return redirect('user/set-terms/' . $request->domain)->with('msg', 'Successfully Added');
        }

    }
}
