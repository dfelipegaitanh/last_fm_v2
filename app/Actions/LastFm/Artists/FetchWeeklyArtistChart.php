<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Artists;

use App\Models\LastFm\Artist;
use App\Models\LastFm\Chart;
use App\Services\LastFm\Api\LastFmApi;
use Illuminate\Support\Collection;

readonly class FetchWeeklyArtistChart
{
    public function __construct(
        private LastFmApi $lastFmApi,
    ) {}

    public function handle(string $username, Chart $chart): Collection
    {

        // $result = $this->lastFmApi->getArtistInfo(
        //    username: $username,
        //  artist: $artist->name,
        //   mbid: $artist->mbid
        //  );

        $result = $this->lastFmApi->getWeeklyArtistChart(
            username: $username,
            chart: $chart
        );
        dd([$username, $result]);
    }
}
