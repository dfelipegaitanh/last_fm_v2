<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ThemeToggle extends Component
{
    public bool $isDark;

    public function __construct()
    {
        $this->isDark = session('theme', 'light') === 'dark';
    }

    public function render()
    {
        return view('components.theme-toggle', [
            'isDark' => $this->isDark,
        ]);
    }
}
