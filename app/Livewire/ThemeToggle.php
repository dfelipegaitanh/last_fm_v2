<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{
    public $isDark = false;

    public function mount()
    {
        $this->isDark = session('theme', 'light') === 'dark';
    }

    public function toggleTheme()
    {
        $this->isDark = ! $this->isDark;
        session(['theme' => $this->isDark ? 'dark' : 'light']);
        $this->dispatch('theme-updated', $this->isDark);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
