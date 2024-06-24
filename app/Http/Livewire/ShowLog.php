<?php

namespace App\Http\Livewire;

use App\Models\Empresas;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowLog extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Log';
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $buscar;
    public $user_id;
    public $empresa_id;
    public $eliminarItem = ['1'];
    //public $consulta;
    public $empresas;
    public $filtro_empresa_id;
    public $filtro_fecha;

    public function getListeners()
    {
        return [
            'confirmed',
            'mensajeEnviado'
        ];
    }

    public function mensajeEnviado($empresa_id)
    {
        $this->empresa_id = $empresa_id->id;
    }
    public function mount()
    {
        $this->empresas = Empresas::get();
    }
    public function render()
    {
        //Log::get()->delete();
        if (empty($this->empresa_id)) {
            $this->empresa_id = config('app.empresa')->id;
        }
        $buscar = $this->buscar;

        $consulta = Log::where('empresa_id', $this->empresa_id)
        ->when($buscar, function ($query) use ($buscar) {
            return $query->where('detalle', 'LIKE', '%' . $buscar . '%');
        })
        ->when($this->filtro_fecha, function ($query) {
            $fechaInicio = $this->filtro_fecha . ' 00:00:00';
            $fechaFin = $this->filtro_fecha . ' 23:59:59';
            return $query->whereBetween('created_at', [new Carbon($fechaInicio), new Carbon($fechaFin)]);
        })
        ->orderByDesc('created_at')
        ->paginate(60);

        $user = Auth::user();
        $this->user_id = $user->id;
        $buscar = $this->buscar;

        return view('livewire.show-log', [
            'consulta' => $consulta,
            'consultaEmpresas' => $this->empresas
        ]);
    }

    //CREAR 
    public function guardar()
    {
        $validatedData = $this->validate([
            'empresa_id' => ['required'],
            'user_id' => ['required'],
        ]);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {

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

    public function confirmed()
    {
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $validatedData = $this->validate([]);

        $this->editar = false;

        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();
    }

    public function limpiarInput()
    {
    }
}
