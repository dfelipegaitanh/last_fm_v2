<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class DateService
{
    public static function timestampToDateTime($timestamp): string
    {
        return Carbon::createFromDate($timestamp)
            ->diffForHumans(
                other: ['parts' => 4, 'join' => true]
            );
    }

    public static function dateToDateTime($timestamp): string
    {
        return (new Carbon($timestamp))
            ->diffForHumans(
                other: ['parts' => 2, 'join' => true]
            );
    }
}
