<?php

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGlobalSongsStatistics
{
    use AsAction;

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
