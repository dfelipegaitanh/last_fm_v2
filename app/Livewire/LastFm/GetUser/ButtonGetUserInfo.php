<?php

namespace App\Livewire\LastFm\GetUser;

use App\Actions\LastFmUser\GetUserInfoAction;
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

    /**
     * @throws \Exception
     */
    public function getUser(GetUserInfoAction $action, LastFmService $lastFmService): void
    {

        $lastFmUser = $action->execute($this->user, $this->lastFmUsername, $lastFmService);

        // Opcional: haz algo con $lastFmUser
        dump($lastFmUser->toArray());

    }
}
