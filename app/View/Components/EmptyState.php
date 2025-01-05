<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EmptyState extends Component
{
    public string $message;

    public array $paths;

    public mixed $fill;

    public int $strokeWidth;

    public function __construct($message = null, $paths = [], $fill = 'none', $strokeWidth = 2)
    {
        $this->message = $message ?? 'information is not available yet.';
        $this->paths = $paths;
        $this->fill = $fill;
        $this->strokeWidth = $strokeWidth;
    }

    public function render(): View
    {
        return view('components.empty-state');
    }
}
