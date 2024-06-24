<?php

namespace App\Http\Livewire;

use App\Models\Asociacion;
use App\Models\Beneficios;
use App\Models\Convenios;
use App\Models\Galeria;
use App\Models\Slider;
use App\Models\Tarjetas;
use Livewire\Component;

class Welcome extends Component
{
    public function render()
    {   

        //dd( Asociacion::all());

        return view('livewire.welcome',[
            'sliders' => Slider::all(),
            'tarjetas'=>Tarjetas::all(),
            'asosiaciones'=>Asociacion::all(),
            'beneficios'=>Beneficios::all(),
            'convenios'=>Convenios::all(),
            'galerias'=> Galeria::latest()->take(4)->get(),
        ]);
    }
}
