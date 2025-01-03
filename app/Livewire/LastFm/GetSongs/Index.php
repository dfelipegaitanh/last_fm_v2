<?php

namespace App\Livewire\LastFm\GetSongs;

use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{

    public $reportType = '';

    public $report;

    #[On('getSongs:getReportType')]
    public function getReportType($reportType)
    {
        $this->report = $reportType;
    }

    public function render()
    {
        return view('livewire.last-fm.get-songs.index');
    }
}
