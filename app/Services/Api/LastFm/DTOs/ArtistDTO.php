<?php

declare(strict_types=1);

namespace App\Services\Api\LastFm\DTOs;

use Spatie\LaravelData\Data;

class ArtistDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $url,
        public readonly ?string $mbid = null,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? $data['#text'] ?? '',
            url: $data['url'],
            mbid: $data['mbid'] ?? null,
        );
    }
}
