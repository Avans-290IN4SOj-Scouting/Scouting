<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $label;
    public $id;
    public $type;
    public $placeholder;
    public $name;
    public $value;
    public $disabled;

    public function __construct($label, $id, $name, $type = 'text', $placeholder = '', $value = null, $disabled = false)
    {
        $this->label = $label;
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->disabled = $disabled;
    }

    public function render(): View|Closure|string
    {
        return view('components.text-input');
    }
}
