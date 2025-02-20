<?php

namespace App\Services;

use App\DTO\LastFm\AuthenticatedUserDto;
use App\Models\User;
use Barryvanveen\Lastfm\Lastfm;
use Illuminate\Container\Attributes\CurrentUser;

readonly class LastFmService
{
    public function __construct(
        private Lastfm $lastfm,
        #[CurrentUser]
        private User $user,
    ) {}

    public function userInfo(): array
    {

        return $this->lastfm
            ->userInfo(
                $this->user->lastfm_user
            )->get();

    }

    public function getAuthenticatedUserData(): array
    {
        $lastFmUser = $this->user
            ->lastFmUser;

        return AuthenticatedUserDto::fromModel($lastFmUser)
            ->toArray();
    }
}
