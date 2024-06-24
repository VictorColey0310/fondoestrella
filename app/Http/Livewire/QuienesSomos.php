<?php

namespace App\Http\Livewire;

use App\Models\QuienesSomos as ModelsQuienesSomos;
use Livewire\Component;

class QuienesSomos extends Component
{
    public function render()
    {
        return view('livewire.quienes-somos',[
           'quienessomos'=>ModelsQuienesSomos::all(),
                ]);
    }
}
