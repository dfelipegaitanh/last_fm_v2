<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Statistics;

use App\Contracts\Actions\LastFm\Statistics\GetGlobalSongsStatisticsInterface;
use App\Models\LastFm\GlobalSongsStatistics;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GetGlobalSongsStatistics implements GetGlobalSongsStatisticsInterface
{
    public const int PAGINATION = 10;

    public function handle(): LengthAwarePaginator
    {
        return GlobalSongsStatistics::latest()
            ->with([
                'track.artist',
                'track.album',
            ])
            ->basicData()
            ->whereUserId(auth()->user()->lastFmUser->id)
            ->paginate(perPage: self::PAGINATION)
            ->onEachSide(1);
    }
}
