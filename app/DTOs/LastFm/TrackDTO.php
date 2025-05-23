<?php

declare(strict_types=1);

namespace App\DTOs\LastFm;

use Spatie\LaravelData\Data;

class TrackDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly ArtistDTO $artist,
        public readonly string $url,
        public readonly string $mbid,
        public readonly ?array $date,
        public readonly bool $nowPlaying,
        public readonly int $playcount,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'],
            artist: ArtistDTO::fromApiTrackResponse($data['artist']),
            url: $data['url'],
            mbid: $data['mbid'] ?? '',
            date: $data['date'] ?? null,
            nowPlaying: isset($data['@attr']['nowplaying']) && ($data['@attr']['nowplaying'] === 'true'),
            playcount: (int) ($data['playcount'] ?? 0),
        );
    }
}
