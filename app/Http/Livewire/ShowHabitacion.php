<?php
namespace App\Http\Livewire;
use App\Models\Habitacion;
use App\Models\Reserva;
use App\Models\Imagenes;
use App\Models\Tipo_habitacion;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ShowHabitacion extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Habitacion';

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
    public $numero;
    public $tipo;
    public $descripcion;
    public $precio_noche;
    public $estado;
    public $capacidad;
    //public $facilidades;
    //public $vistas;
    //public $ultima_limpieza;
    //public $estado_limpieza;
    //public $ultima_reserva;
    //public $id_reserva;
    public $buscarItem;
    public $imagen_id;
    public $imagenes = [];


    public function selectImagen($id)
    {
        $id = json_decode($id);
        $id = (array) $id;

        if (!in_array($id, $this->imagenes)) {
            $this->imagenes[] = $id;
        }
    }

    public function deleteImagen($id)
    {
        $this->imagenes = array_filter($this->imagenes, function ($item) use ($id) {

            return $item['_id'] !== $id;
        });
    }

    public function limpiarImagen()
    {
        $this->imagenes = [];
    }


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
        $consultaHabitacion = Habitacion::where(function ($query) use ($buscar) {
            if ($buscar != null) {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            }
        })->paginate(20);

        $buscarItem = $this->buscarItem;

        $consultaImagen = Imagenes::query()
        ->when(!empty($buscarItem), function ($query) use ($buscarItem) {
            return $query->where('nombre', 'LIKE', '%' . $buscarItem . '%');
        })
        ->whereNull('habitacion_id')
        ->get();

        return view('livewire.show-habitacion',[
            'consultaHabitacion' => $consultaHabitacion,
            //'consultaReserva' => Reserva::all(),
            'consultaTipoHabitacion' => Tipo_habitacion::all(),
            'consultaImagen' => $consultaImagen,
        ]);

    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
            'numero' => 'required',
            'tipo' => 'required',
            'descripcion' => 'required',
            'precio_noche' => 'required',
            'estado' => 'required',
            'capacidad' => 'required',
            //'facilidades' => 'required',
            //'vistas' => 'required',
            //'ultima_limpieza' => 'required',
            //'estado_limpieza' => 'required',
            //'ultima_reserva' => 'required',
            //'id_reserva' => 'required',
            
        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'numero.required'=>'El numero es obligatorio',
            'tipo.required'=>'El tipo es obligatorio',
            'descripcion.required'=>'La descripcion es obligatoria',
            'precio_noche.required'=>'El precio es obligatorio',
            'estado.required'=>'El estado es obligatorio',
            'capacidad.required'=>'La capacidad es obligatoria',
            //'facilidades.required'=>'Las facilidades son obligatorias',
            //'vistas.required'=>'Las vistas son obligatorias',
            //'ultima_limpieza.required'=>'La ultima limpieza es obligatoria',
            //'estado_limpieza.required'=>'El estado de limpieza es obligatorio',
            //'ultima_reserva.required'=>'La ultima reserva es obligatoria',
            //'id_reserva.required'=>'El id de reserva es obligatorio',
        ]);

        if (!is_null($this->imagenes)) {
            $imagen_id = [];

            foreach ($this->imagenes as $imagen) {
                if (isset($imagen['_id'])) {
                    $imagen_id[] = $imagen['_id'];
                }
            }
        
        $habitacion = Habitacion::create([
            'nombre' => $this->nombre,
            'numero' => $this->numero,
            'tipo' => $this->tipo,
            'descripcion' => $this->descripcion,
            'precio_noche' => $this->precio_noche,
            'estado' => $this->estado,
            'capacidad' => $this->capacidad,
            //'facilidades' => $this->facilidades,
            //'vistas' => $this->vistas,
            //'ultima_limpieza' => $this->ultima_limpieza,
            //'estado_limpieza' => $this->estado_limpieza,
            //'ultima_reserva' => $this->ultima_reserva,
            //'id_reserva' => $this->id_reserva,
            'imagen_id' => $imagen_id,
    
        ]);
    
        Imagenes::whereIn('_id', $imagen_id)->update(['habitacion_id' => $habitacion->id]);

        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }
}

    /**
     * Update the imagen with the given ID.
     *
     * @param  int  $id
     * @return void
     */

    //ACTUALIZAR
    public function actualizar( $id)
    {
        $this->validate([
            'nombre' => 'required',
            'numero' => 'required',
            'tipo' => 'required',
            'descripcion' => 'required',
            'precio_noche' => 'required',
            'estado' => 'required',
            'capacidad' => 'required',
            //'facilidades' => 'required',
            //'vistas' => 'required',
            //'ultima_limpieza' => 'required',
            //'estado_limpieza' => 'required',
            //'ultima_reserva' => 'required',
            //'id_reserva' => 'required',


        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'numero.required'=>'El numero es obligatorio',
            'tipo.required'=>'El tipo es obligatorio',
            'descripcion.required'=>'La descripcion es obligatoria',
            'precio_noche.required'=>'El precio es obligatorio',
            'estado.required'=>'El estado es obligatorio',
            'capacidad.required'=>'La capacidad es obligatoria',
            //'facilidades.required'=>'Las facilidades son obligatorias',
            //'vistas.required'=>'Las vistas son obligatorias',
            //'ultima_limpieza.required'=>'La ultima limpieza es obligatoria',
            //'estado_limpieza.required'=>'El estado de limpieza es obligatorio',
            //'ultima_reserva.required'=>'La ultima reserva es obligatoria',
            //'id_reserva.required'=>'El id de reserva es obligatorio',

        ]);
        
        $habitacion = Habitacion::find($id);

        $imagenesOld = $habitacion -> imagen_id;

        if(!$habitacion){
            $this->alert('error', 'La habitacion no existe!', [
                'position' => 'top'
            ]);
            return;
        }

        // If campos is not null, update area and handle campo associations
        if (!is_null($this->imagenes)) {
            $imagen_id = [];

            foreach ($this->imagenes as $imagen) {
                if (isset($imagen['_id'])) {
                    $imagen_id[] = $imagen['_id'];
                }
            }

            $habitacion->update([
                'nombre' => $this->nombre,
                'numero' => $this->numero,
                'tipo' => $this->tipo,
                'descripcion' => $this->descripcion,
                'precio_noche' => $this->precio_noche,
                'estado' => $this->estado,
                'capacidad' => $this->capacidad,
                //'facilidades' => $this->facilidades,
                //'vistas' => $this->vistas,
                //'ultima_limpieza' => $this->ultima_limpieza,
                //'estado_limpieza' => $this->estado_limpieza,
                //'ultima_reserva' => $this->ultima_reserva,
                //'id_reserva' => $this->id_reserva,
                'imagen_id'=> $imagen_id,
    
            ]);

            // If there are changes in campo IDs, update campo associations
            if (is_null($imagenesOld) || count($imagenesOld) == 0 || $imagenesOld != $imagen_id) {
                Imagenes::whereIn('_id', $imagen_id)->update(['habitacion_id' => $habitacion->id]);
                Imagenes::whereNotIn('_id', $imagen_id)->where('habitacion_id', $habitacion->id)->update(['habitacion_id' => null]);
            }
        } else {
            // If campos is null, update area and handle campo associations
            $habitacion->update([
                'nombre' => $this->nombre,
                'numero' => $this->numero,
                'tipo' => $this->tipo,
                'descripcion' => $this->descripcion,
                'precio_noche' => $this->precio_noche,
                'estado' => $this->estado,
                'capacidad' => $this->capacidad,
                //'facilidades' => $this->facilidades,
                //'vistas' => $this->vistas,
                //'ultima_limpieza' => $this->ultima_limpieza,
                //'estado_limpieza' => $this->estado_limpieza,
                //'ultima_reserva' => $this->ultima_reserva,
                //'id_reserva' => $this->id_reserva,
            ]);

            // If there were previous campo associations, remove them
            if (!is_null($imagenesOld) && count($imagenesOld) > 0) {
                Imagenes::where('habitacion_id', $habitacion->id)->update(['habitacion_id' => null]);
            }
        }

        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }


    //VER
    public function ver($id)
    {
        $this->consultaVer = Habitacion::find($id);

        $this->nombre = $this->consultaVer->nombre;
        $this->numero = $this->consultaVer->numero;
        $this->tipo = $this->consultaVer->tipo;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->precio_noche = $this->consultaVer->precio_noche;
        $this->estado = $this->consultaVer->estado;
        $this->capacidad = $this->consultaVer->capacidad;
        //$this->facilidades = $this->consultaVer->facilidades;
        //$this->vistas = $this->consultaVer->vistas;
        //$this->ultima_limpieza = $this->consultaVer->ultima_limpieza;
        //$this->estado_limpieza = $this->consultaVer->estado_limpieza;
        //$this->ultima_reserva = $this->consultaVer->ultima_reserva;
        //$this->id_reserva = $this->consultaVer->id_reserva;
        $this->imagen_id = $this->consultaVer->imagen_id;
 

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
        Habitacion::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->ver = false;

        $this->consultaVer = Habitacion::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->numero = $this->consultaVer->numero;
        $this->tipo = $this->consultaVer->tipo;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->precio_noche = $this->consultaVer->precio_noche;
        $this->estado = $this->consultaVer->estado;
        $this->capacidad = $this->consultaVer->capacidad;
        //$this->facilidades = $this->consultaVer->facilidades;
        //$this->vistas = $this->consultaVer->vistas;
        //$this->ultima_limpieza = $this->consultaVer->ultima_limpieza;
        //$this->estado_limpieza = $this->consultaVer->estado_limpieza;
        //$this->ultima_reserva = $this->consultaVer->ultima_reserva;
        //$this->id_reserva = $this->consultaVer->id_reserva;
        if (!is_null($this->consultaVer->imagen_id)) {
            $this->imagenes = Imagenes::whereIn('_id', $this->consultaVer->imagen_id)->get()->toArray();
        }


        $this->editar = true;
    }

    public function limpiarInput()
    {
        $this->ver = false;
        $this->editar = false;
        $this->nuevo = false;

        $this->nombre = null;
        $this->numero = null;
        $this->tipo = null;
        $this->descripcion = null;
        $this->precio_noche = null;
        $this->estado = null;
        $this->capacidad = null;
        //$this->facilidades = null;
        //$this->vistas = null;
        //$this->ultima_limpieza = null;
        //$this->estado_limpieza = null;
        //$this->ultima_reserva = null;
        //$this->id_reserva = null;
        $this->imagenes = [];
        


    }

}
