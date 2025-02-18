<?php

namespace App\Actions\LastFmUser;

use App\Actions\LastFmGlobalSongsStatistics\SaveGlobalSongsStatistics;
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

        LastFmUser::firstOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'name' => $userInfo['name'],
                'subscriber' => $userInfo['subscriber'],
                'country' => $userInfo['country'],
                'url' => $userInfo['url'],
                'registered' => $userInfo['registered'],
            ],
        );

        SaveGlobalSongsStatistics::run($userInfo);

    }
}
