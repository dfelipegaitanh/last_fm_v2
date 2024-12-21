<?php

namespace App\Actions\LastFmUser;

use App\Actions\LastFmGlobalSongsStatistics\SaveGlobalSongsStatisticsAction;
use App\Models\LastFmUser;
use App\Models\User;
use App\Services\LastFmService;

class GetUserInfoAction
{
    protected LastFmService $lastFmService;
    protected SaveGlobalSongsStatisticsAction $saveGlobalSongsStatisticsAction;

    public function __construct(
        LastFmService $lastFmService,
        SaveGlobalSongsStatisticsAction $saveGlobalSongsStatisticsAction
    )
    {
        $this->lastFmService = $lastFmService;
        $this->saveGlobalSongsStatisticsAction = $saveGlobalSongsStatisticsAction;
    }

    /**
     * @throws \Exception
     */
    public function execute(string $lastFmUsername): LastFmUser
    {
        $userInfo = $this->lastFmService->userInfo($lastFmUsername);
        auth()->user()->can('saveLastFmUser', [User::class, $userInfo['name']]);

        $lastFmUser = LastFmUser::firstOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'name'    => $userInfo['name'],
                'subscriber' => $userInfo['subscriber'],
                'country' => $userInfo['country'],
                'url'     => $userInfo['url'],
                'registered' => $userInfo['registered'],
            ],
        );

        $this->saveGlobalSongsStatisticsAction->execute($lastFmUser->id, $userInfo);

        return $lastFmUser;
    }
}
