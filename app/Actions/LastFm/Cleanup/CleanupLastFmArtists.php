<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Cleanup;

use App\Models\LastFm\Artist;
use App\Models\LastFm\Track;
use Illuminate\Support\Facades\Schema;

readonly class CleanupLastFmArtists
{
    public function handle(): void
    {
        Schema::withoutForeignKeyConstraints(function (): void {
            // Eliminamos artistas que no tienen tracks asociados usando EXISTS
            Artist::query()
                ->whereNotExists(function ($query) {
                    $query->select(1)
                        ->from('tracks')
                        ->whereColumn('tracks.artist_id', 'artists.id');
                })
                ->delete();
        });
    }
}
