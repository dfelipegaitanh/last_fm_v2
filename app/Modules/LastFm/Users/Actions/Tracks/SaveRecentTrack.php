<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Tracks;

use App\Models\User;
use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Modules\LastFm\Users\Models\Track;
use App\Services\Api\LastFm\LastFmApi;

readonly class SaveRecentTrack
{
    public function __construct(
        private LastFmApi $lastFmApi,
        private SaveTrack $saveTrack,
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

        // Primero guardamos o recuperamos el track
        $track = $this->saveTrack->handle($trackInfo);

        // Actualizamos las estadísticas con el track
        $statistics->track()->associate($track);
        $statistics->save();
    }
}
