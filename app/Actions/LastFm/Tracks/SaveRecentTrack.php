<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Tracks;

use App\Models\LastFm\GlobalSongsStatistics;
use App\Models\User;
use App\Services\LastFm\Api\LastFmApi;

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
            artist: $recentTrack->artist->name,
            track: $recentTrack->name,
            username: $user->lastfm_user
        );

        $track = $this->saveTrack->handle($trackInfo);

        $statistics->track()->associate($track);
        $statistics->save();
    }
}
