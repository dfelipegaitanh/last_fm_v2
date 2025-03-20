<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\User;

use App\Contracts\Actions\LastFm\Users\GetUserInfoInterface;
use App\DTOs\LastFm\AuthenticatedUserDTO;
use App\Models\User;
use Illuminate\Http\JsonResponse;

readonly class UserGetInfoController
{
    public function __construct(
        private GetUserInfoInterface $getUserInfo
    ) {}

    public function __invoke(): JsonResponse
    {
        if (! auth()->user()) {
            return response()->json(['error' => 'User is not authenticated'], 401);
        }

        $user = auth()->user();

        try {
            $this->getUserInfo->handle($user);

            return response()->json(
                $this->getUserData($user)
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getUserData(User $user): array
    {
        return AuthenticatedUserDTO::fromModel($user->lastFmUser)
            ->toArray();
    }
}
