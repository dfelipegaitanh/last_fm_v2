<?php

namespace App\Actions\LastFmUser;

use App\Actions\LastFmGlobalSongsStatistics\SaveGlobalSongsStatistics;
use App\DTO\LastFm\UserInfoDto;
use App\Models\LastFmUser;
use App\Services\LastFmService;
use Exception;
use Lorisleiva\Actions\Concerns\AsAction;

readonly class GetUserInfo
{
    use AsAction;

    public function __construct(
        protected LastFmService $lastFmService,
    ) {}

    /**
     * @throws Exception
     */
    public function handle(): void
    {

        $userInfo = $this->lastFmService
            ->userInfo();

        $userInfoDto = UserInfoDto::fromArray($userInfo);

        LastFmUser::firstOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'name' => $userInfoDto->name,
                'subscriber' => $userInfoDto->subscriber,
                'country' => $userInfoDto->country,
                'url' => $userInfoDto->url,
                'registered' => $userInfoDto->registered,
            ],
        );

        SaveGlobalSongsStatistics::run($userInfo);

    }
}
