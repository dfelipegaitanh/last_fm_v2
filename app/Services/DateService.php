<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Carbon;

class DateService
{
    public static function timestampToDateTime(float|int|string $timestamp): string
    {
        return Carbon::createFromTimestamp($timestamp)
            ->diffForHumans(
                other: ['parts' => 4, 'join' => true]
            );
    }

    public static function dateToDateTime(string $timestamp, int $parts = 2): string
    {
        return (new Carbon($timestamp))
            ->diffForHumans(
                other: ['parts' => $parts, 'join' => true]
            );
    }
}
