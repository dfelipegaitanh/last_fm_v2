<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Cleanup;

use App\Models\LastFm\GlobalSongsStatistics;
use App\Models\LastFm\Track;
use Schema;

readonly class CleanupLastFmTracks
{
    public function handle(): void
    {

        Schema::withoutForeignKeyConstraints(function (): void {
            $usedTrackIds = GlobalSongsStatistics::query()
                ->select('track_id')
                ->distinct()
                ->pluck('track_id')
                ->toArray();

            // Eliminamos todos los tracks que no estén en la lista de IDs usados
            Track::query()
                ->whereNotIn('id', $usedTrackIds)
                ->delete();
        });

    }
}
