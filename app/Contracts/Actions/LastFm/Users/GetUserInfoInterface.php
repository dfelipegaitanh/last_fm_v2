<?php

declare(strict_types=1);

namespace App\Contracts\Actions\LastFm\Users;

use App\Models\User;

interface GetUserInfoInterface
{
    public function handle(User $user): void;
}
