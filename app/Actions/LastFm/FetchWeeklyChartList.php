<?php

declare(strict_types=1);

namespace App\Actions\LastFm;

use App\DTOs\LastFm\WeeklyChartDTO;
use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\Collection;

class FetchWeeklyChartList
{
    public function __construct(
        private readonly LastFmApi $lastFmApi,
    ) {}

    public function handle(string $username): Collection
    {
        $charts = $this->lastFmApi->getWeeklyChartList($username);

        return $charts->map(fn (array $chart): WeeklyChartDTO => WeeklyChartDTO::fromApiResponse($chart));
    }
}
