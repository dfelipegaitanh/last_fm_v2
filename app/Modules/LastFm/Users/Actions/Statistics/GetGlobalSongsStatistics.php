<?php

namespace App\Modules\LastFm\Users\Actions\Statistics;

use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GetGlobalSongsStatistics
{
    const int PAGINATION = 10;

    public function handle(): LengthAwarePaginator
    {

        return GlobalSongsStatistics::latest()
            ->basicData()
            ->whereLastFmUserId(auth()->user()->lastFmUser->id)
            ->paginate(perPage: self::PAGINATION)
            ->onEachSide(1);
    }
}
