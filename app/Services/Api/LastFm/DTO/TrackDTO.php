<?php

declare(strict_types=1);

namespace App\Services\Api\LastFm\DTO;

use Spatie\LaravelData\Data;

class TrackDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $artist,
        public readonly string $url,
        public readonly ?string $mbid,
        public readonly array $image,
        public readonly ?array $date,
        public readonly ?bool $nowPlaying = false,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'],
            artist: $data['artist']['#text'] ?? $data['artist'],
            url: $data['url'],
            mbid: $data['mbid'] ?? null,
            image: $data['image'] ?? [],
            date: $data['date'] ?? null,
            nowPlaying: isset($data['@attr']['nowplaying']) && $data['@attr']['nowplaying'] === 'true',
        );
    }
}
