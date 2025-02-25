<?php

namespace App\Modules\LastFm\Users\DTO;

use App\Traits\DTO;

class SongInfoDTO
{
    use DTO;

    public function __construct(
        public string $artist,
        public string $artist_mbid,
        public string $name,
        public string $mbid,
        public string $album,
        public string $album_mbid,
        public string $url,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            artist: $data['artist']['#text'] ?? '',
            artist_mbid: $data['artist']['mbid'] ?? '',
            name: $data['name'] ?? '',
            mbid: $data['mbid'] ?? '',
            album: $data['album']['#text'] ?? '',
            album_mbid: $data['album']['mbid'] ?? '',
            url: $data['url'] ?? '',
        );
    }
}
