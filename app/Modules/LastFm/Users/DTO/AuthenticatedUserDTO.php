<?php

namespace App\Modules\LastFm\Users\DTO;

use App\Modules\LastFm\Users\Models\User;
use App\Traits\DTO;

class AuthenticatedUserDTO
{
    use DTO;

    public function __construct(
        public ?string $name,
        public ?string $join_date,
        public ?string $total_scrobbles,
    ) {}

    public static function fromModel(User $lastFmUser): self
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
