<?php

namespace App\Http\Controllers\LastFm\User;

use App\Modules\LastFm\Users\Actions\Users\GetUserInfo;
use App\Services\LastFmService;

class UserGetInfoController
{
    public function __construct(
        private readonly LastFmService $lastFmUserService,
        private readonly GetUserInfo $getUserInfo
    ) {}

    public function __invoke()
    {
        $this->getUserInfo->handle();

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
