<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Singleselect extends Component
{
    public $label;
    public $placeholder;
    public $options;
    public $value;
    public $name;
    public $class;

    public function __construct($label, $name, $placeholder, $options, $value = null, $class = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->options = $options;
        $this->value = $value;
        $this->class = $class;
    }

    public function render(): View|Closure|string
    {
        return view('components.singleselect');
    }
}
