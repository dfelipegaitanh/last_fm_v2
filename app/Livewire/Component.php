<?php

namespace App\Livewire;

use Livewire\Component as LivewireComponent;

class Component extends LivewireComponent
{
    public function placeholder()
    {
        return view('spinner.spinner-border');
    }
}
