<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Albums;

use App\Actions\LastFm\Artists\SaveArtist;
use App\Models\LastFm\Album;
use App\DTOs\LastFm\AlbumDTO;
use App\DTOs\LastFm\ArtistDTO;

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
