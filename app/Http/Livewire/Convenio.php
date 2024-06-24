<?php

namespace App\Http\Livewire;

use App\Models\Convenios;
use App\Models\GrupoConvenios;
use Livewire\Component;

class Convenio extends Component
{
    public function render()
    {
        return view('livewire.convenio',[
            'convenios' => Convenios::all(),
            'grupo_convenios' => GrupoConvenios::all(),
        ]);
    }
}
