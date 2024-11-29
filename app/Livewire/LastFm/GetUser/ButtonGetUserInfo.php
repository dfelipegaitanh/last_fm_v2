<?php

namespace App\Livewire\LastFm\GetUser;

use App\Models\User;
use Livewire\Component;

class ButtonGetUserInfo extends Component
{

    public User $user;
    public string $lastfmUser;

    public function mount()
    {
        $this->user = auth()->user();
        $this->lastfmUser = $this->user->lastfmUser;

    }
    public function render()
    {
        return view('livewire.last-fm.get-user.button-get-user-info');
    }

    public function getUser(): void
    {
        dump($this->user);
    }
}
