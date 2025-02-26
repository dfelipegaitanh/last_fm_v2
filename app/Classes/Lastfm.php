<?php

namespace App\Classes;

use App\Modules\LastFm\Users\DTO\SongInfoDTO;

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

    public function trackGetInfo(string $username, SongInfoDTO $songInfoDTO): self
    {
        $this->query = array_merge($this->query, [
            'method' => 'track.getInfo',
            'username' => $username,
            'artist' => $songInfoDTO->artist,
            'track' => $songInfoDTO->name,
            'autocorrect' => 1,
        ]);

        $this->pluck = 'track';

        return $this;
    }
}
