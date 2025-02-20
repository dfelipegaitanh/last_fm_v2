<?php

namespace App\DTO\LastFm;

use App\Models\LastFmUser;
use Spatie\LaravelData\Data;

class AuthenticatedUserDto extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $join_date,
        public ?string $total_scrobbles,
    ) {}

    public static function fromModel(LastFmUser $lastFmUser): self
    {

        $user = $lastFmUser->with('latestStatistic')
            ->firstOrFail();

        return new self(
            name: $user->name,
            join_date: $user->registered,
            total_scrobbles: $user->latestStatistic?->playcount ?? 0,
        );
    }
}
