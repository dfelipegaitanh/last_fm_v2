<?php

namespace App\Actions\LastFmGlobalSongsStatistics;

use App\Models\LastFmGlobalSongsStatistics;

class SaveGlobalSongsStatisticsAction
{
    public function execute(array $userInfo): void
    {
        dd(auth()->user()->lastfmUser); //()->statistics);
        LastFmGlobalSongsStatistics::firstOrCreate(
            [
                'last_fm_user_id' => auth()->user()->lastFmUser->id,
                'playcount' => $userInfo['playcount'] ?? 0,
                'artist_count' => $userInfo['artist_count'] ?? 0,
                'track_count' => $userInfo['track_count'] ?? 0,
                'album_count' => $userInfo['album_count'] ?? 0,
            ],
            $userInfo,
        );

        auth()->user()->lastfmUser()->statistics->save($stats);

    }
}
