<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Artists;

use App\DTOs\LastFm\ArtistInfoDTO;
use App\Services\LastFm\Api\LastFmApi;

readonly class FetchArtistInfo
{
    public function __construct(
        private LastFmApi $lastFmApi,
    ) {}

    public function handle(string $username, ArtistInfoDTO $artist): ArtistInfoDTO
    {

        return $this->lastFmApi->getArtistInfo(
            username: $username,
            artist: $artist->name,
            mbid: $artist->mbid
        );
    }
}
