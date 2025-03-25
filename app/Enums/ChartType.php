<?php

declare(strict_types=1);

namespace App\Enums;

enum ChartType: string
{
    case CUSTOM = 'custom';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    public static function random(): self
    {
        return self::cases()[array_rand(self::cases())];
    }
}
