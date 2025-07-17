<?php

declare(strict_types=1);

namespace App\DTOs\LastFm;

use Spatie\LaravelData\Data;

class WeeklyTrackChartDTO extends Data
{
    public function __construct(
        public readonly TrackInfoDTO $track,
        public readonly int $playcount,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            track: TrackInfoDTO::fromApiResponse($data),
            playcount: (int) $data['playcount'],
        );
    }
}
