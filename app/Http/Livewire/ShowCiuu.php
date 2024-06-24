<?php

namespace App\Http\Livewire;

use App\Models\CIIU;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class ShowCiuu extends Component
{

    use LivewireAlert;
    use WithPagination;
    public $actividad;
    public $codigo;
    // public $estado = 1;
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;
    public $riesgo;

    public $eliminarItem = ['1'];
    public function render()
    {
        $buscar = $this->buscar;

        $consulta = CIIU::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('codigo', 'LIKE', '%' . $buscar . '%');
            })
            ->paginate(20);

        return view('livewire.show-ciuu', [
            'consulta' => $consulta
        ]);
    }

    //CREAR 
    public function guardar()
    {
        

        $validatedData = $this->validate([
            'codigo' => 'required',
            'actividad' => 'required',
            'riesgo' => 'required',
        ]);

        CIIU::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = CIIU::find($id);
        $this->codigo = $this->consultaVer->codigo;
        $this->actividad = $this->consultaVer->actividad;
        $this->riesgo = $this->consultaVer->riesgo;
        $this->ver = true;

    }
    //ELIMINAR 
    public function eliminar($id)
    {
        $this->eliminarItem[] = $id;

        $this->alert('warning', '¿Eliminar?', [
            'position' => 'center',
            'timer' => '10000',
            'toast' => false,
            'text' => 'Esta seguro',
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmed',
            'showDenyButton' => false,
            'onDenied' => '',
            'showCancelButton' => true,
            'onDismissed' => '',
            'cancelButtonText' => 'Salir',
            'confirmButtonText' => 'Si',
        ]);
    }

    public function getListeners()
    {
        return [
            'confirmed'
        ];
    }

    public function confirmed()
    {
        CIIU::whereIn('_id', $this->eliminarItem)->delete();

        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {

        $this->consultaVer = CIIU::find($id);
        $this->actividad = $this->consultaVer->actividad;
        $this->riesgo = $this->consultaVer->riesgo;
        $this->codigo = $this->consultaVer->codigo;

        $this->editar = true;

    }

    //ACTUALIZAR
    public function actualizar($id)
    {
       
        $validatedData = $this->validate([
            'codigo' => 'required',
            'actividad' => 'required',
            'riesgo' => 'required',

        ]);

        CIIU::find($id)->update($validatedData);


        $this->editar = false;
        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();

    }

    public function limpiarInput()
    {
        $this->actividad = '';
        $this->riesgo = '';
        $this->codigo = '';


    }
}