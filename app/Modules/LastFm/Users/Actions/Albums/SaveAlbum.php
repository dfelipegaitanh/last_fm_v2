<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Albums;

use App\Modules\LastFm\Users\Actions\Artists\SaveArtist;
use App\Modules\LastFm\Users\Models\Album;
use App\Services\Api\LastFm\DTO\AlbumDTO;
use App\Services\Api\LastFm\DTO\ArtistDTO;

readonly class SaveAlbum
{
    public function __construct(
        private SaveArtist $saveArtist,
    ) {}

    public function handle(AlbumDTO $albumDTO): Album
    {
        $artistDTO = new ArtistDTO(
            name: $albumDTO->artist,
            url: '',
            mbid: '',
        );

        $artist = $this->saveArtist->handle($artistDTO);

        return Album::firstOrCreate(
            [
                'title' => $albumDTO->title,
                'artist_id' => $artist->id,
            ],
            [
                'mbid' => $albumDTO->mbid,
                'url' => $albumDTO->url,
            ]
        );
    }
}
