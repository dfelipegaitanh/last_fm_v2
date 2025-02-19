<?php

namespace App\DTO\LastFm;

use Spatie\LaravelData\Data;

class UserInfoDto extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $subscriber,
        public ?string $country,
        public ?string $url,
        public ?array $registered,
    ) {}
}
