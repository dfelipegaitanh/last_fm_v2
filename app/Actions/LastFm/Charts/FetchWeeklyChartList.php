<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Charts;

use App\DTOs\LastFm\WeeklyChartDTO;
use App\Enums\ChartType;
use App\Models\LastFm\Chart;
use App\Models\User;
use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\Collection;

class FetchWeeklyChartList
{
    public function __construct(
        private readonly LastFmApi $lastFmApi,
    ) {}

    public function handle(User $user): Collection
    {
        $charts = $this->lastFmApi
            ->getWeeklyChartList(username: $user->lastfm_user);

        /*
                $charts->each(function(array $chart) : void {
                     Chart::firstOrCreate(
                        [
                            'from_timestamp' => $chart['from'],
                            'to_timestamp'   => $chart['from'],
                            'type' => ChartType::WEEKLY,
                        ] ,
                         ['processed' => false]
                    );
                });
        */
        return $charts->map(fn (array $chart): WeeklyChartDTO => WeeklyChartDTO::fromApiResponse($chart));
    }
}
