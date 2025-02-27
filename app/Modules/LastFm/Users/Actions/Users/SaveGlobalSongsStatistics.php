<?php

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Models\User;
use App\Modules\LastFm\Users\DTO\StatisticsDTO;
use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Services\LastFmService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Arr;

readonly class SaveGlobalSongsStatistics
{
    private array $song;

    public function __construct(
        #[CurrentUser]
        private User $user,
        private LastFmService $lastFmService,
    ) {
        $userRecentTrack = $this->lastFmService
            ->userRecentTrack();

        $this->song = $this->lastFmService
            ->trackGetInfo(
                $userRecentTrack
            );

    }

    public function handle(array $userInfo): void
    {
        $dto = StatisticsDTO::fromArray($userInfo);
        $attributes = $dto->toArray();

        GlobalSongsStatistics::firstOrCreate(
            $this->buildSearchAttributes($attributes),
            $attributes
        );
    }

    private function buildSearchAttributes(array $attributes): array
    {
        return Arr::add(
            $attributes,
            'last_fm_user_id',
            $this->user->lastFmUser->id
        );
    }
}
