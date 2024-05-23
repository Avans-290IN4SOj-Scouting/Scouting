<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public $label;
    public $name;
    public $rows;
    public $placeholder;

    public function __construct($label, $name, $rows = 5, $placeholder = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->rows = $rows;
        $this->placeholder = $placeholder;
    }


    public function render(): View|Closure|string
    {
        return view('components.textarea');
    }
}
