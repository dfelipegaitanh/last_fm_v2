<?php

namespace App\Modules\LastFm\Users\DTO;

use App\Traits\DTO;

readonly class StatisticsDTO
{
    use DTO;

    public function __construct(
        public int $playcount,
        public int $artist_count,
        public int $track_count,
        public int $album_count
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            playcount: self::toInt($data['playcount'] ?? 0),
            artist_count: self::toInt($data['artist_count'] ?? 0),
            track_count: self::toInt($data['track_count'] ?? 0),
            album_count: self::toInt($data['album_count'] ?? 0)
        );
    }

    private static function toInt(mixed $value): int
    {
        return is_numeric($value) ? (int) $value : 0;
    }
}
