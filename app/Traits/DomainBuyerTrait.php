<?php

namespace App\Traits;

use Auth;
use App\Models\CounterOffer;

trait DomainBuyerTrait
{

    /**  
     * Convert Lessor to Lessee, if Lessor is buyer
     * @param $domainName
     */
    public function convertLessorToLessee($domainName)
    {
        $domainBuyer = CounterOffer::where('domain_name', $domainName)->pluck('lessee_id')->first();
        if (Auth::user()->id == $domainBuyer) {
            Auth::user()->is_vendor = 'no';
            // dd(Auth::user()->is_vendor);
        }
    }
}
