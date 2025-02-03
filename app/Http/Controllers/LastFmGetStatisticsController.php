<?php

namespace App\Http\Controllers;

class LastFmGetStatisticsController extends Controller
{
    public function __invoke()
    {
        $data = [
            ['id' => 1, 'nombre' => 'Juan Pérez', 'edad' => 28],
        ];

        return response()->json($data, 200);
    }
}
