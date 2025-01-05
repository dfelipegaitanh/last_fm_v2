<?php

namespace App\Livewire\LastFm\GetSongs;

use App\Enums\ButtonStateEnum;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Reactive;
use Livewire\Component;

#[Lazy]
class ListChart extends Component
{
    public array $buttons;

    public function __construct()
    {
        $this->buttons = [
            '' => ButtonStateEnum::HOME,
            'daily' => ButtonStateEnum::INACTIVE,
            'weekly' => ButtonStateEnum::INACTIVE,
            'monthly' => ButtonStateEnum::INACTIVE,
            'yearly' => ButtonStateEnum::INACTIVE,
            'chart' => ButtonStateEnum::ACTIVE,
        ];
    }

    #[Reactive]
    public $reportType = '';

    public function render()
    {
        return view('livewire.last-fm.get-songs.list-chart');
    }
}
