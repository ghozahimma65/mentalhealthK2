<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AlertSuccess extends Component
{
    public string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return view('components.alert-success');
    }
}
