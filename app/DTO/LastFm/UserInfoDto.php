<?php

namespace App\DTO\LastFm;

class UserInfoDto
{
    public function __construct(
        public ?string $name,
        public ?string $subscriber,
        public ?string $country,
        public ?string $url,
        public ?array $registered,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            subscriber: $data['subscriber'] ?? null,
            country: $data['country'] ?? null,
            url: $data['url'] ?? null,
            registered: $data['registered'] ?? [],
        );
    }
}
