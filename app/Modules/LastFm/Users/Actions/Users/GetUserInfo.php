<?php

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Modules\LastFm\Users\Actions\Users\SaveGlobalSongsStatistics;
use App\Modules\LastFm\Users\DTO\UserInfoDTO;
use App\Modules\LastFm\Users\Models\User;
use App\Services\LastFmService;
use Illuminate\Container\Attributes\CurrentUser;
use JetBrains\PhpStorm\NoReturn;
use Lorisleiva\Actions\Concerns\AsAction;

readonly class GetUserInfo
{
    use AsAction;

    private array $lastFmUserInfo;

    private array $userRecentTrack;

    #[NoReturn]
    public function __construct(
        private LastFmService $lastFmService,
        #[CurrentUser]
        private \App\Models\User $user,
    ) {
        $this->lastFmUserInfo = $this->lastFmService
            ->userInfo();

        $this->userRecentTrack = $this->lastFmService
            ->userRecentTrack();
        //        dd($this->userRecentTrack);
    }

    public function handle(): void
    {

        $this->syncLastFmUser();

        SaveGlobalSongsStatistics::run($this->lastFmUserInfo);
    }

    private function syncLastFmUser(): void
    {
        $userInfoDto = UserInfoDTO::from($this->lastFmUserInfo);

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
