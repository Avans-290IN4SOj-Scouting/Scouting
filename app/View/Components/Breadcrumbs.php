<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $names,
        public array $routes,
        public array $svgs = [],
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (count($this->names) !== count($this->routes)) {
            throw new \InvalidArgumentException('The lengths of $names and $routes arrays must match in the Breadcrumbs component.');
        }

        return view('components.breadcrumbs');
    }
}
