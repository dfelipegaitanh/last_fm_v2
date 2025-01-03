<?php

namespace App\Livewire\LastFm\GetSongs;

use Livewire\Component;

class Buttons extends Component
{
    public $filter = '';

    public function render()
    {
        return view('livewire.last-fm.get-songs.buttons');
    }
}
