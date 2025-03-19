<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Models\User;
use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Modules\LastFm\Users\Models\Track;
use App\Services\Api\LastFm\LastFmApi;

readonly class SaveRecentTrack
{
    public function __construct(
        private LastFmApi $lastFmApi
    ) {}

    public function handle(User $user, GlobalSongsStatistics $statistics): void
    {
        $recentTracks = $this->lastFmApi->getRecentTracks(
            username: $user->lastfm_user,
            limit: 1
        );

        if ($recentTracks->isEmpty()) {
            return;
        }

        $recentTrack = $recentTracks->first();

        $trackInfo = $this->lastFmApi->getTrackInfo(
            artist: $recentTrack->artist,
            track: $recentTrack->name,
            username: $user->lastfm_user
        );

        // Guardar o actualizar el track
        Track::updateOrCreate(
            [
                'global_songs_statistics_id' => $statistics->id,
                'name' => $trackInfo->name,
                'artist' => $recentTrack->artist,
            ],
            [
                'url' => $trackInfo->url,
                'playcount' => $trackInfo->playcount,
                'user_playcount' => $trackInfo->userPlaycount,
            ]
        );
    }
}
