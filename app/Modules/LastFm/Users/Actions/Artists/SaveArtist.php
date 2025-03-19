<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Artists;

use App\Modules\LastFm\Users\Models\Artist;
use App\Services\Api\LastFm\DTO\ArtistDTO;

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
