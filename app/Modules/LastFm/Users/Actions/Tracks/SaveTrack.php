<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Tracks;

use App\Modules\LastFm\Users\Actions\Albums\SaveAlbum;
use App\Modules\LastFm\Users\Actions\Artists\SaveArtist;
use App\Modules\LastFm\Users\Models\Track;
use App\Services\Api\LastFm\DTO\AlbumDTO;
use App\Services\Api\LastFm\DTO\TrackInfoDTO;

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
