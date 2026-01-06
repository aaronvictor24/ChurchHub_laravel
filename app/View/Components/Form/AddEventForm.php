<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddEventForm extends Component
{
    public $action;
    public $event;
    /**
     * Create a new component instance.
     */
    public function __construct($action, $event = null)
    {
        $this->action = $action;
        $this->event = $event;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.add-event-form');
    }
}
