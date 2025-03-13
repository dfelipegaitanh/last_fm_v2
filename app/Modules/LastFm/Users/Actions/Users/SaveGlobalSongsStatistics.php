<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Models\User;
use App\Modules\LastFm\Users\DTO\UserInfoDTO;
use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Services\LastFmService;
use Illuminate\Support\Arr;

readonly class SaveGlobalSongsStatistics
{
    public function __construct(
        private LastFmService $lastFmService)
    {
        $this->lastFmService
            ->userRecentTrack();
    }

    public function handle(User $user, UserInfoDTO $dto): void
    {

        GlobalSongsStatistics::firstOrCreate(
            $this->buildSearchAttributes($user, $dto),
            $dto->toArray()
        );
    }

    private function buildSearchAttributes(User $user, UserInfoDTO $dto): array
    {

        return Arr::add(
            $dto->toStatisticsArray(),
            'last_fm_user_id',
            $user->lastFmUser->id
        );
    }
}
