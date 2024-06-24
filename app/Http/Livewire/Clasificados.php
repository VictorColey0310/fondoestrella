<?php

namespace App\Http\Livewire;

use App\Models\Clasificados as ModelsClasificados;
use Livewire\Component;

class Clasificados extends Component
{
    public function render()
    {
        $clasificados = ModelsClasificados::all();

        return view('livewire.clasificados',[
            'clasificados' => $clasificados,
        ]);

    }
}
