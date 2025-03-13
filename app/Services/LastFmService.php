<?php

declare(strict_types=1);

namespace App\Services;

use App\Classes\Lastfm;
use App\Modules\LastFm\Users\DTO\SongInfoDTO;

readonly class LastFmService
{
    public function __construct(
        private Lastfm $lastfm,
    ) {}

    public function userInfo(): array
    {

        return $this->lastfm
            ->userInfo(
                auth()->user()->lastfm_user
            )->get();

    }

    public function userRecentTrack(): array
    {
        return $this->lastfm
            ->userRecentTrack(
                auth()->user()->lastfm_user
            )
            ->get();

    }

    public function trackGetInfo(array $song): array
    {

        $songDto = SongInfoDTO::fromArray($song);

        return $this->lastfm
            ->trackGetInfo(
                auth()->user()->lastfm_user,
                $songDto
            )
            ->get();
    }
}
