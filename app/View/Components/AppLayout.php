<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $script;
    public function __construct($script = null)
    {
        $this->script = $script;
    }

    public function render(): View
    {
        return view('layouts.app');
    }
}
