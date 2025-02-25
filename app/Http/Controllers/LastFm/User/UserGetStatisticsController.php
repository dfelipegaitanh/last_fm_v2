<?php

namespace App\Http\Controllers\LastFm\User;

use App\Modules\LastFm\Users\Actions\Users\GetGlobalSongsStatistics;
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
