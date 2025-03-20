<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\User;

use App\Actions\LastFm\Statistics\GetGlobalSongsStatistics;
use App\Http\Controllers\Controller;

class UserGetStatisticsController extends Controller
{
    public function __construct(
        private readonly GetGlobalSongsStatistics $getSongsStatistics
    ) {}

    public function __invoke()
    {

        return response()->json(
            $this->getSongsStatistics->handle()
        );
    }
}
