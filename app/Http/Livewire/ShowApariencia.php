<?php

namespace App\Http\Livewire;

use App\Models\Apariencia;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;

class ShowApariencia extends Component
{
    use LivewireAlert;
    public $color_boton;
    public $color_menu;
    public $color_letra_hover;
    public $color_letra;

    public function render()
    {
        $consulta = Apariencia::query()->first();

        if ($consulta != null && $this->color_boton == null && $this->color_menu == null) {
            $this->color_boton = $consulta->color_boton;
            $this->color_menu = $consulta->color_menu;
            $this->color_letra = $consulta->color_letra;
            $this->color_letra_hover  = $consulta->color_letra_hover;
        }

        return view('livewire.show-apariencia', [
            'consulta' => $consulta,
        ]);
    }

    //CREAR 
    public function guardar()
    {
        $validatedData = $this->validate([
            'color_boton' => 'required',
            'color_menu' => 'required',
            'color_letra' => 'required',
            'color_letra_hover'=> 'required'

        ]);

        $apariencia = Apariencia::first();

        if ($apariencia) {
            $apariencia->update($validatedData);
            $this->alert('success', 'Actualizado correctamente!', [
                'position' => 'top'
            ]);
        } else {
            Apariencia::create($validatedData);
            $this->alert('success', 'Creado correctamente!', [
                'position' => 'top'
            ]);
        }
    }
}
