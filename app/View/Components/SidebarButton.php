<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarButton extends Component
{
    public $text;
    public $route;
    public $color;

    public function __construct($text, $route, $color = 'indigo' )
    {
        $this->text = $text;
        $this->route = $route;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.sidebar-button');
    }
}
