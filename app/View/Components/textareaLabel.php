<?php

namespace App\View\Components;

use Illuminate\View\Component;

class textareaLabel extends Component
{
    public $name;
    public $id;
    public $placeholder;
    public $type;
    public $label;
    public $wire;
    public $maxlength;
    public $value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$name,$placeholder,$type,$label,$wire,$maxlength,$value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->label = $label;
        $this->wire = $wire;
        $this->maxlength= $maxlength;
        $this->value= $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.textarea-label');
    }
}
