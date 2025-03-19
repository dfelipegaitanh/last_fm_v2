<?php

declare(strict_types=1);

namespace App\Services\Api\LastFm\DTO;

readonly class TrackInfoDTO
{
    public function __construct(
        public string $name,
        public string $mbid,
        public string $url,
        //        public int $duration,
        //        public bool $streamable,
        //        public int $listeners,
        //        public int $playcount,
        public ArtistDTO $artist,
        public ?AlbumDTO $album = null,
        //        public ?int $userPlaycount = null,
        public ?bool $loved = null,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'],
            mbid: $data['mbid'] ?? '',
            url: $data['url'],
            //            duration: (int) ($data['duration'] ?? 0),
            //            streamable: (bool) ($data['streamable']['#text'] ?? false),
            //            listeners: (int) ($data['listeners'] ?? 0),
            //            playcount: (int) ($data['playcount'] ?? 0),
            artist: ArtistDTO::fromApiResponse($data['artist']),
            album: isset($data['album']) ? AlbumDTO::fromApiResponse($data['album']) : null,
            //            userPlaycount: isset($data['userplaycount']) ? (int) $data['userplaycount'] : null,
            loved: isset($data['userloved']) ? (bool) $data['userloved'] : null,
        );
    }
}
