<?php

declare(strict_types=1);

namespace App\Actions\LastFm;

use App\DTOs\LastFm\WeeklyTrackChartDTO;
use App\Enums\ChartType;
use App\Models\LastFm\Chart;
use App\Models\LastFm\Track;
use App\Models\User;
use Illuminate\Support\Collection;

class ProcessWeeklyTrackChart
{
    public function __construct(
        private readonly FetchWeeklyTrackChart $fetchWeeklyTrackChart,
    ) {}

    public function handle(User $user, int $from, int $to): Chart
    {
        // Buscar o crear el chart semanal
        $weeklyChart = Chart::firstOrCreate(
            [
                'from_timestamp' => $from,
                'to_timestamp' => $to,
                'type' => ChartType::WEEKLY,
            ],
            ['processed' => false]
        );

        dd($weeklyChart->tracksForUser($user)->toRawSql());
        // Si ya está procesado para este usuario, retornar
        if ($weeklyChart->tracksForUser($user)->exists()) {
            return $weeklyChart;
        }

        // Obtener los tracks del chart
        $tracks = $this->fetchWeeklyTrackChart->handle($user->lastfm_user, $from, $to);

        // Procesar y guardar cada track
        $this->processAndSaveTracks($tracks, $weeklyChart, $user);

        // Marcar como procesado
        $weeklyChart->processed = true;
        $weeklyChart->save();

        return $weeklyChart;
    }

    private function processAndSaveTracks(Collection $tracks, Chart $weeklyChart, User $user): void
    {
        $tracks->each(function (WeeklyTrackChartDTO $trackDTO) use ($weeklyChart, $user): void {
            // Buscar o crear el track
            $track = Track::query()
                ->where('name', $trackDTO->track->name)
                ->where('artist_name', $trackDTO->track->artist->name)
                ->first();

            if (! $track) {
                $track = new Track();
                $track->name = $trackDTO->track->name;
                $track->artist_name = $trackDTO->track->artist->name;
                $track->mbid = $trackDTO->track->mbid;
                $track->url = $trackDTO->track->url;

                if ($trackDTO->track->album instanceof \App\DTOs\LastFm\AlbumDTO) {
                    $track->album_name = $trackDTO->track->album->title;
                    $track->album_artist = $trackDTO->track->album->artist->name;
                }

                $track->save();
            }

            // Asociar el track al chart con el playcount
            $weeklyChart->tracks()->attach($track, [
                'user_id' => $user->id,
                'playcount' => $trackDTO->playcount,
            ]);
        });
    }
}
