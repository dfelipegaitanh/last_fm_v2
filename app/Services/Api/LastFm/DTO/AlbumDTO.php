<?php

declare(strict_types=1);

namespace App\Services\Api\LastFm\DTO;

use Spatie\LaravelData\Data;

class AlbumDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $artist,
        public readonly int $playcount,
        public readonly string $url,
        public readonly array $image,
        public readonly ?string $mbid = null,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'],
            artist: $data['artist']['name'] ?? $data['artist']['#text'] ?? $data['artist'],
            playcount: (int) ($data['playcount'] ?? 0),
            url: $data['url'],
            image: $data['image'] ?? [],
            mbid: $data['mbid'] ?? null,
        );
    }
}
