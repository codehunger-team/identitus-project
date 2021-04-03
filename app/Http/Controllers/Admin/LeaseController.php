<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GracePeriod;
use App\Models\PeriodType;
use App\Models\OptionExpiration;
use App\Models\ReleasePayment;

class LeaseController extends Controller
{
    
    //Active Lease 
    public function activeLease() 
    {
        $lease = \DB::table('contracts')
        ->leftjoin('domains', 'domains.id', '=', 'contracts.domain_id')
        ->leftjoin('users', 'users.id', '=', 'contracts.lessee_id')
        ->leftjoin('release_payments', 'release_payments.contract_id', '=', 'contracts.contract_id')
        ->where('domains.domain_status','LEASE')
        ->select('domains.domain','users.name','contracts.option_price','contracts.option_expiration','contracts.first_payment','contracts.period_type_id','contracts.number_of_periods','contracts.grace_period_id','contracts.start_date','contracts.payment_due_date','contracts.period_payment','contracts.end_date','contracts.lease_total','domains.id','contracts.contract_status_id','release_payments.payment_release','release_payments.payment_made')
        ->get();
        
        $gracePeriod = GracePeriod::get();
        $periodTypes = PeriodType::get();
        $optionExpiration = OptionExpiration::get();
        $releasePayment = ReleasePayment::get();

        return view('admin.lease.active-lease')
            ->with('active','active-lease')
            ->with('lease',$lease)
            ->with('gracePeriod',$gracePeriod)
            ->with('periodTypes',$periodTypes)
            ->with('optionExpiration',$optionExpiration);
    }

    public function inActiveLease()
    {   
        $lease = \DB::table('contracts')
        ->leftjoin('domains', 'domains.id', '=', 'contracts.domain_id')
        ->where('domains.domain_status','AVAILABLE')
        ->select('domains.domain','contracts.option_price','contracts.option_expiration','contracts.first_payment','contracts.period_type_id','contracts.number_of_periods','contracts.grace_period_id','contracts.start_date','contracts.payment_due_date','contracts.period_payment','contracts.lease_total','domains.pricing')
        ->get();

        $optionExpiration = OptionExpiration::get();
        $gracePeriod = GracePeriod::get();
        $periodTypes = PeriodType::get();
        return view('admin.lease.inactive-lease')
            ->with('active','inactive-lease')
            ->with('lease',$lease)
            ->with('gracePeriod',$gracePeriod)
            ->with('periodTypes',$periodTypes)
            ->with('optionExpiration',$optionExpiration);
    }
}
