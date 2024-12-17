<?php

namespace App\Livewire\LastFm\GetUser;

use App\Services\DateService;
use Livewire\Attributes\On;
use Livewire\Component;

class UserInfo extends Component
{

    public   $lastFmUser;

    #[On('userInfo:updateLastFmUser')]
    public function updateLastFmUser(DateService $dateService, $lastFmUser): void
    {
        $lastFmUser['registered'] = $dateService->timestampToDateTime($lastFmUser['registered']['unixtime']);
        $this->lastFmUser = $lastFmUser;
    }

    public function render()
    {
        return view('livewire.last-fm.get-user.user-info');
    }
}
