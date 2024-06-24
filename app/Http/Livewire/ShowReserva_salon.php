<?php
namespace App\Http\Livewire;

use App\Models\Reserva_salon;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowReserva_salon extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Reserva_salon';

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
    public $nombre_evento;
    public $tipo;
    public $fecha_hora_inicio;
    public $fecha_hora_fin;
    public $numero_asistentes;
    public $descripcion;
    public $cliente_id;
    public $servicios_adicionales;
    public $estado;


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

        $consultaReservaSalon = Reserva_salon::where(function ($query) use ($buscar) {
            if ($buscar != null) {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            }
        })->paginate(20);

        return view('livewire.show-reserva_salon', [
            'consultaReservaSalon' => $consultaReservaSalon,
            'consultaCliente' => Cliente::all(),
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'nombre_evento' => 'required',
            'tipo' => 'required',
            'fecha_hora_inicio' => 'required',
            'fecha_hora_fin' => 'required',
            'numero_asistentes' => 'required',
            'descripcion' => 'required',
            'cliente_id' => 'required',
            'servicios_adicionales' => 'required',
            'estado' => 'required',
        ],[
            'nombre_evento.required'=>'El nombre es obligatorio',
            'tipo.required'=>'el Tipo es obligatorio',
            'fecha_hora_inicio.required'=>'La fecha y hora de incio es obligatoria',
            'fecha_hora_fin.required'=>'La fecha y hora de fin obligatoria',
            'numero_asistentes'=>'El numero de asistentes es obligatorio',
            'descripcion.required'=>'La descripcion es obligatoria',
            'cliente_id.required'=>'El cliente es obligatorio',
            'servicios_adicionales.required'=>'El Servicion adicional es obligatorio',
            'estado.required'=>'El estado es obligatorio',
        ]); 


        Reserva_salon::create([
            'nombre_evento' => $this->nombre_evento,
            'tipo' => $this->tipo,
            'fecha_hora_inicio' => $this->fecha_hora_inicio,
            'fecha_hora_fin' => $this->fecha_hora_fin,
            'numero_asistentes' => $this->numero_asistentes,
            'descripcion' => $this->descripcion,
            'cliente_id' => $this->cliente_id,
            'servicios_adicionales' => $this->servicios_adicionales,
            'estado' => $this->estado,
        ]);

        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Reserva_salon::find($id);
        $this->nombre_evento = $this->consultaVer->nombre_evento;
        $this->tipo = $this->consultaVer->tipo;
        $this->fecha_hora_inicio = $this->consultaVer->fecha_hora_inicio;
        $this->fecha_hora_fin = $this->consultaVer->fecha_hora_fin;
        $this->numero_asistentes = $this->consultaVer->numero_asistentes;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->cliente_id = $this->consultaVer->cliente_id;
        $this->servicios_adicionales = $this->consultaVer->servicios_adicionales;
        $this->estado = $this->consultaVer->estado;

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

        $this->consultaVer = Reserva_salon::find($id);
        $this->nombre_evento = $this->consultaVer->nombre_evento;
        $this->tipo = $this->consultaVer->tipo;
        $this->fecha_hora_inicio = $this->consultaVer->fecha_hora_inicio;
        $this->fecha_hora_fin = $this->consultaVer->fecha_hora_fin;
        $this->numero_asistentes = $this->consultaVer->numero_asistentes;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->cliente_id = $this->consultaVer->cliente_id;
        $this->servicios_adicionales = $this->consultaVer->servicios_adicionales;
        $this->estado = $this->consultaVer->estado;

        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'nombre_evento' => 'required',
            'tipo' => 'required',
            'fecha_hora_inicio' => 'required',
            'fecha_hora_fin' => 'required',
            'numero_asistentes' => 'required',
            'descripcion' => 'required',
            'cliente_id' => 'required',
            'servicios_adicionales' => 'required',
            'estado' => 'required',
        ],[
            'nombre_evento.required'=>'El nombre es obligatorio',
            'tipo.required'=>'el Tipo es obligatorio',
            'fecha_hora_inicio.required'=>'La fecha y hora de incio es obligatoria',
            'fecha_hora_fin.required'=>'La fecha y hora de fin obligatoria',
            'numero_asistentes'=>'El numero de asistentes es obligatorio',
            'descripcion.required'=>'La descripcion es obligatoria',
            'cliente_id.required'=>'El cliente es obligatorio',
            'servicios_adicionales.required'=>'El Servicion adicional es obligatorio',
            'estado.required'=>'El estado es obligatorio',
        ]); 


        Reserva_salon::find($id)->update([
            'nombre_evento' => $this->nombre_evento,
            'tipo' => $this->tipo,
            'fecha_hora_inicio' => $this->fecha_hora_inicio,
            'fecha_hora_fin' => $this->fecha_hora_fin,
            'numero_asistentes' => $this->numero_asistentes,
            'descripcion' => $this->descripcion,
            'cliente_id' => $this->cliente_id,
            'servicios_adicionales' => $this->servicios_adicionales,
            'estado' => $this->estado,
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

        $this->nombre_evento = null;
        $this->tipo = null;
        $this->fecha_hora_inicio = null;
        $this->fecha_hora_fin = null;
        $this->numero_asistentes = null;
        $this->descripcion = null;
        $this->cliente_id = null;
        $this->servicios_adicionales = null;
        $this->estado = null;
    }

}