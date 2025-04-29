<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Charts;

use App\Enums\ChartType;
use App\Models\LastFm\Chart;
use App\Models\LastFm\Track;
use App\Models\User;

class ProcessWeeklyTrackChart
{
    public function handle(int $from, int $to, bool $reprocess, User $user): Chart
    {

        // TODO: Borrar estadisticas cancion y artista if ($reprocess)

        return Chart::firstOrCreate(
            [
                'from_timestamp' => $from,
                'to_timestamp' => $to,
                'type' => ChartType::WEEKLY,
                'user_id' => $user->id,
            ],
            ['processed' => false]
        );

        /*
        // Primero verificamos si existe un chart con tracks para este usuario
        $existingChart = Chart::where([
            'from_timestamp' => $from,
            'to_timestamp' => $to,
            'type' => ChartType::WEEKLY,
        ])->first();

        if ($existingChart && $existingChart->tracksForUser($user)->exists()) {
            return $existingChart;
        }

        // Si no existe o no tiene tracks para este usuario, buscamos o creamos el chart
        $weeklyChart = Chart::firstOrCreate(
            [
                'from_timestamp' => $from,
                'to_timestamp' => $to,
                'type' => ChartType::WEEKLY,
            ],
            ['processed' => false]
        );

        // Obtener los tracks del chart
        $tracks = $this->fetchWeeklyTrackChart->handle($user->lastfm_user, $from, $to);

        // Procesar y guardar cada track
        $this->processAndSaveTracks($tracks, $weeklyChart, $user);

        // Marcar como procesado
        $weeklyChart->processed = true;
        $weeklyChart->save();

        return $weeklyChart;
*/
    }
}
