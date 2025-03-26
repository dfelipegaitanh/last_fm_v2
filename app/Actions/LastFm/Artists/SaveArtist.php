<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Artists;

use App\DTOs\LastFm\ArtistDTO;
use App\Models\LastFm\Artist;

readonly class SaveArtist
{
    public function handle(ArtistDTO $artistDTO): Artist
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
