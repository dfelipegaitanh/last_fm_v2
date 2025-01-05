<?php

namespace App\Livewire\LastFm\GetSongs\Reports;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;

#[Lazy]
class Chart extends Component
{

    public bool $showFetchDataButton;

    public function mount()
    {
        $this->showFetchDataButton = true;
    }

    public function fetchData()
    {
        $this->showFetchDataButton = false;
    }

    #[On('getSongsChart:resetComponent')]
    public function resetComponent()
    {
        $this->showFetchDataButton = true;
    }

    public function render()
    {
        return view('livewire.last-fm.get-songs.reports.chart');
    }
}
