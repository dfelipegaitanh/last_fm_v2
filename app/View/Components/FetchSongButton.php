<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FetchSongButton extends Component
{

    public string $text;
    public string $filter;

    public function __construct(string $text, string $filter)
    {
        $this->text = $text;
        $this->filter = $filter;
    }

    public function render(): View
    {
        return view('components.lastfm.fetch-song-button');
    }
}
