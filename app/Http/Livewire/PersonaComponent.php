<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PersonaComponent extends Component
{
    public $persona;
    public $isLast;
    public $isFirst;

    public function render()
    {
        return view('livewire.persona-component');
    }
}
