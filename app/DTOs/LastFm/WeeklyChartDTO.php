<?php

declare(strict_types=1);

namespace App\DTOs\LastFm;

use Spatie\LaravelData\Data;

class WeeklyChartDTO extends Data
{
    public function __construct(
        public readonly int $from,
        public readonly int $to,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            from: (int) $data['from'],
            to: (int) $data['to'],
        );
    }
}
