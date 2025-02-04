<?php

namespace App\Http\Controllers\LastFm;

class UserGeInfoController
{
    public function __invoke()
    {
        return response()->json([
            'name' => '<NAME>',
            'join_date' => 'email@gmail.com',
            'total_scrobbles' => 3,
        ]);
    }
}
