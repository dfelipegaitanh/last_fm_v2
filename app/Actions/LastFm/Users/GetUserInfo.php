<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Users;

use App\Actions\LastFm\Statistics\SaveGlobalSongsStatistics;
use App\Actions\LastFm\Tracks\SaveRecentTrack;
use App\Contracts\Actions\LastFm\Users\GetUserInfoInterface;
use App\DTOs\LastFm\UserInfoDTO;
use App\Models\LastFm\User as LastFmUser;
use App\Models\User;
use App\Services\LastFm\Api\LastFmApi;

/**
 * Action to synchronize user information from LastFm API and update global statistics.
 */
class GetUserInfo implements GetUserInfoInterface
{
    public function __construct(
        private LastFmApi $lastFmApi,
        private SaveGlobalSongsStatistics $saveGlobalSongsStatistics,
        private SaveRecentTrack $saveRecentTrack,
    ) {}

    public function handle(User $user): void
    {
        $userInfoDTO = $this->lastFmApi->getUserInfo($user->lastfm_user);

        $this->syncLastFmUser($user, $userInfoDTO);

        $statistics = $this->saveGlobalSongsStatistics->handle($user, $userInfoDTO);

        $this->saveRecentTrack->handle($user, $statistics);
    }

    private function syncLastFmUser(User $user, UserInfoDTO $userInfoDTO): void
    {
        LastFmUser::updateOrCreate(
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
