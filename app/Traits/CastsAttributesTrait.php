<?php

namespace App\Traits;

trait CastsAttributesTrait
{
    protected static function toInt(mixed $value): int
    {
        return is_numeric($value) ? (int) $value : 0;
    }
}
