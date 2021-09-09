<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Domain;
use App\Models\GracePeriod;
use App\Models\PeriodType;
use App\Models\OptionExpiration;
use Carbon\Carbon;
use App\Traits\CalculatePeriodTrait;
use App\Models\User;
use PDF;
use Auth;
use Illuminate\Support\Facades\Mail;
use Session;
use App\Mail\DomainReviewTerm;
use App\Mail\CounterLeaseVendor;
use App\Models\CounterOffer;

class ReviewController extends Controller
{
    use CalculatePeriodTrait;

    public function index(Request $request, $domainName)
    {

        User::where('admin',1)->update(['is_vendor'=>'yes']);
        
        $domain = Domain::where('domain', $domainName)->first();
        $lessor = User::where('id', $domain->user_id)->first();

        $contracts = Contract::where('domain_id', $domain->id)->firstorFail();
        $graces = GracePeriod::all();

        $periods = PeriodType::all();
        $periodDays = $periods->where('id', $contracts->period_type_id);

        $periodType = $periods->where('id', $contracts->period_type_id)->first()->period_type;
        $endOfLease = $this->calculatePeriod($periodDays, $contracts->number_of_periods);

        $options = OptionExpiration::all();
        $leasetotal = $contracts->first_payment + ($contracts->number_of_periods *
            $contracts->period_payment);
        
        $isExistDomainInCounterOfferTbl =  CounterOffer::where('domain_name', $domainName)->first();
        $isAlreadyCounterOffered = (!empty($isExistDomainInCounterOfferTbl)) ? 1 : 0;
        $mytime = Carbon::now();
        $getCurrentDateTime =  $mytime->toDateTimeString();

        if (Auth::check()) {

            $this->createPdf($domainName, $domain, $lessor, $contracts, $periods, $periodType, $options, $leasetotal, $getCurrentDateTime, $graces, $endOfLease);

            return view('front.review.terms', compact('graces','periods','options','domain','contracts','domainName','leasetotal','getCurrentDateTime','endOfLease','periodType','lessor', 'isAlreadyCounterOffered'));
        } else {

            return redirect()->to(route('login'));
        }
    }


    private function createPdf($domainName, $domain, $lessor, $contracts, $periods, $periodType, $options, $leasetotal, $getCurrentDateTime, $graces, $endOfLease)
    {
        $pdf = PDF::loadView('front.review.pdf-terms', compact('graces','periods','options','domain','contracts','domainName','leasetotal','getCurrentDateTime','endOfLease','periodType','lessor'
        ));
        $filename = 'contract_' . $lessor->id . '.pdf';

        \Storage::put('public/pdf/' . $filename, $pdf->output());
    }


    //counter lease
    public function counterOffer(Request $request, $domainName)
    {   
        $domainDetail = Domain::getDetailUsingDomainName($domainName);
        $contracts = Contract::where('domain_id',$domainDetail->id)->first();
        $isVendor = Auth::user()->is_vendor;
        
         //check for domain 
         if($isVendor == 'yes') {
            $counterOffer = CounterOffer::where(['domain_name' => $domainName, 'lessor_id' => Auth::user()->id])->exists();
            $domainCheckForUser = Domain::where(['user_id' => Auth::user()->id, 'domain' => $domainName])->first();
            if(empty($domainCheckForUser) && !$counterOffer) {
                abort('403', 'Not accessible');
            }
        } else if($isVendor == 'no' || $isVendor == 'pending') {
            $counterOffer = CounterOffer::where(['domain_name' => $domainName, 'lessee_id' => Auth::user()->id])->exists();
            if(!$counterOffer) {
                abort('403', 'Not accessible');
            }
        }

        $counterOffer = [];
        if ($isVendor == 'yes' || (isset(Auth::user()->admin) && Auth::user()->admin == 1)) {
            $lesseeId = CounterOffer::where('domain_name', $domainName)->pluck('lessee_id')->first();
            $name = User::where('id', $lesseeId)->pluck('name')->first();
            $counterOffer = CounterOffer::where(['domain_name' => $domainName, 'lessor_id' => null])->first();
        } else {
            $lessorId = CounterOffer::where('domain_name', $domainName)->pluck('lessor_id')->first();
            $name = User::where('id', $lessorId)->pluck('name')->first();
            $counterOffer = CounterOffer::where(['domain_name' => $domainName, 'lessee_id' => null])->first();
        }        
    
        return view('front.review.counter', compact('contracts', 'domainName', 'name', 'isVendor', 'counterOffer'));
    }

