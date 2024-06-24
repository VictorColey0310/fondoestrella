<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckboxWithLabel extends Component
{
    public $name;
    public $id;
    public $type;
    public $label;
    public $wire;
    public $value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$name,$type,$label,$wire,$value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->label = $label;
        $this->wire = $wire;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.checkbox-with-label');
    }
}
