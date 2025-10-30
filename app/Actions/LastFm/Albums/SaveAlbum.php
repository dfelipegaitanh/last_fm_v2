<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Albums;

use App\Actions\LastFm\Artists\SaveArtist;
use App\DTOs\LastFm\AlbumDTO;
use App\DTOs\LastFm\ArtistInfoDTO;
use App\Models\LastFm\Album;

readonly class SaveAlbum
{
    public function __construct(
        private SaveArtist $saveArtist,
    ) {}

    public function handle(AlbumDTO $albumDTO): Album
    {
        $artistDTO = new ArtistInfoDTO(
            name: $albumDTO->artist->name,
            url: '',
            mbid: '',
            playcount: 0,
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
