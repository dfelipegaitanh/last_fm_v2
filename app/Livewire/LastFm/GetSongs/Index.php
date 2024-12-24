<?php

namespace App\Livewire\LastFm\GetSongs;

use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Index extends Component
{
    public function render()
    {
        return view('livewire.last-fm.get-songs.index');
    }
}
