<?php

namespace App\Actions\LastFmGlobalSongsStatistics;

use App\DTO\LastFm\StatisticsDto;
use App\Models\LastFmGlobalSongsStatistics;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;

readonly class SaveGlobalSongsStatistics
{
    use AsAction;

    public function __construct(
        #[CurrentUser]
        private User $user,
    ) {}

    public function handle(array $userInfo): void
    {
        $dto = StatisticsDto::fromArray($userInfo);
        $attributes = $dto->toArray();

        LastFmGlobalSongsStatistics::firstOrCreate(
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
