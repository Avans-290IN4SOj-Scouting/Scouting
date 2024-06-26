<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SortableTableHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $sortOn,
        public $textKey,
        public $dusk,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sortable-table-header');
    }
}
