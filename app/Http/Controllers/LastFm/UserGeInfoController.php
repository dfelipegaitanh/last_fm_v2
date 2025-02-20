<?php

namespace App\Http\Controllers\LastFm;

use App\Actions\LastFmUser\GetUserInfo;
use App\Services\LastFmService;

readonly class UserGeInfoController
{
    public function __construct(
        private LastFmService $lastFmUserService
    ) {}

    public function __invoke()
    {
        GetUserInfo::run();

        return response()
            ->json(
                $this->getUserData()
            );
    }

    private function getUserData(): array
    {
        return $this->lastFmUserService
            ->getAuthenticatedUserData();
    }
}
