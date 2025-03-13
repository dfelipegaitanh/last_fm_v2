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
        public bool $subscriber,
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
            subscriber: filter_var($data['subscriber'] ?? false, FILTER_VALIDATE_BOOL),
            country: $data['country'] ?? '',
            url: $data['url'] ?? '',
            registered: is_array($data['registered'] ?? null) ? $data['registered'] : [],
            playcount: self::toInt($data['playcount']),
            artist_count: self::toInt($data['artist_count']),
            track_count: self::toInt($data['track_count']),
            album_count: self::toInt($data['album_count']),
        );
    }

    public function toStatisticsArray(): array
    {
        return [
            'playcount' => $this->playcount,
            'artist_count' => $this->artist_count,
            'album_count' => $this->album_count,
            'track_count' => $this->track_count,
        ];
    }
}
