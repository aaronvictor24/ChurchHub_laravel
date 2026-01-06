<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OpenDrawer extends Component
{
    public $title;
    public $drawerId;

    public function __construct($title = 'Drawer Title', $drawerId = 'drawer')
    {
        $this->title = $title;
        $this->drawerId = $drawerId;
    }

    public function render()
    {
        return view('components.open-drawer');
    }
}
