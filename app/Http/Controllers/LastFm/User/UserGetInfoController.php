<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\User;

use App\Modules\LastFm\Users\Actions\Users\GetUserInfo;
use App\Services\LastFmUserService;

readonly class UserGetInfoController
{
    public function __construct(
        private LastFmUserService $lastFmUserService,
        private GetUserInfo $getUserInfo
    ) {}

    public function __invoke()
    {
        if (! auth()->user()) {
            return response()->json(['error' => 'User is not authenticated'], 401);
        }

        $user = auth()->user();

        $this->getUserInfo->handle($user);

        $authenticatedUser = $this->lastFmUserService->getAuthenticatedUserData();

        return response()->json($authenticatedUser);
    }
}
