<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmptyState extends Component
{
    public string $message;

    public array $paths;

    public string $fill;

    public int $strokeWidth;

    public function __construct($message = null, $paths = [], $fill = null, $strokeWidth = 2)
    {
        $this->message = $message ?? 'information is not available yet.';
        $this->paths = $paths;
        $this->fill = $fill ?? 'none';
        $this->strokeWidth = $strokeWidth;
    }

    public function render(): View
    {
        return view('components.lastfm.empty-state');
    }
}
