<?php

namespace App\Traits;

use Illuminate\Contracts\Support\Arrayable;

trait DTO
{
    public function toArray(): array
    {
        $data = get_object_vars($this);

        foreach ($data as $key => $value) {
            $data[$key] = $this->convertValueToArray($value);
        }

        return $data;
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
