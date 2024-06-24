<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputSearch extends Component
{
    public $name;
    public $id;
    public $placeholder;
    public $type;
   
    public $wire;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id,$name,$placeholder,$type,$wire)
    {
        
        $this->id = $id;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->wire = $wire;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-search');
    }
}
