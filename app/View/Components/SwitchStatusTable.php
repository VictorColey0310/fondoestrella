<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SwitchStatusTable extends Component
{   
    public $estado;
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($estado, $id)
    {
        $this->estado=$estado;
        $this->id=$id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.switch-status-table');
    }
}
