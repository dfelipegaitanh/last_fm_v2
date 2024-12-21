<?php

namespace App\Actions\LastFmGlobalSongsStatistics;

use App\Models\LastFmGlobalSongsStatistics;
use App\Models\LastFmUser;

class GetGlobalSongsStatisticsAction
{

    public function execute(LastFmUser $lastFmUser, array $userInfo): void
    {
        $userInfo['last_fm_user_id'] = $lastFmUser->id;
        LastFmGlobalSongsStatistics::firstOrCreate(
            [
                'last_fm_user_id' => $userInfo['last_fm_user_id'],
                'playcount'       => $userInfo['playcount'],
                'artist_count'    => $userInfo['artist_count'],
                'track_count'     => $userInfo['track_count'],
                'album_count'     => $userInfo['album_count'],
            ], $userInfo,
        );
    }

}
