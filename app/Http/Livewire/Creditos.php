<?php

namespace App\Http\Livewire;

use App\Models\Credito;
use Livewire\Component;

class Creditos extends Component
{
    public function render()
    {
        return view('livewire.creditos',[
            'creditos' => Credito::all(),
        ]);
    }
}
