<?php

declare(strict_types=1);

namespace App\Services\Api\LastFm\DTO;

use Spatie\LaravelData\Data;

class UserInfoDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $realname,
        public readonly string $url,
        public readonly string $country,
        public readonly int $playcount,
        public readonly int $playlists,
        public readonly array $image,
        public readonly array $registered,
        public readonly string $type,
        public readonly string $gender,
        public readonly bool $subscriber,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'],
            realname: $data['realname'],
            url: $data['url'],
            country: $data['country'],
            playcount: (int) $data['playcount'],
            playlists: (int) $data['playlists'],
            image: $data['image'],
            registered: $data['registered'],
            type: $data['type'],
            gender: $data['gender'],
            subscriber: (bool) $data['subscriber'],
        );
    }
}
