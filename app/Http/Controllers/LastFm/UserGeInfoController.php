<?php

namespace App\Http\Controllers\LastFm;

class UserGeInfoController
{
    public function __invoke()
    {
        return response()->json([
            'nombre' => '<NAME>',
            'email' => 'email@gmail.com',
            'pais' => 'Mexico',
        ]);
    }
}
