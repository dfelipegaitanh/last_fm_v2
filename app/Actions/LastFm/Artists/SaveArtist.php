<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Artists;

use App\DTOs\LastFm\ArtistDTO;
use App\DTOs\LastFm\ArtistInfoDTO;
use App\Models\LastFm\Artist;

readonly class SaveArtist
{
    public function handle(ArtistInfoDTO $artistDTO): Artist
    {
        return Artist::firstOrCreate(
            ['name' => $artistDTO->name],
            [
                'mbid' => $artistDTO->mbid,
                'url' => $artistDTO->url,
            ]
        );
    }
}
