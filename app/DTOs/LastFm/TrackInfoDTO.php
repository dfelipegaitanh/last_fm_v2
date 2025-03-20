<?php

declare(strict_types=1);

namespace App\DTOs\LastFm;

use Spatie\LaravelData\Data;

class TrackInfoDTO extends Data
{
    public function __construct(
        public string $name,
        public string $mbid,
        public string $url,
        public ArtistDTO $artist,
        public ?AlbumDTO $album = null,
        public ?bool $loved = null,
        public ?bool $nowPlaying = false,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'],
            mbid: $data['mbid'] ?? '',
            url: $data['url'],
            artist: ArtistDTO::fromApiResponse($data['artist'] ?? []),
            album: isset($data['album']) ? AlbumDTO::fromApiResponse($data['album']) : null,
            loved: isset($data['userloved']) ? (bool) $data['userloved'] : null,
            nowPlaying: isset($data['@attr']['nowplaying']) && $data['@attr']['nowplaying'] === 'true',
        );
    }
}
