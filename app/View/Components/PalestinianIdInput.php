<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PalestinianIdInput extends Component
{
    public $name;
    public $label;
    public $value;
    public $required;
    
    public function __construct($name = 'id', $label = 'الهوية', $value = '', $required = true)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
    }

    public function render()
    {
        return view('components.palestinian-id-input');
    }
}