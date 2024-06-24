<?php

namespace App\Http\Livewire;

use App\Models\Asociacion;
use Livewire\Component;

class ComoAsociarse extends Component
{
    public function render()
    {
        return view('livewire.como-asociarse',[
           'comoasociarse'=>Asociacion::all(),
        ]);
    }
}
