<?php

namespace App\Classes;

class Lastfm extends \Barryvanveen\Lastfm\Lastfm
{
    public function userRecentTrack(string $username): self
    {
        $this->query = array_merge($this->query, [
            'method' => 'user.getRecentTracks',
            'user' => $username,
            'limit' => 1,
        ]);

        $this->pluck = 'recenttracks.track.0';

        return $this;
    }
}
