<?php
namespace App\Http\Livewire;

use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowCliente extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Cliente';

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
    public $identificacion;
    public $email;
    public $telefono;
    public $direccion;
    public $pais;
    public $fecha_nacimiento;
    public $genero;
    //public $preferencias_habitacion;
    //public $membresia;
    //public $comentarios;
    public $fecha_registro;
    public $ultima_fecha_estancia;
    public $notas_personal;


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

        $consultaCliente = Cliente::where(function ($query) use ($buscar) {
            if ($buscar != null) {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            }
        })->paginate(20);

        return view('livewire.show-cliente', [
            'consultaCliente' => $consultaCliente,
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
            'identificacion' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'pais' => 'required',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
            //'preferencias_habitacion' => 'required',
            //'membresia' => 'required',
            //'comentarios' => 'required',
            'fecha_registro' => 'required',
            'ultima_fecha_estancia' => 'required',
            'notas_personal' => 'required',
        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'identificacion.required'=>'La identificacion es obligatoria',
            'email.required'=>'El email es obligatorio',
            'telefono.required'=>'El telefono obligatorio',
            'direccion.required'=>'La direccion es obligatoria',
            'pais.required'=>'El pais es obligatorio',
            'fecha_nacimiento.required'=>'La fecha de nacimiento es obligatoria',
            'genero.required'=>'El genero es obligatorio',
            //'preferencias_habitacion.required'=>'La preferencia de habitacion es obligatoria',
            //'membresia.required'=>'La memebresia es obligatoria',
            //'comentarios.required'=>'El comentario es obligatorio',
            'fecha_registro.required'=>'La fecha de registro es obligatoria',
            'ultima_fecha_estancia.required'=>'La ultima fecha de estancia es obligatoria',
            'nota_personal.required'=>'La nota es obligatorio',
        ]); 


        Cliente::create([
            'nombre' => $this->nombre,
            'identificacion' => $this->identificacion,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'pais' => $this->pais,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'genero' => $this->genero,
            //'preferencias_habitacion' => $this->preferencias_habitacion,
            //'membresia' => $this->membresia,
            //'comentarios' => $this->comentarios,
            'fecha_registro' => $this->fecha_registro,
            'ultima_fecha_estancia' => $this->ultima_fecha_estancia,
            'notas_personal' => $this->notas_personal,
        ]);

        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Cliente::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->identificacion = $this->consultaVer->identificacion;
        $this->email = $this->consultaVer->email;
        $this->telefono = $this->consultaVer->telefono;
        $this->direccion = $this->consultaVer->direccion;
        $this->pais = $this->consultaVer->pais;
        $this->fecha_nacimiento = $this->consultaVer->fecha_nacimiento;
        $this->genero = $this->consultaVer->genero;
        //$this->preferencias_habitacion = $this->consultaVer->preferencias_habitacion;
        //$this->membresia = $this->consultaVer->membresia;
        //$this->comentarios = $this->consultaVer->comentarios;
        $this->fecha_registro = $this->consultaVer->fecha_registro;
        $this->ultima_fecha_estancia = $this->consultaVer->ultima_fecha_estancia;
        $this->notas_personal = $this->consultaVer->notas_personal;

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

        $this->consultaVer = Cliente::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->identificacion = $this->consultaVer->identificacion;
        $this->email = $this->consultaVer->email;
        $this->telefono = $this->consultaVer->telefono;
        $this->direccion = $this->consultaVer->direccion;
        $this->pais = $this->consultaVer->pais;
        $this->fecha_nacimiento = $this->consultaVer->fecha_nacimiento;
        $this->genero = $this->consultaVer->genero;
        //$this->preferencias_habitacion = $this->consultaVer->preferencias_habitacion;
        //$this->membresia = $this->consultaVer->membresia;
        //$this->comentarios = $this->consultaVer->comentarios;
        $this->fecha_registro = $this->consultaVer->fecha_registro;
        $this->ultima_fecha_estancia = $this->consultaVer->ultima_fecha_estancia;
        $this->notas_personal = $this->consultaVer->notas_personal;

        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'nombre' => 'required',
            'identificacion' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'pais' => 'required',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
            //'preferencias_habitacion' => 'required',
            //'membresia' => 'required',
            //'comentarios' => 'required',
            'fecha_registro' => 'required',
            'ultima_fecha_estancia' => 'required',
            'notas_personal' => 'required',
        ],[
            'nombre.required'=>'El nombre es obligatorio',
            'identificacion.required'=>'La identificacion es obligatoria',
            'email.required'=>'El email es obligatorio',
            'telefono.required'=>'El telefono obligatorio',
            'direccion.required'=>'La direccion es obligatoria',
            'pais.required'=>'El pais es obligatorio',
            'fecha_nacimiento.required'=>'La fecha de nacimiento es obligatoria',
            'genero.required'=>'El genero es obligatorio',
            //'preferencias_habitacion.required'=>'La preferencia de habitacion es obligatoria',
            //'membresia.required'=>'La memebresia es obligatoria',
            //'comentarios.required'=>'El comentario es obligatorio',
            'fecha_registro.required'=>'La fecha de registro es obligatoria',
            'ultima_fecha_estancia.required'=>'La ultima fecha de estancia es obligatoria',
            'nota_personal.required'=>'La nota es obligatorio',
        ]); 


        Cliente::find($id)->update([
            'nombre' => $this->nombre,
            'identificacion' => $this->identificacion,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'pais' => $this->pais,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'genero' => $this->genero,
            //'preferencias_habitacion' => $this->preferencias_habitacion,
            //'membresia' => $this->membresia,
            //'comentarios' => $this->comentarios,
            'fecha_registro' => $this->fecha_registro,
            'ultima_fecha_estancia' => $this->ultima_fecha_estancia,
            'notas_personal' => $this->notas_personal,
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
        $this->identificacion = null;
        $this->email = null;
        $this->telefono = null;
        $this->direccion = null;
        $this->pais = null;
        $this->fecha_nacimiento = null;
        $this->genero = null;
        //$this->preferencias_habitacion = null;
        //$this->membresia = null;
        //$this->comentarios = null;
        $this->fecha_registro = null;
        $this->ultima_fecha_estancia = null;
        $this->notas_personal = null;
    }

}