<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class DateService
{

    public function timestampToDateTime($timestamp): string
    {
        return Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }

}
