<?php
namespace App\Http\Livewire;
use App\Models\Imagenes;
use App\Models\Habitacion;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ShowImagenes extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Imagenes';

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
    public $imagen;
    public $imagen_data;
    public $habitacion_id;


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

        $consultaImagenes= Imagenes::where(function ($query) use ($buscar) {
            if ($buscar != null) {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            }
        })->paginate(20);

        return view('livewire.show-imagenes', [
            'consultaImagenes' => $consultaImagenes,
            'consultaHabitacion' => Habitacion::all(),
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
            'imagen' => 'nullable|image',
            'habitacion_id' => 'required',

        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'habitacion_id.required'=>'La habitacion es obligatoria',
        ]); 

        if ($this->imagen) {
            $nombre = Date('YmdHis') . Str::random(10);

            $location = "storage/" . $nombre . ".webp";

            $img = $this->imagen->storeAs('public', $location, ['disk' => 'local']);

            Storage::disk('local')->put($location, $img);

            $url_imagen = $location;
        } else {
            $url_imagen = null;
        }

        $habitacion = Habitacion::find($this->habitacion_id);

        if (!$habitacion) {
            $this->alert('error', 'La habitacion no existe!', [
                'position' => 'top'
            ]);

            return;
        }

        $Imagenes = Imagenes::create([
            'nombre' => $this->nombre,
            'imagen' => $url_imagen,
            'habitacion_id' => $this->habitacion_id,
        ]);

        $habitacion->update(['imagen_id' => array_merge($habitacion->imagen_id, [$Imagenes->id])]);

        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Imagenes::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->imagen_data = $this->consultaVer->imagen;
        $this->habitacion_id = $this->consultaVer->habitacion_id ?? '';
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
        Imagenes::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar(Imagenes $id)
    {
        $this->ver = false;

        $this->consultaVer = $id;
        $this->nombre = $this->consultaVer->nombre;
        $this->imagen_data = $this->consultaVer->imagen;
        $this->habitacion_id = $this->consultaVer->habitacion_id ?? '';

        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'nombre' => 'required',
            'imagen' => 'nullable|image',
            'habitacion_id' => 'required',

        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'habitacion_id.required'=>'La habiatcion es obligatoria',
        ]); 

        if ($this->imagen) {
            $url_imagen = $this->imagen->store('storage', ['disk' => 'local']);
        } else {
            $url_imagen = $this->imagen_data;
        }

        $imagenes = Imagenes::find($id);

        if (!$imagenes) {
            $this->alert('error', 'La imagen no existe!', [
                'position' => 'top'
            ]);

            return;
        }

        if ($imagenes->habiatcion_id != $this->habitacion_id) {
            $habitacionOld = Habitacion::find($imagenes->habitacion_id);

            if ($habitacionOld) {
                $habitacionOld->update(['imagen_id' => array_diff($habitacionOld->imagen_id, [$imagenes->id])]);
            }

            $habitacion = Habitacion::find($this->habitacion_id);

            if ($habitacion) {
                $habitacion->update(['imagen_id' => array_merge($habitacion->imagen_id, [$imagenes->id])]);
            }
        }

        $imagenes->update([
            'nombre' => $this->nombre,
            'imagen' => $url_imagen,
            'habitacion_id' => $this->habitacion_id,

        ]);

        $this->limpiarInput();

        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);
    }

    public function limpiarInput()
    {
        $this->ver = false;
        $this->editar = false;
        $this->nuevo = false;

        $this->nombre = null;       
        $this->imagen = null;
        $this->imagen_data = null;
        $this->habitacion_id = null;
    }

}