<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Tracks;

use App\Modules\LastFm\Users\Models\Track;
use App\Services\Api\LastFm\DTO\TrackInfoDTO;

readonly class SaveTrack
{
    public function handle(TrackInfoDTO $trackInfo): Track
    {
        return Track::firstOrCreate(
            [
                'name' => $trackInfo->name,
                'artist' => $trackInfo->artist,
            ],
            [
                'mbid' => $trackInfo->mbid,
                'url' => $trackInfo->url,
            ]
        );
    }
}
