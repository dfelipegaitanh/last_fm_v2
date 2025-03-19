<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\User;

use App\Models\User;
use App\Modules\LastFm\Users\Actions\Users\GetUserInfo;
use App\Modules\LastFm\Users\DTO\AuthenticatedUserDTO;
use Illuminate\Http\JsonResponse;

readonly class UserGetInfoController
{
    public function __construct(
        private GetUserInfo $getUserInfo
    ) {}

    public function __invoke(): JsonResponse
    {
        if (! auth()->user()) {
            return response()->json(['error' => 'User is not authenticated'], 401);
        }

        $user = auth()->user();
        $this->getUserInfo->handle($user);

        return response()->json(
            $this->getUserData($user)
        );
    }

    private function getUserData(User $user): array
    {
        return AuthenticatedUserDTO::fromModel($user->lastFmUser)
            ->toArray();
    }
}
