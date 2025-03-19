<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Models\User;
use App\Modules\LastFm\Users\DTO\UserInfoDTO;
use App\Modules\LastFm\Users\Models\User as LastFmUser;
use App\Services\Api\LastFm\LastFmApi;

/**
 * Action to synchronize user information from LastFm API and update global statistics.
 */
readonly class GetUserInfo
{
    public function __construct(
        private LastFmApi $lastFmApi,
        private SaveGlobalSongsStatistics $saveGlobalSongsStatistics,
        //        private SaveRecentTrack $saveRecentTrack,
    ) {}

    public function handle(User $user): void
    {
        $userInfoDTO = $this->lastFmApi->getUserInfo($user->lastfm_user);

        $this->syncLastFmUser($user, $userInfoDTO);

        $this->saveGlobalSongsStatistics->handle($user, $userInfoDTO);

        //        $this->saveRecentTrack->handle($user, $statistics);
    }

    private function syncLastFmUser(User $user, UserInfoDTO $userInfoDTO): void
    {
        LastFmUser::firstOrCreate(
            ['user_id' => $user->id],
            $this->mapUserInfoToArray($userInfoDTO)
        );
    }

    private function mapUserInfoToArray(UserInfoDTO $userInfoDTO): array
    {
        return [
            'name' => $userInfoDTO->name,
            'subscriber' => $userInfoDTO->subscriber,
            'country' => $userInfoDTO->country,
            'url' => $userInfoDTO->url,
            'registered' => $userInfoDTO->registered,
        ];
    }
}
