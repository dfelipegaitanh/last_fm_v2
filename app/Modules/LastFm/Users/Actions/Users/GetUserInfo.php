<?php

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Modules\LastFm\Users\DTO\UserInfoDTO;
use App\Modules\LastFm\Users\Models\User;
use App\Services\LastFmService;
use Illuminate\Container\Attributes\CurrentUser;
use JetBrains\PhpStorm\NoReturn;

readonly class GetUserInfo
{
    private array $lastFmUserInfo;

    private array $song;

    #[NoReturn]
    public function __construct(
        private LastFmService $lastFmService,
        #[CurrentUser]
        private \App\Models\User $user,
        private SaveGlobalSongsStatistics $saveGlobalSongsStatistics,
    ) {
        $this->lastFmUserInfo = $this->lastFmService
            ->userInfo();

        $userRecentTrack = $this->lastFmService
            ->userRecentTrack();

        $this->song = $this->lastFmService
            ->trackGetInfo(
                $userRecentTrack
            );

    }

    public function handle(): void
    {

        $this->syncLastFmUser();

        $this->saveGlobalSongsStatistics->handle($this->lastFmUserInfo);
    }

    private function syncLastFmUser(): void
    {

        $userInfoDto = UserInfoDTO::fromArray($this->lastFmUserInfo);

        User::firstOrCreate(
            [
                'user_id' => $this->user->id,
            ],
            [
                'name' => $userInfoDto->name,
                'subscriber' => $userInfoDto->subscriber,
                'country' => $userInfoDto->country,
                'url' => $userInfoDto->url,
                'registered' => $userInfoDto->registered,
            ]
        );
    }
}
