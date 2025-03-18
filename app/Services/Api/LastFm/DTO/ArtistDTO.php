<?php

declare(strict_types=1);

namespace App\Services\Api\LastFm\DTO;

use Spatie\LaravelData\Data;

class ArtistDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly int $playcount,
        public readonly string $url,
        public readonly array $image,
        public readonly ?string $mbid = null,
        public readonly ?string $streamable = null,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'] ?? $data['#text'] ?? '',
            playcount: (int) ($data['playcount'] ?? 0),
            url: $data['url'],
            image: $data['image'] ?? [],
            mbid: $data['mbid'] ?? null,
            streamable: $data['streamable'] ?? null,
        );
    }
}
