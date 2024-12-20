<?php

namespace App\Livewire\LastFm\Statistics;

use App\Livewire\Component;
use App\Models\LastFmGlobalSongsStatistics;
use Livewire\Attributes\On;

class GlobalStatistics extends Component
{

    public $statistics;

    #[On('globalStatistics:clearStatistics')]
    public function clearStatistics(): void
    {
        $this->reset('statistics');
    }

    #[On('globalStatistics:getStatistics')]
    public function getStatistics(): void
    {
//        dump(1);
        $this->statistics = LastFmGlobalSongsStatistics::latest()
                                                       ->select(['playcount', 'album_count', 'artist_count', 'created_at'])
                                                       ->limit(5)
                                                       ->get();
    }

    public function render()
    {
        return view('livewire.last-fm.statistics.global-statistics');
    }


}
