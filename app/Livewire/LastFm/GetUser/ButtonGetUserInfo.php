<?php

namespace App\Livewire\LastFm\GetUser;

use App\Models\User;
use App\Services\LastFmService;
use Livewire\Component;

class ButtonGetUserInfo extends Component
{
    public User $user;

    public string $lastFmUsername;

    public LastFmService $lastFmService;


    public function mount()
    {
        $this->user = auth()->user();
        $this->lastFmUsername = $this->user->lastfmUser;

    }

    public function render()
    {
        return view('livewire.last-fm.get-user.button-get-user-info');
    }

    public function getUser(LastFmService $last_fm_service): void
    {

        $userInfo = $last_fm_service->userInfo($this->lastFmUsername);
        dump($userInfo);
    }
}
