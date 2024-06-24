<?php

namespace App\Http\Livewire;

use App\Models\Log;
use App\Models\TratamientoDatos;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowTratamientodatos extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Tratamiento de datos';
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $buscar;
    public $user_id;
    public $empresa_id;
    public $nombre;
    public $descripcion;
    public $url;
    public $eliminarItem = ['1'];
    public $upload_archivo;


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
    public function render()
    {
        if (empty($this->empresa_id)) {
            $this->empresa_id = config('app.empresa')->id;
        }

        $buscar = $this->buscar;

        $consulta = TratamientoDatos::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
            })
            ->where('empresa_id', $this->empresa_id)->orderBy('created_at', 'desc')->paginate(20);

        $user = Auth::user();
        $this->user_id = $user->id;
        $buscar = $this->buscar;


        return view('livewire.show-tratamientodatos', [
            'consulta' => $consulta,

        ]);
    }

    //CREAR 
    public function guardar()
    {

        if ($this->upload_archivo) {
            $nombrePersonalizado = $this->nombre . '.' . $this->upload_archivo->getClientOriginalExtension();
            $this->url = $this->upload_archivo->storeAs('storage', $nombrePersonalizado);
        }


        $validatedData = $this->validate([
            'empresa_id' => 'required',
            'user_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'url' => 'required',
        ]);


        $log = new Log([
            'user_id' => auth()->user()->id,
            'empresa_id' => config('app.empresa')->id,
            'usuario_actualizador' => auth()->user()->id,
            'detalle' => 'Actualización de políticas de datos'
        ]);

        $log->save();

        TratamientoDatos::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {

        $this->consultaVer = TratamientoDatos::find($id);
        $this->empresa_id = $this->consultaVer->empresa_id;
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->url = $this->consultaVer->url;

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
        TratamientoDatos::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->consultaVer = TratamientoDatos::find($id);
        $this->empresa_id = $this->consultaVer->empresa_id;
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->url = $this->consultaVer->url;
        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {

        if ($this->upload_archivo) {
            $nombrePersonalizado = $this->nombre . '.' . $this->upload_archivo->getClientOriginalExtension();
            $this->url = $this->upload_archivo->storeAs('storage', $nombrePersonalizado);
        }

        $validatedData = $this->validate([
            'empresa_id' => 'required',
            'user_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'url' => 'required',
        ]);
        $tratamiento = TratamientoDatos::find($id);
        $tratamiento->update($validatedData);

        $log = new Log([
            'user_id' => auth()->user()->id,
            'usuario_actualizador' => auth()->user()->id,
            'empresa_id' => config('app.empresa')->id,
            'detalle' => 'Actualización de políticas de datos'
        ]);

        $log->save();
        
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
