<?php
namespace App\Http\Livewire;

use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Habitacion;
use App\Models\Metodos_pago;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowReserva extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Reserva';

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
    public $cliente_id;
    public $habitacion_id;
    public $fecha_check_in;
    public $fecha_check_out;
    public $cantidad_adultos;
    public $cantidad_niños;
    public $estado;
    public $pago;
    public $metodo_pago;
    public $comentario;
    public $fecha_reserva;
    public $estado_reserva;
    public $duracion_estancia;
    public $precio_total;

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

        $consultaReserva = Reserva::where(function ($query) use ($buscar) {
            if ($buscar != null) {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            }
        })->paginate(20);

        return view('livewire.show-reserva', [
            'consultaReserva' => $consultaReserva,
            'consultaCliente' => Cliente::all(),
            'consultaMetodosPago' => Metodos_pago::all(),
            'consultaHabitacion' => Habitacion::all(),
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'cliente_id' => 'required',
            'habitacion_id' => 'required',
            'fecha_check_in' => 'required',
            'fecha_check_out' => 'required',
            'cantidad_adultos' => 'required',
            'cantidad_niños' => 'required',
            'estado' => 'required',
            'pago' => 'required',
            'metodo_pago' => 'required',
            'comentario' => 'required',
            'fecha_reserva' => 'required',
            'estado_reserva' => 'required',
            'duracion_estancia' => 'required',
            'precio_total' => 'required',
        ],[
            'cliente_id.required'=>'El cliente es obligatorio',
            'habitacion_id.required'=>'La habitacion es obligatorio',
            'fecha_check_in.required'=>'La fecha y hora de entrada es obligatoria',
            'fecha_check_out.required'=>'La fecha y hora de salida obligatoria',
            'cantidad_adultos.required'=>'La cantidad de adultos es obligatorio',
            'cantidad_niños.required'=>'La cantidad de niños es obligatoria',
            'estado.required'=>'El estado es obligatorio',
            'pago.required'=>'El pago es obligatorio',
            'metodo_pago.required'=>'El metodo de pago es obligatorio',
            'comentario.required'=>'El comentario es obligatorio',
            'fecha_reserva.required'=>'La fecha de reserva es obligatorio',
            'estado_reserva.required'=>'El Estado de reserva es obligatorio',
            'duracion_estancia.required'=>'La duracion de estancia es obligatorio',
            'precio_total.required'=>'El precio total es obligatorio',
            
        ]); 


        Reserva::create([
            'cliente_id' => $this->cliente_id,
            'habitacion_id' => $this->habitacion_id,
            'fecha_check_in' => $this->fecha_check_in,
            'fecha_check_out' => $this->fecha_check_out,
            'cantidad_adultos' => $this->cantidad_adultos,
            'cantidad_niños' => $this->cantidad_niños,
            'estado' => $this->estado,
            'pago' => $this->pago,
            'metodo_pago' => $this->metodo_pago,
            'comentario' => $this->comentario,
            'fecha_reserva' => $this->fecha_reserva,
            'estado_reserva' => $this->estado_reserva,
            'duracion_estancia' => $this->duracion_estancia,
            'precio_total' => $this->precio_total,
        ]);

        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Reserva::find($id);
        $this->cliente_id = $this->consultaVer->cliente_id;
        $this->habitacion_id = $this->consultaVer->habitacion_id;
        $this->fecha_check_in = $this->consultaVer->fecha_check_in;
        $this->fecha_check_out = $this->consultaVer->fecha_check_out;
        $this->cantidad_adultos = $this->consultaVer->cantidad_adultos;
        $this->cantidad_niños = $this->consultaVer->cantidad_niños;
        $this->estado = $this->consultaVer->estado;
        $this->pago = $this->consultaVer->pago;
        $this->metodo_pago = $this->consultaVer->metodo_pago;
        $this->comentario = $this->consultaVer->comentario;
        $this->fecha_reserva = $this->consultaVer->fecha_reserva;
        $this->estado_reserva = $this->consultaVer->estado_reserva;
        $this->duracion_estancia = $this->consultaVer->duracion_estancia;
        $this->precio_total = $this->consultaVer->precio_total;

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

        $this->consultaVer = Reserva::find($id);
        $this->cliente_id = $this->consultaVer->cliente_id;
        $this->habitacion_id = $this->consultaVer->habitacion_id;
        $this->fecha_check_in = $this->consultaVer->fecha_check_in;
        $this->fecha_check_out = $this->consultaVer->fecha_check_out;
        $this->cantidad_adultos = $this->consultaVer->cantidad_adultos;
        $this->cantidad_niños = $this->consultaVer->cantidad_niños;
        $this->estado = $this->consultaVer->estado;
        $this->pago = $this->consultaVer->pago;
        $this->metodo_pago = $this->consultaVer->metodo_pago;
        $this->comentario = $this->consultaVer->comentario;
        $this->fecha_reserva = $this->consultaVer->fecha_reserva;
        $this->estado_reserva = $this->consultaVer->estado_reserva;
        $this->duracion_estancia = $this->consultaVer->duracion_estancia;
        $this->precio_total = $this->consultaVer->precio_total;

        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'cliente_id' => 'required',
            'habitacion_id' => 'required',
            'fecha_check_in' => 'required',
            'fecha_check_out' => 'required',
            'cantidad_adultos' => 'required',
            'cantidad_niños' => 'required',
            'estado' => 'required',
            'pago' => 'required',
            'metodo_pago' => 'required',
            'comentario' => 'required',
            'fecha_reserva' => 'required',
            'estado_reserva' => 'required',
            'duracion_estancia' => 'required',
            'precio_total' => 'required',
        ],[
            'cliente_id.required'=>'El cliente es obligatorio',
            'habitacion_id.required'=>'La habitacion es obligatorio',
            'fecha_check_in.required'=>'La fecha y hora de entrada es obligatoria',
            'fecha_check_out.required'=>'La fecha y hora de salida obligatoria',
            'cantidad_adultos.required'=>'La cantidad de adultos es obligatorio',
            'cantidad_niños.required'=>'La cantidad de niños es obligatoria',
            'estado.required'=>'El estado es obligatorio',
            'pago.required'=>'El pago es obligatorio',
            'metodo_pago.required'=>'El metodo de pago es obligatorio',
            'comentario.required'=>'El comentario es obligatorio',
            'fecha_reserva.required'=>'La fecha de reserva es obligatorio',
            'estado_reserva.required'=>'El Estado de reserva es obligatorio',
            'duracion_estancia.required'=>'La duracion de estancia es obligatorio',
            'precio_total.required'=>'El precio total es obligatorio',
            
        ]); 


        Reserva::find($id)->update([
            'cliente_id' => $this->cliente_id,
            'habitacion_id' => $this->habitacion_id,
            'fecha_check_in' => $this->fecha_check_in,
            'fecha_check_out' => $this->fecha_check_out,
            'cantidad_adultos' => $this->cantidad_adultos,
            'cantidad_niños' => $this->cantidad_niños,
            'estado' => $this->estado,
            'pago' => $this->pago,
            'metodo_pago' => $this->metodo_pago,
            'comentario' => $this->comentario,
            'fecha_reserva' => $this->fecha_reserva,
            'estado_reserva' => $this->estado_reserva,
            'duracion_estancia' => $this->duracion_estancia,
            'precio_total' => $this->precio_total,
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

        $this->cliente_id = null;
        $this->habitacion_id = null;
        $this->fecha_check_in = null;
        $this->fecha_check_out = null;
        $this->cantidad_adultos = null;
        $this->cantidad_niños = null;
        $this->estado = null;
        $this->pago = null;
        $this->metodo_pago = null;
        $this->comentario = null;
        $this->fecha_reserva = null;
        $this->estado_reserva = null;
        $this->duracion_estancia = null;
        $this->precio_total = null;
    }

}