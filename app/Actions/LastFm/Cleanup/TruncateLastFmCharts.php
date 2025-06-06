<?php

declare(strict_types=1);

namespace App\Actions\LastFm\Cleanup;

use App\Models\LastFm\Chart;
use Illuminate\Support\Facades\DB;

class TruncateLastFmCharts
{
    public function handle(): void
    {
        Schema::withoutForeignKeyConstraints(function (): void {
            Chart::query()->truncate();
        });
        
    }
}
