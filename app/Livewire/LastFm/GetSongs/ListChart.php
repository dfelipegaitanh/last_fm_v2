<?php

namespace App\Livewire\LastFm\GetSongs;

use App\Livewire\Component;
use Livewire\Attributes\Reactive;

class ListChart extends Component
{

    #[Reactive]
    public $filter = '';
    public function render()
    {
        return view('livewire.last-fm.get-songs.list-chart');
    }
}
