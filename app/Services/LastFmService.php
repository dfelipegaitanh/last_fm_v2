<?php

namespace App\Services;

use App\Classes\Lastfm;
use App\Models\User;
use App\Modules\LastFm\Users\DTO\SongInfoDTO;
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

    public function userRecentTrack(): array
    {
        return $this->lastfm
            ->userRecentTrack(
                $this->user->lastfm_user
            )
            ->get();

    }

    public function trackGetInfo(array $song): array
    {

        $songDto = SongInfoDTO::fromArray($song);

        return $this->lastfm
            ->getRecentTrack(
                $this->user->lastfm_user,
                $songDto
            )
            ->get();
    }
}
