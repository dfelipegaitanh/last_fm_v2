<?php

declare(strict_types=1);

namespace App\DTOs\LastFm;

use Spatie\LaravelData\Data;

class ArtistInfoDTO extends Data
{
    public function __construct(
        public string $name,
        public string $mbid,
        public string $url,
        public int $playcount,
    ) {}

    public static function fromApiResponse(?array $data): self
    {

        return new self(
            name: $data['name'] ?? $data['#text'] ?? '',
            mbid: $data['mbid'] ?? '',
            url: $data['url'] ?? '',
            playcount: (int) ($data['playcount'] ?? 0),
        );

    }

    public static function fromName(string $name): self
    {
        return new self(
            name: $name,
            mbid: '',
            url: '',
            playcount: 0,
        );
    }
}
