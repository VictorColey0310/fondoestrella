<?php
namespace App\Http\Livewire;

use App\Models\Salon_eventos;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ShowSalon_eventos extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Salon_eventos';

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
    public $capacidad_maxima;
    public $descripcion;
    public $equipamiento;
    public $dimenciones;
    public $imagen;
    public $imagen_data;
    public $estado_disponibilidad;
    public $tarifa_base;
    public $ubicacion;


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

        $consultaSalonEventos = Salon_eventos::where(function ($query) use ($buscar) {
            if ($buscar != null) {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            }
        })->paginate(20);

        return view('livewire.show-salon_eventos', [
            'consultaSalonEventos' => $consultaSalonEventos,
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
            'capacidad_maxima' => 'required',
            'descripcion' => 'required',
            'equipamiento' => 'required',
            'dimenciones' => 'required',
            'imagen' => 'nullable|image',
            'estado_disponibilidad' => 'required',
            'tarifa_base' => 'required',
            'ubicacion' => 'required',
        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'capacidad_maxima.required'=>'La capacidad maxima es obligatoria',
            'descripcion.required'=>'La descripcion es obligatorio',
            'equipamiento.required'=>'El equipamiento obligatorio',
            'dimenciones.required'=>'Las dimenciones son obligatorias',
            'estado_disponibilidad.required'=>'El estado es obligatorio',
            'tarifa_base.required'=>'La tarifa base es obligatoria',
            'ubicacion.required'=>'La ubicacion es obligatoria',
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

        Salon_eventos::create([
            'nombre' => $this->nombre,
            'capacidad_maxima' => $this->capacidad_maxima,
            'descripcion' => $this->descripcion,
            'equipamiento' => $this->equipamiento,
            'dimenciones' => $this->dimenciones,
            'imagen' => $url_imagen,
            'estado_disponibilidad' => $this->estado_disponibilidad,
            'tarifa_base' => $this->tarifa_base,
            'ubicacion' => $this->ubicacion,
        ]);

        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }

    //VER
    public function ver($id)
    {

        $this->consultaVer = Salon_eventos::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->capacidad_maxima = $this->consultaVer->capacidad_maxima;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->equipamiento = $this->consultaVer->equipamiento;
        $this->dimenciones = $this->consultaVer->dimenciones;
        $this->imagen_data = $this->consultaVer->imagen;
        $this->estado_disponibilidad = $this->consultaVer->estado_disponibilidad;
        $this->tarifa_base = $this->consultaVer->tarifa_base;
        $this->ubicacion = $this->consultaVer->ubicacion;
        


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
    public function editar(Salon_eventos $id)
    {
        $this->ver = false;

        $this->consultaVer = $id;
        $this->nombre = $this->consultaVer->nombre;
        $this->capacidad_maxima = $this->consultaVer->capacidad_maxima;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->equipamiento = $this->consultaVer->equipamiento;
        $this->dimenciones = $this->consultaVer->dimenciones;
        $this->imagen_data = $this->consultaVer->imagen;
        $this->estado_disponibilidad = $this->consultaVer->estado_disponibilidad;
        $this->tarifa_base = $this->consultaVer->tarifa_base;
        $this->ubicacion = $this->consultaVer->ubicacion;
    

        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar(Salon_eventos $id)
    {
        $this->validate([
            'nombre' => 'required',
            'capacidad_maxima' => 'required',
            'descripcion' => 'required',
            'equipamiento' => 'required',
            'dimenciones' => 'required',
            'imagen' => 'nullable|image',
            'estado_disponibilidad' => 'required',
            'tarifa_base' => 'required',
            'ubicacion' => 'required',
        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'capacidad_maxima.required'=>'La capacidad maxima es obligatoria',
            'descripcion.required'=>'La descripcion es obligatorio',
            'equipamiento.required'=>'El equipamiento obligatorio',
            'dimenciones.required'=>'Las dimenciones son obligatorias',
            'estado_disponibilidad.required'=>'El estado es obligatorio',
            'tarifa_base.required'=>'La tarifa base es obligatoria',
            'ubicacion.required'=>'La ubicacion es obligatoria',
        ]); 

        if ($this->imagen) {
            $url_imagen = $this->imagen->store('storage', ['disk' => 'local']);
        } else {
            $url_imagen = $this->imagen_data;
        }

        $id->update([
            'nombre' => $this->nombre,
            'capacidad_maxima' => $this->capacidad_maxima,
            'descripcion' => $this->descripcion,
            'equipamiento' => $this->equipamiento,
            'dimenciones' => $this->dimenciones,
            'imagen' => $url_imagen,
            'estado_disponibilidad' => $this->estado_disponibilidad,
            'tarifa_base' => $this->tarifa_base,
            'ubicacion' => $this->ubicacion,
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
        $this->capacidad_maxima = null;
        $this->descripcion = null;
        $this->equipamiento = null;
        $this->dimenciones = null;
        $this->imagen = null;
        $this->estado_disponibilidad = null;
        $this->tarifa_base = null;
        $this->ubicacion = null;

        $this->imagen_data = null;

    }

}