    //send mail to user from vendor in counter lease --shaiv
    public function counterContract(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'first_payment' => 'required|numeric',
            'period_payment' => 'required|numeric',
            'number_of_periods' => 'required|numeric',
            'option_purchase_price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $data = $request->except('_token');

        if (Auth::user()->is_vendor == 'yes') {
            $lesseeId = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessor_id' => null])->first()->lessee_id;
            $toEmail = User::find($lesseeId)->email;
            $data['from_email'] = Auth::user()->email;
        } else {
            $lessorId = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessee_id' => null])->first()->lessor_id;
            $toEmail = User::find($lessorId)->email;
            $data['from_email'] = Auth::user()->email;
        }

        try {

            $isLessorData = [];
            $isLesseeData = [];
            if(Auth::user()->is_vendor == 'yes') {
                $data['lessor_id'] = (string)Auth::user()->id;
                $isLessorData = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessor_id' => $data['lessor_id']])->first();
                $data['lessee_id'] = null;

            } else if(Auth::user()->is_vendor == 'no' || Auth::user()->is_vender == 'pending') {
                $data['lessee_id'] = (string)Auth::user()->id;
                $isLesseeData = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessee_id' => $data['lessee_id']])->first();
                $data['lessor_id'] = null;
            }


            if (Auth::user()->is_vendor == 'yes') {
                Mail::to($toEmail)->later(now()->addMinutes(1), new CounterLeaseVendor($data));
            } else {
                Mail::to($toEmail)->later(now()->addMinutes(1), new DomainReviewTerm($data));
            }
            unset($data['from_email']);


            //update lessor data
            if(is_null($data['lessee_id'])) {
                if(!empty($isLessorData)) {
                    $isLessorData = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessor_id' => $data['lessor_id']])->update($data);
                } else {
                    $contractId = CounterOffer::where('domain_name', $data['domain_name'])->pluck('contract_id')->first();
                    $data['contract_id'] = $contractId;
                    CounterOffer::create($data);
                }
            }

            //update lessee data
            if(is_null($data['lessor_id'])) {
                if(!empty($isLesseeData)) {
                    $isLessorData = CounterOffer::where(['domain_name' => $data['domain_name'], 'lessee_id' => $data['lessee_id']])->update($data);
                } else {
                    $contractId = CounterOffer::where('domain_name', $data['domain_name'])->pluck('contract_id')->first();
                    $data['contract_id'] = $contractId;
                    CounterOffer::create($data);
                }
            }

            Session::flash('success', 'We have informed regarding your price...');
            return redirect()->back();
        } catch (Exception $e) {
            \Log::critical($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    //counter lease 
    public function counterLease(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'first_payment' => 'required|numeric',
            'period_payment' => 'required|numeric',
            'number_of_periods' => 'required|numeric',
            'option_purchase_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        try {
            $data = $request->except('_token');
            $contract = Contract::where('contract_id', $data['contract_id'])->first();
            $data['domain_name'] = $contract->domain->domain;
            $data['lessee_id'] = Auth::user()->id;
            $data['from_email'] = Auth::user()->email;
            $vendorEmail = User::where('id', $data['lessor_id'])->pluck('email')->first();

            Mail::to($vendorEmail)->later(now()->addMinutes(1), new DomainReviewTerm($data));
            Session::flash('success', 'We have informed the owner regarding your price...');
            $isCounterOffer = CounterOffer::where('domain_name',$data['domain_name'])->where('lessee_id',Auth::user()->id)->first();
            if ($isCounterOffer) {
                $isCounterOffer->update($data);
            } else {
                unset($data['lessor_id']);
                CounterOffer::create($data);
            }
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            \Log::critical($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    //edit counter
    public function editCounter($id)
    {
        return Contract::find($id);
    }

}
