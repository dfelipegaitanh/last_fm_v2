<?php

declare(strict_types=1);

namespace App\Modules\LastFm\Users\Actions\Users;

use App\Models\User;
use App\Services\Api\LastFm\LastFmApi;

readonly class GetUserInfo
{
    public function __construct(
        private SaveGlobalSongsStatistics $saveGlobalSongsStatistics,
        private LastFmApi $lastFmApi,
    ) {}

    public function handle(User $user): void
    {
        $lastFmInfo = $this->lastFmApi->getUserInfo($user->lastfm_user);
        $this->saveGlobalSongsStatistics->handle($user, $lastFmInfo);
    }
}
