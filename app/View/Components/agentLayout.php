<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class agentLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public $script;
    public function __construct($script = null)
    {
        $this->script = $script;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.agent-layout');
    }
}
