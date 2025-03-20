<?php

namespace App\Modules\LastFm\Users\DTOs;

use App\Traits\DTO;
use App\Traits\ExcludedWordsTrait;

class SongInfoDTO
{
    use DTO;
    use ExcludedWordsTrait;

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
        $instance = new self(
            artist: $data['artist']['#text'] ?? $data['artist']['name'] ?? '',
            artist_mbid: $data['artist']['mbid'] ?? '',
            name: $data['name'] ?? '',
            mbid: $data['mbid'] ?? '',
            album: $data['album']['#text'] ?? $data['album']['title'] ?? '',
            album_mbid: $data['album']['mbid'] ?? '',
            url: $data['url'] ?? '',
        );

        $instance->name = $instance->cleanText($instance->name);
        $instance->album = $instance->cleanText($instance->album);

        return $instance;

    }
}
