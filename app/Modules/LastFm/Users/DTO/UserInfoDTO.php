<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\DTO;

use App\Traits\CastsAttributesTrait;
use App\Traits\DTO;
use Spatie\LaravelData\Data;

class UserInfoDTO // extends Data
{
    use CastsAttributesTrait, DTO;

    public function __construct(
        public string $name,
        public string $subscriber,
        public string $country,
        public string $url,
        public array $registered,
        public int $playcount,
        public int $artist_count,
        public int $track_count,
        public int $album_count,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? '',
            subscriber: $data['subscriber'] ?? '',
            country: $data['country'] ?? '',
            url: $data['url'] ?? '',
            registered: $data['registered'] ?? '',
            playcount: self::toInt($data['playcount']),
            artist_count: self::toInt($data['artist_count']),
            track_count: self::toInt($data['track_count']),
            album_count: self::toInt($data['album_count']),
        );
    }
}
