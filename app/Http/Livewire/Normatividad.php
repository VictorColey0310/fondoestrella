<?php

namespace App\Http\Livewire;

use App\Models\Asociacion;
use Livewire\Component;

class Normatividad extends Component
{
    public function render()
    {
        return view('livewire.normatividad',[
            'comoasociarse'=>Asociacion::all(),
         ]);
    }
}
