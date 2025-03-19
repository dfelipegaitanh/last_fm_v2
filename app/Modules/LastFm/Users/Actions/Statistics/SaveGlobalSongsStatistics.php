<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Statistics;

use App\Models\User;
use App\Modules\LastFm\Users\DTO\UserInfoDTO;
use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Services\Api\LastFm\LastFmApi;
use Illuminate\Support\Arr;

readonly class SaveGlobalSongsStatistics
{
    public function handle(User $user, UserInfoDTO $userInfoDTO): GlobalSongsStatistics
    {
        return GlobalSongsStatistics::firstOrCreate(
            $this->buildSearchAttributes($user, $userInfoDTO),
            $userInfoDTO->toArray()
        );
    }

    private function buildSearchAttributes(User $user, UserInfoDTO $userInfoDTO): array
    {
        return Arr::add(
            $userInfoDTO->toStatisticsArray(),
            'last_fm_user_id',
            $user->lastFmUser?->id ?? 0
        );
    }
}
