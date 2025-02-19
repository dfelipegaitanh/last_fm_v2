<?php

namespace App\Services;

use App\DTO\LastFm\AuthenticatedUserDTO;
use Barryvanveen\Lastfm\Lastfm;

readonly class LastFmService
{
    public function __construct(
        private Lastfm $lastfm
    ) {}

    public function userInfo(): array
    {
        return $this->lastfm
            ->userInfo(
                auth()->user()->lastfm_user
            )->get();

    }

    public function getAuthenticatedUserData(): array
    {
        $user = auth()->user()
            ->lastFmUser()
            ->with('latestStatistic')
            ->firstOrFail();

        return AuthenticatedUserDTO::fromModel($user)
            ->toArray();
    }
}
