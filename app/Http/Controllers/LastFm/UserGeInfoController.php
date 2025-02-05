<?php

namespace App\Http\Controllers\LastFm;

use App\Actions\LastFmUser\GetUserInfoAction;

class UserGeInfoController
{
    public function __construct(
        protected GetUserInfoAction $action
    ) {}

    public function __invoke()
    {
        $this->action
            ->execute();

        $user = auth()->user()->lastFmUser;

        return response()->json([
            'name' => $user->name,
            'join_date' => $user->registered,
            'total_scrobbles' => 3,
        ]);
    }
}
