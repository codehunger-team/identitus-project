<?php

namespace App\Traits;
use Carbon\Carbon;

trait CalculatePeriodTrait {

    public function calculatePeriod($periodDays,$noOfPeriods) {
        $periodDay = $periodDays->first()->period_type;
        if ($periodDay == 'Monthly') {

            $mytime = Carbon::now()->addDays(30 * $noOfPeriods); 
            return  $mytime->toDateTimeString(); 

        } else if ($periodDay == 'Daily') {

            $mytime = Carbon::now()->addDays(1 * $noOfPeriods);
            return  $mytime->toDateTimeString();

        } else if ($periodDay == 'Weekly') {

            $mytime = Carbon::now()->addDays(7 * $noOfPeriods);
            return  $mytime->toDateTimeString();

        } else if ($periodDay == 'Quarterly') {

            $mytime = Carbon::now()->addDays(90 * $noOfPeriods);
            return  $mytime->toDateTimeString();

        } else if ($periodDay == 'Yearly') {

            $mytime = Carbon::now()->addDays(365 * $noOfPeriods);
            return  $mytime->toDateTimeString();
        }
    }

}
