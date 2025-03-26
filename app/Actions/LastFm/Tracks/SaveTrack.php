<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Tracks;

use App\Actions\LastFm\Albums\SaveAlbum;
use App\Actions\LastFm\Artists\SaveArtist;
use App\DTOs\LastFm\AlbumDTO;
use App\DTOs\LastFm\TrackInfoDTO;
use App\Models\LastFm\Track;

readonly class SaveTrack
{
    public function __construct(
        private SaveArtist $saveArtist,
        private SaveAlbum $saveAlbum,
    ) {}

    public function handle(TrackInfoDTO $trackInfo): Track
    {

        $artist = $this->saveArtist->handle($trackInfo->artist);

        $album = null;
        if ($trackInfo->album instanceof AlbumDTO) {
            $album = $this->saveAlbum->handle($trackInfo->album);
        }

        // Guardamos el track
        return Track::firstOrCreate(
            [
                'name' => $trackInfo->name,
                'artist_id' => $artist->id,
            ],
            [
                'mbid' => $trackInfo->mbid,
                'url' => $trackInfo->url,
                'album_id' => $album?->id,
            ]
        );
    }
}
