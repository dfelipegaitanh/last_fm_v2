<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Cleanup;

use App\Models\LastFm\Album;
use App\Models\LastFm\Track;
use Illuminate\Support\Facades\Schema;

readonly class CleanupLastFmAlbums
{
    public function handle(): void
    {
        Schema::withoutForeignKeyConstraints(function (): void {
            // Obtenemos los IDs de álbumes que están en uso en tracks
            $usedAlbumIds = Track::query()
                ->whereNotNull('album_id')
                ->select('album_id')
                ->distinct()
                ->pluck('album_id')
                ->toArray();

            // Eliminamos todos los álbumes que no estén en la lista de IDs usados
            Album::query()
                ->whereNotIn('id', $usedAlbumIds)
                ->delete();
        });
    }
}
