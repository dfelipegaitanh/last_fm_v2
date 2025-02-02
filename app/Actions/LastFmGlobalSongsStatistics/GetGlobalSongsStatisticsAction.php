<?php

namespace App\Actions\LastFmGlobalSongsStatistics;

use App\Models\LastFmGlobalSongsStatistics;
use Illuminate\Support\Collection;

class GetGlobalSongsStatisticsAction
{
    public function execute(int $lastFmUserId, int $pagination): Collection
    {
        return LastFmGlobalSongsStatistics::latest()
            ->basicData()
            ->whereLastFmUserId($lastFmUserId)
            ->limit($pagination)
            ->get();
    }
}
