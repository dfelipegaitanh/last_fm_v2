<?php

namespace App\Livewire\LastFm\Statistics;

use App\Livewire\Component;
use App\Models\LastFmGlobalSongsStatistics;
use Livewire\Attributes\Computed;

class GlobalStatistics extends Component
{
    public $lastFmUser = [];

    public function clearStatistics(): void
    {
        $this->reset('statisticsLegacy');
    }

    #[Computed]
    public function statistics()
    {
        return LastFmGlobalSongsStatistics::latest()
            ->basicData()
            ->whereLastFmUserId($this->lastFmUser['id'])
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.last-fm.statistics.global-statistics');
    }
}
