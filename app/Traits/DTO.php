<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Contracts\Support\Arrayable;

trait DTO
{
    public function toArray(): array
    {

        return array_map(fn ($value) => $this->convertValueToArray($value), get_object_vars($this));

    }

    private function convertValueToArray(mixed $value): mixed
    {
        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        if (is_array($value)) {
            return $this->convertArrayItemsToArray($value);
        }

        return $value;
    }

    private function convertArrayItemsToArray(array $items): array
    {
        return array_map(fn ($item) => $this->convertValueToArray($item), $items);
    }
}
