<?php

namespace App\Helpers;
use \Carbon\Carbon;
 
class DateTimeHelper {

    //convert localtime to utc
    function ConvertIntoUTC($dateTime = '')
    {
        $convertedDt = Carbon::parse($dateTime, 'UTC')->format('jS F Y H:i');
        
        return $convertedDt.' '.'UTC';
    }
}