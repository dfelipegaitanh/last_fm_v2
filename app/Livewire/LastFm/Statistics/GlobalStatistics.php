<?php

namespace App\Livewire\LastFm\Statistics;

use App\Livewire\Component;

class GlobalStatistics extends Component
{
    public function render()
    {
        sleep(3);

        return view('livewire.last-fm.statistics.global-statistics');
    }


}
