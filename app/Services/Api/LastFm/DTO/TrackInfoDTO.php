<?php

declare(strict_types=1);

namespace App\Services\Api\LastFm\DTO;

use Carbon\Carbon;

readonly class TrackInfoDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $mbid,
        public string $url,
        public int $duration,
        public bool $streamable,
        public int $listeners,
        public int $playcount,
        //        public ArtistDTO $artist,
        //        public ?AlbumDTO $artistlbum,
        //        public array $tags,
        public ?Carbon $published = null,
        public ?string $summary = null,
        public ?string $content = null,
        public ?int $userPlaycount = null,
        public ?bool $loved = null,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            name: $data['name'],
            mbid: $data['mbid'] ?? '',
            url: $data['url'],
            duration: (int) ($data['duration'] ?? 0),
            streamable: (bool) ($data['streamable']['#text'] ?? false),
            listeners: (int) ($data['listeners'] ?? 0),
            playcount: (int) ($data['playcount'] ?? 0),
            //            artist: ArtistDTO::fromApiResponse($data['artist']),
            //            album: isset($data['album']) ? AlbumDTO::fromApiResponse($data['album']) : null,
            //            tags: array_map(
            //                fn (array $tag): TagDTO => TagDTO::fromApiResponse($tag),
            //                $data['toptags']['tag'] ?? []
            //            ),
            published: isset($data['wiki']['published']) ? Carbon::parse($data['wiki']['published']) : null,
            summary: $data['wiki']['summary'] ?? null,
            content: $data['wiki']['content'] ?? null,
            userPlaycount: isset($data['userplaycount']) ? (int) $data['userplaycount'] : null,
            loved: isset($data['userloved']) ? (bool) $data['userloved'] : null,
        );
    }
}
