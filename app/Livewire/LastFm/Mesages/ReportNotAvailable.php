<?php

namespace App\Livewire\LastFm\Mesages;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class ReportNotAvailable extends Component
{
    #[Reactive]
    public $reportType;

    public function render()
    {
        return view('livewire.last-fm.mesages.report-not-available');
    }
}
