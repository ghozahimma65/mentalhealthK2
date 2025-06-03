<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputGroup extends Component
{
    public string $label;
    public string $name;
    public string $type;
    public ?string $value;
    public ?string $placeholder;
    public ?string $class;

    public function __construct(
        string $label = '',           // default kosong
        string $name = '',            // default kosong
        string $type = 'text',
        string $value = null,
        string $placeholder = null,
        string $class = null
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.input-group');
    }
}
