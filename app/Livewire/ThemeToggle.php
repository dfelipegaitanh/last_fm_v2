<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{

    public $isDark = false;

    public function toggleTheme()
    {
        $this->isDark = !$this->isDark;
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
