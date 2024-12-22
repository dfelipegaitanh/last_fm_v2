<?php

namespace App\Livewire\LastFm\Statistics;

use App\Actions\LastFmGlobalSongsStatistics\GetGlobalSongsStatisticsAction;
use App\Livewire\Component;
use Livewire\Attributes\Computed;

class GlobalStatistics extends Component
{
    public $lastFmUser = [];

    public $pagination = 5;

    #[Computed]
    public function statistics()
    {
        return app(GetGlobalSongsStatisticsAction::class)
            ->execute($this->lastFmUser['id'], $this->pagination);

    }

    public function render()
    {
        return view('livewire.last-fm.statistics.global-statistics');
    }
}
