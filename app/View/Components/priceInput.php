<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class priceInput extends Component
{
    public $label;
    public $id;
    public $placeholder;
    public $name;
    public $value;
    public $class;

    public function __construct($label, $id, $name, $placeholder, $value = null, $class = '')
    {
        $this->label = $label;
        $this->id = $id;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->class = $class;
    }

    public function render(): View|Closure|string
    {
        return view('components.price-input');
    }
}
