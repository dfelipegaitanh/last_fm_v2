<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Charts;

use App\DTOs\LastFm\TrackDTO;
use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\Collection;

readonly class FetchWeeklyTrackChart
{
    public function __construct(
        private LastFmApi $lastFmApi,
    ) {}

    /** @return Collection<int, TrackDTO> */
    public function handle(string $username, int $from, int $to): Collection
    {
        return $this->lastFmApi->getWeeklyTrackChart($username, $from, $to)
            ->filter(fn (TrackDTO $track): bool => $track->playcount > 1);
    }
}
