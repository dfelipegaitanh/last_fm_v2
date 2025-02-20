<?php

namespace App\Actions\LastFmUser;

use App\Actions\LastFmGlobalSongsStatistics\SaveGlobalSongsStatistics;
use App\DTO\LastFm\UserInfoDto;
use App\Models\LastFmUser;
use App\Models\User;
use App\Services\LastFmService;
use Illuminate\Container\Attributes\CurrentUser;
use Lorisleiva\Actions\Concerns\AsAction;

readonly class GetUserInfo
{
    use AsAction;

    private array $lastFmUserInfo;

    private array $userRecentTrack;

    public function __construct(
        private LastFmService $lastFmService,
        #[CurrentUser]
        private User $user,
    ) {
        $this->lastFmUserInfo = $this->lastFmService
            ->userInfo();

        $this->userRecentTrack = $this->lastFmService
            ->userRecentTrack();
        dd($this->userRecentTrack);
    }

    public function handle(): void
    {

        $this->syncLastFmUser();

        SaveGlobalSongsStatistics::run($this->lastFmUserInfo);
    }

    private function syncLastFmUser(): void
    {
        $userInfoDto = UserInfoDto::from($this->lastFmUserInfo);

        LastFmUser::firstOrCreate(
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
