<?php

namespace App\Services;

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

        return [
            'name' => $user->name,
            'join_date' => $user->registered,
            'total_scrobbles' => $user->latestStatistic?->playcount ?? 0,
        ];
    }
}
