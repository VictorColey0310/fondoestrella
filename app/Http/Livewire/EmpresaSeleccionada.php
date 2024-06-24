<?php

namespace App\Http\Livewire;

use App\Models\empresa_seleccionada;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

class EmpresaSeleccionada extends Component
{
    public $empresaSeleccionada;
    public $empresa_id;

    public function seleccionarEmpresa($empresa_id)
    {
       //dd(auth()->user()->id);
       $empresa = empresa_seleccionada::updateOrCreate(
        ['user_id' => auth()->user()->id],
        ['empresa_id' => $empresa_id]
    );
    
  // Recargar la página actual
    $this->redirect(route('dashboard'));
    }

    public function render()
    {   
        $empresaSeleccionada = empresa_seleccionada::where('user_id', auth()->user()->id)->first() ?? null;
        //dd($empresaSeleccionada);
        if (!empty($empresaSeleccionada)) {
            
            $this->empresa_id = $empresaSeleccionada->empresa_id;
            $this->empresaSeleccionada = $empresaSeleccionada->empresa->nombre ?? '';
            $this->emit('mensajeEnviado', $this->empresa_id);
            //dd('Evento emitido con éxito'); 
           
        }
        //dd($empresaSeleccionada);
        return view('livewire.empresa-seleccionada');
    }


}