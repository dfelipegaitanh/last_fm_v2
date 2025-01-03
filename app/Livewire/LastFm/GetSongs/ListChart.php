<?php

namespace App\Livewire\LastFm\GetSongs;

use Livewire\Attributes\Lazy;
use Livewire\Attributes\Reactive;
use Livewire\Component;

#[Lazy]
class ListChart extends Component
{

    #[Reactive]
    public $filter = '';

    public function render()
    {
        return view('livewire.last-fm.get-songs.list-chart');
    }
}
