<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Tracks;

use App\DTOs\LastFm\TrackInfoDTO;
use App\Services\LastFm\Api\LastFmApi;

readonly class FetchTrackInfo
{
    public function __construct(
        private LastFmApi $lastFmApi,
    ) {}

    public function handle(string $username, string $artist, string $track): TrackInfoDTO
    {
        return $this->lastFmApi->getTrackInfo(
            artist: $artist,
            track: $track,
            username: $username
        );
    }
}
