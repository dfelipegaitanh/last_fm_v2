<?php

namespace App\Services;

use Barryvanveen\Lastfm\Lastfm;

readonly class LastFmService
{
    public function __construct(
        private Lastfm $lastfm
    ) {
    }

    public function userInfo(): array
    {
        return $this->lastfm
            ->userInfo(
                auth()->user()->lastfm_user
            )->get();

    }
}
