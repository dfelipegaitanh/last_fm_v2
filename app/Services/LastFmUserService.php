<?php

namespace App\Services;

use App\Models\User;
use App\Modules\LastFm\Users\DTOs\AuthenticatedUserDTO;
use Illuminate\Container\Attributes\CurrentUser;

class LastFmUserService
{
    public function __construct(
        #[CurrentUser]
        private User $user,
    ) {}

    public function getAuthenticatedUserData(): array
    {
        $lastFmUser = $this->user
            ->lastFmUser;

        return AuthenticatedUserDTO::fromModel($lastFmUser)
            ->toArray();
    }
}
