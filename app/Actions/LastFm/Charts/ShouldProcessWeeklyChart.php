<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Charts;

use App\Models\LastFm\Chart;

readonly class ShouldProcessWeeklyChart
{

    public function handle(Chart $weeklyChart, bool $reprocess): bool
    {
        return $reprocess || ! $weeklyChart->completed;
    }
}
