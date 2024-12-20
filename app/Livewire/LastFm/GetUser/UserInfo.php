<?php

namespace App\Livewire\LastFm\GetUser;

use App\Actions\LastFmUser\GetUserInfoAction;
use App\Livewire\Component;
use App\Models\LastFmUser;
use App\Services\DateService;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;

#[Lazy]
class UserInfo extends Component
{
    public $lastFmUser;

    /**
     * @throws \Exception
     */
    #[On('userInfo:updateLastFmUser')]
    public function updateLastFmUser(GetUserInfoAction $getUserInfoAction): void
    {
        $this->clearLastFmUser();
        $this->lastFmUser = $this->getLastFmUser($getUserInfoAction);
    }

    #[On('userInfo:clearLastFmUser')]
    public function clearLastFmUser(): void
    {
        $this->reset('lastFmUser');
    }

    public function render()
    {
        return view('livewire.last-fm.get-user.user-info');
    }

    /**
     * @throws \Exception
     */
    public function getLastFmUser(GetUserInfoAction $getUserInfoAction): LastFmUser
    {
        $lastFmUser = $getUserInfoAction->execute(auth()->user()->lastfmUser);
        $lastFmUser['registered'] = DateService::timestampToDateTime($lastFmUser['registered']['unixtime']);

        return $lastFmUser;
    }
}
