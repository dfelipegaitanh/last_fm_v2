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
    public function updateLastFmUser(DateService $dateService, GetUserInfoAction $getUserInfoAction): void
    {
        $this->clearLastFmUser();
        $this->lastFmUser = $this->getLastFmUser($getUserInfoAction, $dateService);
        $this->dispatch('globalStatistics:getStatistics');
    }

    #[On('userInfo:clearLastFmUser')]
    public function clearLastFmUser(): void
    {
        $this->dispatch('globalStatistics:clearStatistics');
        $this->reset('lastFmUser');
    }

    public function mount() { }

    public function render()
    {
        return view('livewire.last-fm.get-user.user-info');
    }

    /**
     * @throws \Exception
     */
    public function getLastFmUser(GetUserInfoAction $getUserInfoAction, DateService $dateService): LastFmUser
    {
        $lastFmUser = $getUserInfoAction->execute(auth()->user()->lastfmUser);
        $lastFmUser['registered'] = $dateService->timestampToDateTime($lastFmUser['registered']['unixtime']);

        return $lastFmUser;
    }

}
