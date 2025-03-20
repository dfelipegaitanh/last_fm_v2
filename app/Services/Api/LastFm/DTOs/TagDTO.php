<?php

declare(strict_types=1);

namespace App\Services\Api\LastFm\DTOs;

use Spatie\LaravelData\Data;

class TagDTO extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $url,
        public readonly ?int $count = null,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name: $data['name'],
            url: $data['url'],
            count: isset($data['count']) ? (int) $data['count'] : null,
        );
    }
}
