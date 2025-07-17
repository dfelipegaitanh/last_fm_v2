<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Charts;

use App\Models\LastFm\Chart;
use App\Models\LastFm\Track;
use App\Models\User;

readonly class SyncTrackWithWeeklyChart
{

    public function handle(Chart $weeklyChart, Track $track, User $user, int $playcount): void
    {
        $weeklyChart->tracks()->syncWithoutDetaching([
            $track->id => [
                'user_id' => $user->id,
                'playcount' => $playcount,
            ],
        ]);
    }
}
