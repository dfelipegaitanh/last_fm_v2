<?php

declare(strict_types=1);

namespace App\Actions\LastFm;

use App\DTOs\LastFm\WeeklyTrackChartDTO;
use App\Enums\ChartType;
use App\Models\LastFm\Album;
use App\Models\LastFm\Artist;
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
    }

    /**
     * Procesa y guarda las pistas asociadas a un chart para un usuario.
     *
     * @param  Collection  $tracks  Colección de pistas a procesar
     * @param  Chart  $weeklyChart  Chart al que asociar las pistas
     * @param  User  $user  Usuario para el que se procesan las pistas
     */
    private function processAndSaveTracks(Collection $tracks, Chart $weeklyChart, User $user): void
    {
        $tracks->each(function (WeeklyTrackChartDTO $trackDTO) use ($weeklyChart, $user): void {
            // Buscar o crear el track
            $track = Track::query()
                ->where('name', $trackDTO->track->name)
                ->where('mbid', $trackDTO->track->mbid)
                ->first();

            if (! $track) {
                // Buscar o crear el artista
                $artist = Artist::firstOrCreate(
                    ['name' => $trackDTO->track->artist->name],
                    ['url' => $trackDTO->track->artist->url ?? '']
                );

                // Crear el álbum si existe
                $albumId = null;
                if ($trackDTO->track->album instanceof \App\DTOs\LastFm\AlbumDTO) {
                    $album = Album::firstOrCreate(
                        [
                            'title' => $trackDTO->track->album->title,
                            'artist_id' => $artist->id,
                        ],
                        ['url' => $trackDTO->track->album->url ?? '']
                    );
                    $albumId = $album->id;
                }

                $track = new Track();
                $track->name = $trackDTO->track->name;
                $track->artist_id = $artist->id;
                $track->album_id = $albumId;
                $track->mbid = $trackDTO->track->mbid;
                $track->url = $trackDTO->track->url;

                $track->save();
            }

            // Verificar si ya existe la relación antes de adjuntar
            $existingRelation = $weeklyChart->tracks()
                ->wherePivot('user_id', $user->id)
                ->wherePivot('last_fm_track_id', $track->id)
                ->exists();

            if (! $existingRelation) {
                // Asociar el track al chart con el playcount
                $weeklyChart->tracks()->attach($track, [
                    'user_id' => $user->id,
                    'playcount' => $trackDTO->playcount,
                ]);
            }
        });
    }
}
