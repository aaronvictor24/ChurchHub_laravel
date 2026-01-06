<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditMassForm extends Component
{
    public $mass;
    public $action;

    public function __construct($mass, $action)
    {
        $this->mass = $mass;
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.edit-mass-form');
    }
}
