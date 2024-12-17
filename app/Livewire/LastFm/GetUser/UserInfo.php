<?php

namespace App\Livewire\LastFm\GetUser;

use AllowDynamicProperties;
use Livewire\Component;

class UserInfo extends Component
{

    protected $listeners = [
        'user-info-updated' => 'updateUserInfo',
    ];
    public   $lastFmUser;

    public function updateUserInfo($lastFmUser): void
    {
        $this->lastFmUser = $lastFmUser;
    }

    public function render()
    {

        return view('livewire.last-fm.get-user.user-info');
    }
}
