<?php

namespace App\Modules\LastFm\Users\DTO;

use Spatie\LaravelData\Data;

class UserInfoDTO extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $subscriber,
        public ?string $country,
        public ?string $url,
        public ?array $registered,
    ) {}
}
