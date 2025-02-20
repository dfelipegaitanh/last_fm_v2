<?php

namespace App\Actions\LastFmGlobalSongsStatistics;

use App\Models\LastFmGlobalSongsStatistics;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGlobalSongsStatistics
{
    use AsAction;

    const int PAGINATION = 10;

    public function handle(): LengthAwarePaginator
    {

        return LastFmGlobalSongsStatistics::latest()
            ->basicData()
            ->whereLastFmUserId(auth()->user()->lastFmUser->id)
            ->paginate(perPage: self::PAGINATION)
            ->onEachSide(1);
    }
}
