<?php

namespace App\Livewire\LastFm\GetUser;

use App\Livewire\Component;

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
