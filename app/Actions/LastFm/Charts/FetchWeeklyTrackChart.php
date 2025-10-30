<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Charts;

use App\DTOs\LastFm\TrackDTO;
use App\DTOs\LastFm\TrackInfoDTO;
use App\Models\LastFm\Chart;
use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\Collection;

readonly class FetchWeeklyTrackChart
{
    public function __construct(
        private LastFmApi $lastFmApi,
    ) {}

    /** @return Collection<int, TrackInfoDTO> */
    public function handle(string $username, Chart $chart): Collection
    {
        return $this->lastFmApi->getWeeklyTrackChart($username, $chart->from, $chart->to)
            ->filter(fn (TrackInfoDTO $track): bool => $track->playcount > config('lastfm.min_playcount'));
    }
}
