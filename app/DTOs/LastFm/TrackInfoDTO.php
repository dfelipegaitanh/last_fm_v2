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
        public ArtistInfoDTO $artist,
        public ?AlbumDTO $album = null,
        public ?bool $loved = null,
        public ?bool $nowPlaying = false,
        //        public int $userPlaycount = 0,
        public int $playcount = 0,
    ) {}

    public static function fromApiResponse(?array $data): self
    {
        if ($data === null) {
            // Return a DTO with sensible fall-backs instead of crashing
            return self::fromParams([]);
        }

        return new self(
            name: $data['name'],
            mbid: $data['mbid'] ?? '',
            url: $data['url'],
            artist: ArtistInfoDTO::fromApiResponse($data['artist'] ?? []),
            album: isset($data['album']) ? AlbumDTO::fromApiResponse($data['album']) : null,
            loved: isset($data['userloved']) ? (bool) $data['userloved'] : null,
            nowPlaying: isset($data['@attr']['nowplaying']) && $data['@attr']['nowplaying'] === 'true',
            //            userPlaycount: isset($data['userplaycount']) ? (int) $data['userplaycount'] : 0,
            playcount: isset($data['playcount']) ? (int) $data['playcount'] : 0,
        );
    }

    public static function fromParams(array $data): self
    {
        return new self(
            name: $data['track'] ?? '',
            mbid: '',
            url: '',
            artist: ArtistInfoDTO::fromName($data['artist'] ?? ''),
            album: null,
            loved: null,
            nowPlaying: false,
            playcount: 0,
        );
    }
}
