<?php

namespace App\Livewire\LastFm\GetUser;

use Exception;
use Livewire\Component;

class ButtonGetUserInfo extends Component
{

    public function render()
    {
        return view('livewire.last-fm.get-user.button-get-user-info');
    }

    /**
     * @throws Exception
     */
    public function getUser(): void
    {
        $this->dispatch('userInfo:clearInfo');
        $this->dispatch('userInfo:updateLastFmUser');

    }
}
