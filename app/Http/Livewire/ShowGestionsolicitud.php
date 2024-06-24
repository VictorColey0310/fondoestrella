<?php

namespace App\Http\Livewire;


use App\Models\Formatos;
use App\Models\Solicitudes;
use App\Models\User;
use App\Notifications\EstadoSolicitud;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;


class ShowGestionsolicitud extends Component
{

    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = "Solicitudes";
    public $user_id;
    public $fecha_inicio;
    public $fecha_fin;
    public $descripcion;
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;
    public $archivo;
    public $upload_archivo;
    public $empresa_id;
    public $tipo;
    public $estado = 'Enviado';


    public $eliminarItem = ['1'];



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

        //$this->user_id = Auth::user()->id;
        $buscar = $this->buscar;
        $user = Auth::user();
        $consulta = Solicitudes::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('descripcion', 'LIKE', '%' . $buscar . '%');
            })
            ->where('empresa_id', $this->empresa_id)->where('plan_id',$user->plan_id)->paginate(20);
        return view('livewire.show-gestionsolicitud', [
            'consulta' => $consulta,

        ]);
    }



    //VER
    public function ver($id)
    {
        $this->consultaVer = Solicitudes::find($id);
        $this->descripcion = $this->consultaVer->descripcion;
        $this->archivo = $this->consultaVer->archivo;
        $this->fecha_inicio = $this->consultaVer->fecha_inicio;
        $this->fecha_fin = $this->consultaVer->fecha_fin;
        $this->tipo = $this->consultaVer->tipo;
        $this->estado = $this->consultaVer->estado;
        $this->user_id = $this->consultaVer->user_id;

        $this->ver = true;

    }


    //ACTUALIZAR
    public function aprobar($id)
    {
        $this->estado = 'Aprobado';
        $validatedData = $this->validate([
            'fecha_inicio' => 'nullable|date|after:tomorrow',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'tipo' => 'required',
            'estado' => 'required',
        ]);

        Solicitudes::find($id)->update($validatedData);

        
        $this->alert('success', 'Aprobado correctamente!', [
            'position' => 'top'
        ]);

        $user = User::find($this->user_id);
        $user->notify(new EstadoSolicitud($user->name, $this->estado));

        $this->limpiarInput();
        $this->ver = false;

    }
    //ACTUALIZAR
    public function cancelar($id)
    {
        $this->estado = 'Cancelado';
        $validatedData = $this->validate([
            'estado' => 'required',
        ]);

        Solicitudes::find($id)->update($validatedData);

        $this->ver = false;
        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);
        $user = User::find($this->user_id);
        $user->notify(new EstadoSolicitud($user->name, $this->estado));

        $this->limpiarInput();


    }

    public function limpiarInput()
    {

        $this->descripcion = '';
        $this->archivo = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->estado = '';

    }
}