<?php

namespace App\Http\Controllers\LastFm;

use App\Http\Controllers\Controller;

class UserGetStatisticsController extends Controller
{
    public function __invoke()
    {
        sleep(2);
        $data = [
            ['id' => 1, 'nombre' => 'Juan Pérez', 'edad' => 28],
        ];

        return response()->json($data, 200);
    }
}
