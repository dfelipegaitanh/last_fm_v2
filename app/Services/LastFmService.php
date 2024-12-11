<?php

namespace App\Services;

use Barryvanveen\Lastfm\Lastfm;

class LastFmService
{
    private Lastfm $lastfm;

    public function __construct(Lastfm $lastfm)
    {
        $this->lastfm = $lastfm;
    }

    public function userInfo(string $userName)
    {
        return $this->lastfm->userInfo(username: $userName)->get();

    }
}
