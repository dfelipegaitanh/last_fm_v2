<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Charts;

use App\Models\LastFm\Chart;

class DeleteWeeklyTrackCharts
{
    /**
     * Delete all track charts associated with a weekly chart.
     *
     * @param  Chart  $weeklyChart  The weekly chart whose track charts will be deleted
     */
    public function handle(Chart $weeklyChart): void
    {
        $weeklyChart->trackCharts()->delete();
    }
}
