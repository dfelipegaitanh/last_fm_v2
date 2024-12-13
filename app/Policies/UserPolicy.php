<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function saveLastFmUser(User $user, array $data)
    {
        if ($user->lastfmUser === $data['name']) {
            return true;
        }
        abort(403);

    }
}
