<?php

namespace App\Http\Livewire;

use App\Models\Iconos;
use App\Models\Modulos;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
class ShowModules extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $nombre;
    public $icono;
    public $descripcion;
    public $estado = 1;
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;

    public $eliminarItem = ['1'];
    public $usuario_creador;
    public $usuario_actualizador;
    public function render()
    {
        $buscar = $this->buscar;

        $consulta = Modulos::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
            })
            ->paginate(20);
        $consultaIconos = Iconos::get();    
            //dd($consultaIconos);
        return view('livewire.show-modules', [
            'consulta' => $consulta,
            'consultaIconos' => $consultaIconos
        ]);
    }

    //CREAR 
    public function guardar()
    {
        $this->usuario_creador = Auth::user()->id;
        $validatedData = $this->validate([
            'nombre' => 'required',
            'icono' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
            'usuario_creador' => 'required'
        ]);

        Modulos::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
        $this->nuevo = false;
        $this->limpiarInput();
    }

    //CAMBIAR ESTADO 
    public function cambiarEstado($id, $estado)
    {
        $estado = $estado ? 0 : 1;

        $actualizar = Modulos::find($id)->update(['estado' => $estado]);
        
        if ($actualizar && $estado == 1) {
            $this->alert('success', 'Modulo activo!', [
                'position' => 'top'
            ]);
        }
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Modulos::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->icono = $this->consultaVer->icono;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->estado = $this->consultaVer->estado == 1 ? 'Activo' : 'Inactivo';
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
        Modulos::whereIn('_id', $this->eliminarItem)->delete();
        
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem=['1'];
    }

    //VER EDITAR
    public function editar($id)
    {

        $this->consultaVer = Modulos::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->icono = $this->consultaVer->icono;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->estado = $this->consultaVer->estado;
        $this->editar = true;

    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->usuario_actualizador = Auth::user()->id;
        $validatedData = $this->validate([
            'nombre' => 'required',
            'icono' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
            'usuario_actualizador' => 'required'
        ]);

        Modulos::find($id)->update($validatedData);

       
        $this->editar = false;
        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();
        
    }

    public function limpiarInput(){
        $this->nombre= '';
        $this->icono='';
        $this->descripcion='';
        $this->estado=1;

    }
}