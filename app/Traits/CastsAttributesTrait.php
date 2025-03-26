<?php

declare(strict_types=1);

namespace App\Traits;

trait CastsAttributesTrait
{
    protected static function toInt(mixed $value): int
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\d]/', '', $value);
        }

        return is_numeric($value) ? (int) $value : 0;
    }
}
