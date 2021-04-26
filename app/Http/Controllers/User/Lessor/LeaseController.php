<?php

namespace App\Http\Controllers\User\Lessor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\GracePeriod;
use App\Models\PeriodType;
use App\Models\OptionExpiration;

class LeaseController extends Controller
{
    
    /**
     * Active Lease
     * 
     */
    public function activeLease()
    {
        $userId = Auth::id();
        $lease = \DB::table('contracts')
            ->leftjoin('domains', 'domains.id', '=', 'contracts.domain_id')
            ->leftjoin('users', 'users.id', '=', 'contracts.lessee_id')
            ->where('domains.domain_status', 'LEASE')
            ->where('domains.user_id', $userId)
            ->select('domains.domain', 'users.name', 'contracts.option_price', 'contracts.option_expiration', 'contracts.first_payment', 'contracts.period_type_id', 'contracts.number_of_periods', 'contracts.grace_period_id', 'contracts.start_date', 'contracts.payment_due_date', 'contracts.period_payment', 'contracts.end_date', 'contracts.lease_total', 'domains.id', 'contracts.contract_status_id')
            ->get();

        $gracePeriod = GracePeriod::get();
        $periodTypes = PeriodType::get();
        $optionExpiration = OptionExpiration::get();

        return view('user.lessor.lease.active')
            ->with('active', 'active-lease')
            ->with('lease', $lease)
            ->with('gracePeriod', $gracePeriod)
            ->with('periodTypes', $periodTypes)
            ->with('optionExpiration', $optionExpiration);

    }

    /**
     * Inactive Lease
     * 
    */
    public function inActiveLease()
    {

        $userId = Auth::id();
        $lease = \DB::table('contracts')
            ->leftjoin('domains', 'domains.id', '=', 'contracts.domain_id')
            ->where('domains.domain_status', 'AVAILABLE')
            ->where('domains.user_id', $userId)

            ->select('domains.domain', 'contracts.option_price', 'contracts.option_expiration', 'contracts.first_payment', 'contracts.period_type_id', 'contracts.number_of_periods', 'contracts.grace_period_id', 'contracts.start_date', 'contracts.payment_due_date', 'contracts.period_payment', 'contracts.lease_total', 'domains.pricing')

            ->get();

        $optionExpiration = OptionExpiration::get();
        $gracePeriod = GracePeriod::get();
        $periodTypes = PeriodType::get();

        return view('user.lessor.lease.inactive')
            ->with('active', 'inactive-lease')
            ->with('lease', $lease)
            ->with('gracePeriod', $gracePeriod)
            ->with('periodTypes', $periodTypes)
            ->with('optionExpiration', $optionExpiration);
    }
}
