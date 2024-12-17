<?php

namespace App\Actions\LastFmUser;

use App\Models\LastFmUser;
use App\Models\User;
use App\Services\LastFmService;

class GetUserInfoAction
{
    protected LastFmService $lastFmService;

    public function __construct(LastFmService $lastFmService)
    {
        $this->lastFmService = $lastFmService;
    }

    /**
     * @throws \Exception
     */
    public function execute(string $lastFmUsername): LastFmUser
    {
        $userInfo = $this->lastFmService->userInfo($lastFmUsername);
        auth()->user()->can('saveLastFmUser', [User::class, $userInfo['name']]);

        return LastFmUser::firstOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'name'    => $userInfo['name'],
                'subscriber' => $userInfo['subscriber'],
                'country' => $userInfo['country'],
                'url'     => $userInfo['url'],
                'registered' => $userInfo['registered'],
            ],
        );
    }
}
