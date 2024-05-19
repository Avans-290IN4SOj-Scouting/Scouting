<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class multiselect extends Component
{
    public $label;
    public $placeholder;
    public $options;
    public $selected;
    public $name;
    public $class;

    public function __construct($label, $name, $placeholder, $options, $selected = null, $class = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->options = $options;
        $this->selected = $selected;
        $this->class = $class;
    }

    public function render(): View|Closure|string
    {
        return view('components.multiselect');
    }
}
