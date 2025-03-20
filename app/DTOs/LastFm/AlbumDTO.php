<?php

declare(strict_types=1);

namespace App\DTOs\LastFm;

use Spatie\LaravelData\Data;

class AlbumDTO extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly string $artist,
        public readonly string $url,
        public readonly ?string $mbid = null,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            title: $data['title'] ?? '',
            artist: $data['artist']['name'] ?? $data['artist']['#text'] ?? $data['artist'] ?? '',
            url: $data['url'] ?? '',
            mbid: $data['mbid'] ?? null,
        );
    }
}
