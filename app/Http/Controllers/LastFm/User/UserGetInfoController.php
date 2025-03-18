<?php

declare(strict_types=1);

namespace App\Http\Controllers\LastFm\User;

use App\Models\User;
use App\Modules\LastFm\Users\Actions\Users\GetUserInfo;
use App\Modules\LastFm\Users\Models\User as LastFmUser;
use App\Services\Api\LastFm\LastFmApi;
use App\Modules\LastFm\Users\DTO\UserInfoDTO;
use Illuminate\Http\JsonResponse;

readonly class UserGetInfoController
{
    public function __construct(
        private LastFmApi $lastFmApi,
        private GetUserInfo $getUserInfo,
    ) {}

    public function __invoke(): JsonResponse
    {
        if (! auth()->user()) {
            return response()->json(['error' => 'User is not authenticated'], 401);
        }

        $user = auth()->user();
        $lastFmInfo = $this->lastFmApi->getUserInfo($user->lastfm_user);

        // Sync with database and process statistics
        $this->syncLastFmUser($user, $lastFmInfo);
        $this->getUserInfo->handle($user);

        return response()->json($lastFmInfo);
    }

    private function syncLastFmUser(User $user, UserInfoDTO $userInfo): void
    {
        LastFmUser::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $userInfo->name,
                'subscriber' => $userInfo->subscriber,
                'country' => $userInfo->country,
                'url' => $userInfo->url,
                'registered' => $userInfo->registered,
            ]
        );
    }
}
