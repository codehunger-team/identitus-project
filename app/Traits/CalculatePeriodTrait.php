<?php

namespace App\Traits;
use Carbon\Carbon;

trait CalculatePeriodTrait {

    public function calculatePeriod($periodDays,$noOfPeriods) {
        $periodDay = $periodDays->first()->period_type;

        if ($periodDay == 'Month') {

            $mytime = Carbon::now()->addDays(30 * $noOfPeriods); 
            return  $mytime->toDateTimeString(); 

        } else if ($periodDay == 'Day') {

            $mytime = Carbon::now()->addDays(1 * $noOfPeriods);
            return  $mytime->toDateTimeString();

        } else if ($periodDay == 'Week') {

            $mytime = Carbon::now()->addDays(7 * $noOfPeriods);
            return  $mytime->toDateTimeString();

        } else if ($periodDay == 'Quarter') {

            $mytime = Carbon::now()->addDays(90 * $noOfPeriods);
            return  $mytime->toDateTimeString();

        } else if ($periodDay == 'Year') {

            $mytime = Carbon::now()->addDays(365 * $noOfPeriods);
            return  $mytime->toDateTimeString();
        }
    }

}
