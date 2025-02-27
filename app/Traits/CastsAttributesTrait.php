<?php

namespace App\Traits;

trait CastsAttributesTrait
{
    protected static function toInt(mixed $value): int
    {
        return (int) $value;
    }
}
