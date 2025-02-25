<?php

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Modules\LastFm\Users\Models\GlobalSongsStatistics;
use App\Models\User;
use App\Modules\LastFm\Users\DTO\StatisticsDTO;
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
