<?php

namespace App\Livewire\LastFm\GetSongs;

use Livewire\Component;

//#[Lazy]
class Index extends Component
{

    public $filter = '';


    public function fetchSongs($filter)
    {
    }

    public function render()
    {
        return view('livewire.last-fm.get-songs.index');
    }
}
