<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Artists;

use App\Models\LastFm\Artist;
use App\DTOs\LastFm\ArtistDTO;

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
