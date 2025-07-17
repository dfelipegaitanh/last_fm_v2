<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Charts;

use App\Enums\ChartType;
use App\Models\LastFm\Chart;
use App\Models\User;

class ProcessWeeklyTrackChart
{
    public function handle(int $from, int $to, User $user): Chart
    {

        return Chart::firstOrCreate(
            [
                'from_timestamp' => $from,
                'to_timestamp' => $to,
                'type' => ChartType::WEEKLY,
                'user_id' => $user->id,
            ]
        );
    }
}
