<?php

namespace App\Livewire\LastFm\GetUser;

use App\Actions\LastFmUser\GetUserInfoAction;
use App\Livewire\Component;
use App\Models\LastFmUser;
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
    public function updateLastFmUser(): void
    {
        $this->clearLastFmUser();
        $this->lastFmUser = $this->getLastFmUser();
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
    public function getLastFmUser(): LastFmUser
    {
        return app(GetUserInfoAction::class)
            ->execute();
    }
}
