<?php
namespace App\Http\Livewire;
use App\Models\Tipo_habitacion;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowTipo_habitacion extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Tipo_habitacion';

    // MODALES
    public $nuevo = false;
    public $editar = false;
    public $ver = false;

    // FILTROS
    public $buscar;
    public $user_id;
    public $empresa_id;
    public $eliminarItem = ['1'];

    // DATOS
    public $consultaVer;
    public $nombre;
    public $descripcion;


    public function getListeners()
    {
        return [
            'confirmed',
            'mensajeEnviado'
        ];
    }

    public function mensajeEnviado($empresa_id)
    {
        $this->empresa_id= $empresa_id->id;
    }
    public function mount()
    {
        $user = Auth::user();
        $this->user_id = $user->id;
    }
    public function render()
    {
        if (empty($this->empresa_id)) {
            $this->empresa_id = config('app.empresa')->id;
        }
        $buscar = $this->buscar;

        $consultaTipoHabitacion = Tipo_habitacion::where(function ($query) use ($buscar) {
            if ($buscar != null) {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            }
        })->paginate(20);


        return view('livewire.show-tipo_habitacion',[
            'consultaTipoHabitacion' => $consultaTipoHabitacion,
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'descripcion.required'=>'La descripcion es obligatoria',

        ]); 

        Tipo_habitacion::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ]);

        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Tipo_habitacion::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion= $this->consultaVer->descripcion;
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
        $this->ver = false;

        $this->consultaVer = Tipo_habitacion::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;

        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'descripcion.required'=>'La descripcion es obligatoria',

        ]); 

        Tipo_habitacion::find($id)->update([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        ]);

        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }

    public function limpiarInput()
    {
        $this->ver = false;
        $this->editar = false;
        $this->nuevo = false;

        $this->nombre = null;
        $this->descripcion = null;
    }

}