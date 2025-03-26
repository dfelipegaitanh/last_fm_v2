<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Statistics;

use App\DTOs\LastFm\UserInfoDTO;
use App\Models\LastFm\GlobalSongsStatistics;
use App\Models\User;
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
            'user_id',
            $user->lastFmUser?->id ?? 0
        );
    }
}
