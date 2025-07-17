<?php

declare(strict_types=1);

namespace App\Contracts\Actions\LastFm\Statistics;

use Illuminate\Pagination\LengthAwarePaginator;

interface GetGlobalSongsStatisticsInterface
{
    public function handle(): LengthAwarePaginator;
}
