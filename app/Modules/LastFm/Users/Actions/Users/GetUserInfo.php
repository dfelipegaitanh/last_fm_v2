<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Models\User;
use App\Modules\LastFm\Users\DTO\UserInfoDTO;
use App\Modules\LastFm\Users\Models\User as LastFmUser;
use App\Services\LastFmService;

readonly class GetUserInfo
{
    private array $lastFmUserInfo;

    public function __construct(
        private SaveGlobalSongsStatistics $saveGlobalSongsStatistics,
        private LastFmService $lastFmService
    ) {
        $this->lastFmUserInfo = $this->lastFmService->userInfo();
    }

    public function handle(User $user): void
    {
        $this->syncLastFmUser($user);

        $userInfoDTO = UserInfoDTO::fromArray($this->lastFmUserInfo);

        $this->saveGlobalSongsStatistics->handle($user, $userInfoDTO);
    }

    private function syncLastFmUser(User $user): void
    {

        $userInfoDto = UserInfoDTO::fromArray($this->lastFmUserInfo);

        LastFmUser::firstOrCreate(
            [
                'user_id' => $user->id,
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
