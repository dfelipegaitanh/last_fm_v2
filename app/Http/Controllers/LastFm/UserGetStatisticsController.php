<?php

namespace App\Http\Controllers\LastFm;

use App\Actions\LastFmGlobalSongsStatistics\GetGlobalSongsStatistics;
use App\Http\Controllers\Controller;

class UserGetStatisticsController extends Controller
{
    public function __invoke()
    {

        return response()->json(
            GetGlobalSongsStatistics::run()
        );
    }
}
