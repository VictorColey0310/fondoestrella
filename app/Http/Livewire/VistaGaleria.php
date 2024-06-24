<?php

namespace App\Http\Livewire;

use App\Models\Galeria;
use Livewire\Component;

class VistaGaleria extends Component
{
    public function render()
    {
        return view('livewire.vista-galeria',[
            'galerias'=> Galeria::all(),
        ]);
    }
}
