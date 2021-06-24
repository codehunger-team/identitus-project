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

class ReviewController extends Controller
{   
    use CalculatePeriodTrait;
    
    public function index(Request $request, $domainName)
    {   
        
        $domain = Domain::where('domain',$domainName)->first();
        $lessor = User::where('id',$domain->user_id)->first();
        
        $contracts = Contract::where('domain_id',$domain->id)->firstorFail();
        $graces = GracePeriod::all();
        
        $periods = PeriodType::all();
        $periodDays = $periods->where('id',$contracts->period_type_id);
        
        $periodType = $periods->where('id',$contracts->period_type_id)->first()->period_type;
        $endOfLease = $this->calculatePeriod($periodDays,$contracts->number_of_periods); 
        
        $options = OptionExpiration::all();
        $leasetotal = $contracts->first_payment + ($contracts->number_of_periods * 
        $contracts->period_payment);
        
        $mytime = Carbon::now();
        $getCurrentDateTime =  $mytime->toDateTimeString(); 
        
        if(Auth::check()) {

            $this->createPdf($domainName,$domain,$lessor,$contracts,$periods,$periodType,$options,$leasetotal,$getCurrentDateTime,$graces,$endOfLease);

            return view('front.review.terms',compact('graces','periods','options','domain','contracts','domainName',
            'leasetotal','getCurrentDateTime','endOfLease','periodType','lessor'));

        } else {

            return redirect()->to(route('login'));
        }

    }


    private function createPdf($domainName,$domain,$lessor,$contracts,$periods,$periodType,$options,$leasetotal,$getCurrentDateTime,$graces,$endOfLease)
    {   
        $pdf = PDF::loadView('front.review.pdf-terms', compact('graces','periods','options','domain','contracts','domainName',
        'leasetotal','getCurrentDateTime','endOfLease','periodType','lessor'));
        $filename = 'contract_'.$lessor->id.'.pdf';
        $pdf->save('doc/'.$filename);
    }
}
