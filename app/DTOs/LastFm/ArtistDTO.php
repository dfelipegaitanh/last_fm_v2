<?php

declare(strict_types=1);

namespace App\DTOs\LastFm;

use Spatie\LaravelData\Data;

class ArtistDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $url,
        public readonly string $mbid,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? $data['#text'] ?? '',
            url: $data['url'] ?? '',
            mbid: $data['mbid'] ?? '',
        );
    }

    public static function fromApiTrackResponse(array $data): self
    {
        return new self(
            name: $data['#text'] ?? '',
            url: $data['url'] ?? '',
            mbid: $data['mbid'] ?? '',
        );
    }
}
