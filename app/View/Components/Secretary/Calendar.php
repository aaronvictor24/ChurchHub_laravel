<?php

namespace App\View\Components\Secretary;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Calendar extends Component
{
    public $calendarEvents;
    /**
     * Create a new component instance.
     */
    public function __construct($calendarEvents)
    {
        $this->calendarEvents = $calendarEvents;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.secretary.calendar');
    }
}
