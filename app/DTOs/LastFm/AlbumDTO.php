<?php

declare(strict_types=1);

namespace App\DTOs\LastFm;

use Spatie\LaravelData\Data;

class AlbumDTO extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly ArtistDTO $artist,
        public readonly string $url,
        public readonly ?string $mbid = null,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        $artistData = $data['artist'] ?? [];
        
        // Handle string artist
        if (is_string($artistData)) {
            $artistData = [
                'name' => $artistData,
                'url' => '',
            ];
        }
        
        return new self(
            title: $data['title'] ?? '',
            artist: ArtistDTO::fromApiResponse($artistData),
            url: $data['url'] ?? '',
            mbid: $data['mbid'] ?? null,
        );
    }
}
