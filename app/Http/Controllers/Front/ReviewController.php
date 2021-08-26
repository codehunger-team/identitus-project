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

        $mytime = Carbon::now();
        $getCurrentDateTime =  $mytime->toDateTimeString();

        if (Auth::check()) {

            $this->createPdf($domainName, $domain, $lessor, $contracts, $periods, $periodType, $options, $leasetotal, $getCurrentDateTime, $graces, $endOfLease);

            return view('front.review.terms', compact('graces','periods','options','domain','contracts','domainName','leasetotal','getCurrentDateTime','endOfLease','periodType','lessor'));
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
        $counterOffer = CounterOffer::where('domain_name', $domainName)->first();

        $contracts = Contract::latest()->first();
        $isVendor = Auth::user()->is_vendor;

        if ($isVendor == 'yes' || Auth::user()->admin == 1) {
            $lesseeId = CounterOffer::where('domain_name', $domainName)->pluck('lessee_id')->first();
            $name = User::where('id', $lesseeId)->pluck('name')->first();
        } else {
            $lessorId = CounterOffer::where('domain_name', $domainName)->pluck('lessor_id')->first();
            $name = User::where('id', $lessorId)->pluck('name')->first();
        }
        $domainId = Contract::latest()->first()->domain_id;
        $domainName = Domain::where('id', $domainId)->first()->domain;
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
        $counterOffer = CounterOffer::where('domain_name', $data['domain_name'])->first();

        if (Auth::user()->is_vendor == 'yes' || Auth::user()->admin == 1) {
            $toEmail = User::where('id', $counterOffer->lessee_id)->pluck('email')->first();
            $data['from_email'] = User::where('id', $counterOffer->lessor_id)->pluck('email')->first();
        } else {
            $toEmail = User::where('id', $counterOffer->lessor_id)->pluck('email')->first();
            $data['from_email'] = User::where('id', $counterOffer->lessee_id)->pluck('email')->first();
        }

        try {

            if (Auth::user()->is_vendor == 'yes' || Auth::user()->admin == 1) {
                Mail::to($toEmail)->later(now()->addMinutes(1), new DomainReviewTerm($data));
            } else {
                Mail::to($toEmail)->later(now()->addMinutes(1), new CounterLeaseVendor($data));
            }
            unset($data['from_email']);
            CounterOffer::where('domain_name', $data['domain_name'])->update($data);
            Session::flash('success', 'We have informed regarding your price...');
            return redirect()->back();
        } catch (Exception $e) {
            \Log::critical($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }

    //send mail to vendor from user in counter lease
    public function counter(Request $request)
    {

        $data = $request->all();
        $domainId = Contract::latest()->first()->domain_id;
        $data['domain_name'] = Domain::where('id', $domainId)->first()->domain;
        $data['lessee_id'] = Auth::user()->id;
        $VendorEmail = User::where('id', $data['lessor_id'])->pluck('email')->first();

        $validator = \Validator::make($request->all(), [
            'first_payment' => 'required|numeric',
            'period_payment' => 'required|numeric',
            'number_of_periods' => 'required|numeric',
            'option_purchase_price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        try {
            Mail::to($VendorEmail)->later(now()->addMinutes(1), new DomainReviewTerm($data));
            Session::flash('success', 'We have informed the owner regarding your price...');
            CounterOffer::create($data);
            return redirect()->back();
        } catch (Exception $e) {
            \Log::critical($e->getFile() . $e->getLine() . $e->getMessage());
        }
    }


    //counter lease --shaiv
    public function counterLease(Request $request)
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
        try {
            $data = $request->except('_token');
            $contract = Contract::where('contract_id', $data['contract_id'])->first();
            $data['domain_name'] = $contract->domain->domain;
            $data['lessee_id'] = Auth::user()->id;
            $data['from_email'] = Auth::user()->email;
            $vendorEmail = User::where('id', $data['lessor_id'])->pluck('email')->first();

            Mail::to($vendorEmail)->later(now()->addMinutes(1), new DomainReviewTerm($data));
            Session::flash('success', 'We have informed the owner regarding your price...');
            CounterOffer::create($data);
            return redirect()->back();
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
