<?php

namespace App\Action;

use Carbon\Carbon;

class DateFormater
{
    public static function prepareDate($date)
    {
        $newDate = strtotime($date);
        $final = date('Y-m-d H:i:s',$newDate);

        return Carbon::createFromFormat('Y-m-d H:i:s',$final);
    }
}