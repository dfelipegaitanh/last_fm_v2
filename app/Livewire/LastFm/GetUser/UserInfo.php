<?php

namespace App\Livewire\LastFm\GetUser;

use App\Actions\LastFmUser\GetUserInfoAction;
use App\Models\LastFmUser;
use App\Services\DateService;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class UserInfo extends Component
{

    #[Reactive]
    public $lastFmUser = [
        'name'       => 'name',
        'country'    => 'country',
        'registered' => 'registered',
    ];

    #[On('userInfo:clearInfo')]
    public function clearInfo(): void
    {
        $this->reset('lastFmUser');
    }

    /**
     * @throws \Exception
     */
    #[On('userInfo:updateLastFmUser')]
    public function updateLastFmUser(DateService $dateService, GetUserInfoAction $getUserInfoAction): void
    {
        $this->lastFmUser = $this->getLastFmUser($getUserInfoAction, $dateService);
    }

    public function render()
    {
        return view('livewire.last-fm.get-user.user-info');
    }

    /**
     * @param  GetUserInfoAction  $getUserInfoAction
     * @param  DateService  $dateService
     *
     * @return LastFmUser
     * @throws \Exception
     */
    public function getLastFmUser(GetUserInfoAction $getUserInfoAction, DateService $dateService): LastFmUser
    {
        $lastFmUser = $getUserInfoAction->execute(auth()->user()->lastfmUser);
        $lastFmUser['registered'] = $dateService->timestampToDateTime($lastFmUser['registered']['unixtime']);
        return $lastFmUser;
    }
}
