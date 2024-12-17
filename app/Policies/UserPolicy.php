<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function saveLastFmUser(User $user, string $lastFmUser)
    {

        if($user->lastfmUser === $lastFmUser) {
            return true;
        }
        abort(403);

    }
}
