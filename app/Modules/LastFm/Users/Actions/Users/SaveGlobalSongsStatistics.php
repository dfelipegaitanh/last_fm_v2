<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Models\User;
use App\Modules\LastFm\Users\DTO\StatisticsDTO;
use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Services\LastFmService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Arr;

readonly class SaveGlobalSongsStatistics
{
    public function __construct(#[CurrentUser]
    private User $user, private LastFmService $lastFmService)
    {
        $this->lastFmService
            ->userRecentTrack();
    }

    public function handle(array $userInfo): void
    {
        $dto = StatisticsDTO::fromArray($userInfo);

        dd($dto);
        GlobalSongsStatistics::firstOrCreate(
            $this->buildSearchAttributes($dto),
            $dto->toArray()
        );
    }

    private function buildSearchAttributes(StatisticsDTO $dto): array
    {
        return Arr::add(
            $dto->toArray(),
            'last_fm_user_id',
            $this->user->lastFmUser->id
        );
    }
}
