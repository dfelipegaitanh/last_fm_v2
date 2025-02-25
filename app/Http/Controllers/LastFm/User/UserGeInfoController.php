<?php

namespace App\Http\Controllers\LastFm\User;

use App\Modules\LastFm\Users\Actions\Users\GetUserInfo;
use App\Services\LastFmService;

class UserGeInfoController
{
    public function __construct(
        private readonly LastFmService $lastFmUserService
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
