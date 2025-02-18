<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class DateService
{
    public static function timestampToDateTime($timestamp): string
    {
        return Carbon::createFromTimestamp($timestamp)
            ->diffForHumans(
                other: ['parts' => 4, 'join' => true]
            );
    }
}
