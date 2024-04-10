<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class filter extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $placeholder,
        public array  $options,
        public string $name,
        public string $label,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filter');
    }
}
