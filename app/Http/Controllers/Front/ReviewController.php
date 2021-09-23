<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Domain;
use App\Models\GracePeriod;
use App\Models\PeriodType;
use App\Models\OptionExpiration;
use App\Traits\CalculatePeriodTrait;
use App\Models\User;
use PDF;
use Auth;
use App\Models\CounterOffer;

class ReviewController extends Controller
{
    use CalculatePeriodTrait;

    public function index(Request $request, $domainName)
    {

        User::where('admin', 1)->update(['is_vendor' => 'yes']);

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
        
        $getCurrentDateTime =  getCurrentDateTime();

        if (Auth::check()) {

            $this->createPdf($domainName, $domain, $lessor, $contracts, $periods, $periodType, $options, $leasetotal, $getCurrentDateTime, $graces, $endOfLease);

            return view('front.review.terms', compact('graces', 'periods', 'options', 'domain', 'contracts', 'domainName', 'leasetotal', 'getCurrentDateTime', 'endOfLease', 'periodType', 'lessor', 'isAlreadyCounterOffered'));
        } else {

            return redirect()->to(route('login'));
        }
    }


    public function createPdf($domainName,$termsData='')
    {
        $domain = Domain::where('domain', $domainName)->first();
        $lessor = User::where('id', $domain->user_id)->first();

        $contracts = Contract::where('domain_id', $domain->id)->first();

        if($contracts == NULL || isset($termsData)) {
            $contract = Contract::where('domain_id', $domain->id)->first();
            $contracts = collect();
            if(isset($termsData->request)) {
                $termsData = $termsData->request->all();
            }
            $contracts->first_payment = $termsData['first_payment'];
            $contracts->period_payment = $termsData['period_payment'];
            $contracts->number_of_periods = $termsData['number_of_periods'];
            $contracts->option_expiration = 6;
            $contracts->grace_period_id = 4;
            if(isset($termsData['option_purchase_price'])) {
                $contracts->option_price = $termsData['option_purchase_price'];
            } else {
                $contracts->option_price = $termsData['option_price'];
            }
            if(isset($termsData['period_type_id'])) {
                $contracts->period_type_id = $termsData['period_type_id'];
            } else {
                $contracts->period_type_id = $contract->period_type_id;
            }
        }
    
        $graces = GracePeriod::all();

        $periods = PeriodType::all();
        $periodDays = $periods->where('id', $contracts->period_type_id);

        $periodType = $periods->where('id', $contracts->period_type_id)->first()->period_type;
        $endOfLease = $this->calculatePeriod($periodDays, $contracts->number_of_periods);

        $options = OptionExpiration::all();
        $leasetotal = $contracts->first_payment + ($contracts->number_of_periods *
            $contracts->period_payment);

        $getCurrentDateTime =  getCurrentDateTime();
        $pdf = PDF::loadView('front.review.pdf-terms', compact(
            'graces',
            'periods',
            'options',
            'domain',
            'contracts',
            'domainName',
            'leasetotal',
            'getCurrentDateTime',
            'endOfLease',
            'periodType',
            'lessor'
        ));
        $filename = 'contract_' . $lessor->id . '.pdf';

        \Storage::put('public/pdf/' . $filename, $pdf->output());
    }
}
