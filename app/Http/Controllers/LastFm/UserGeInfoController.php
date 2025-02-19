<?php

namespace App\Http\Controllers\LastFm;

use App\Actions\LastFmUser\GetUserInfo;

class UserGeInfoController
{
    public function __invoke()
    {
        GetUserInfo::run();

        $user = auth()->user()
            ->lastFmUser()
            ->with('latestStatistic')
            ->first();

        return response()->json([
            'name' => $user->name,
            'join_date' => $user->registered,
            'total_scrobbles' => $user->latestStatistic?->playcount ?? 0,
        ]);
    }
}
