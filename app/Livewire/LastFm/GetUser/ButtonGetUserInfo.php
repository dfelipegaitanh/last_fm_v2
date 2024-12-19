<?php

namespace App\Livewire\LastFm\GetUser;

use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class ButtonGetUserInfo extends Component
{

    public function placeHolder()
    {
        return view('spinner.spiner-no-border');
    }

    public function render()
    {
        return view('livewire.last-fm.get-user.button-get-user-info');
    }
}
