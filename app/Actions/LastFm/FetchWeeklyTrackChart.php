<?php

declare(strict_types=1);

namespace App\Actions\LastFm;

use App\DTOs\LastFm\WeeklyTrackChartDTO;
use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\Collection;

class FetchWeeklyTrackChart
{
    public function __construct(
        private readonly LastFmApi $lastFmApi,
    ) {}

    public function handle(string $username, int $from, int $to): Collection
    {
        $tracks = $this->lastFmApi->getWeeklyTrackChart($username, $from, $to);

        return $tracks->map(fn (array $track): WeeklyTrackChartDTO => WeeklyTrackChartDTO::fromApiResponse($track));
    }
}
