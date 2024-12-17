<?php

namespace App\Actions\LastFmUser;

use App\Models\LastFmUser;
use App\Models\User;
use App\Services\LastFmService;

class GetUserInfoAction
{

    public function execute(User $user, string $lastFmUsername, LastFmService $lastFmService): LastFmUser
    {
        $userInfo = $lastFmService->userInfo($lastFmUsername);

        // Asegúrate de que el usuario tenga permiso
        if ( ! $user->can('saveLastFmUser', [User::class, $userInfo])) {
            throw new \Exception('No tienes permiso para realizar esta acción.');
        }

        // Crea o actualiza el registro del usuario en LastFmUser
        return LastFmUser::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name'       => $userInfo['name'],
                'subscriber' => $userInfo['subscriber'],
                'country'    => $userInfo['country'],
                'url'        => $userInfo['url'],
                'registered' => $userInfo['registered'],
            ],
        );
    }
}