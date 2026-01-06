<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OfferingTable extends Component
{
    public $offerings;
    /**
     * Create a new component instance.
     */
    public function __construct($offerings)
    {
        $this->offerings = $offerings;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.offering-table');
    }
}
