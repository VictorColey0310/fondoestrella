<?php

namespace App\Http\Livewire;


use App\Models\Formatos;
use App\Models\Planes;
use App\Models\Roles;
use App\Models\Solicitudes;
use App\Models\User;
use App\Notifications\Solicitud;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use PhpParser\Node\Stmt\Foreach_;


class ShowSolicitudes extends Component
{
    
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = "Solicitudes";
    public $user_id;
    public $plan_id;
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
    public $planes;
    public $estado ='Enviado';


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
        
        $this->empresa_id= $empresa_id->id;
        
    }
    public function render()
    {
        if(empty($this->empresa_id)){
            $this->empresa_id = config('app.empresa')->id;
        }
        
        $user= Auth::user();
        $this->plan_id = $user->plan_id;
        $this->user_id= $user->id;
        $buscar = $this->buscar;

        $consulta = Solicitudes::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('descripcion', 'LIKE', '%' . $buscar . '%');
            })
            ->where('empresa_id',$this->empresa_id)->where('user_id',$this->user_id)->paginate(20);

            
            
        return view('livewire.show-solicitudes', [
            'consulta' => $consulta,

        ]);
    }

    
    //CREAR 
    public function guardar()
    {
      
        if ($this->upload_archivo) {
            $this->archivo = $this->upload_archivo->store('storage');
        }
        dd($this->plan_id);
        $validatedData = $this->validate([
            'user_id' => 'required',
            'plan_id' => ' required',
            'empresa_id' => 'required',
            'archivo' => 'nullable',
            'fecha_inicio' => 'nullable|date|after:today',
            'descripcion' => 'required',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo' => 'required',
            'estado' => 'required',
        ]);
        //dd($validatedData);
        Solicitudes::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
        $this->nuevo = false;
        $this->limpiarInput();

        $roles = Roles::where('aprobador_permisos', true)->get();

        foreach ($roles as $rol) {
            //dd($this->plan_id);
            $user = $rol->usuario->first(); // Sin usar get() aquí
           
            if ($user && $user->plan->id == $this->plan_id) {
                $user->notify(new Solicitud($user->name));
            }else{
                $this->alert('warning', 'La solicitud no pudo ser notificada!', [
                    'position' => 'top'
                ]);
            }
        }
        
    



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
        $this->plan_id = $this->consultaVer->plan_id;

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
        Solicitudes::whereIn('_id', $this->eliminarItem)->delete();

        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->consultaVer = Solicitudes::find($id);
        $this->descripcion = $this->consultaVer->descripcion;
        $this->archivo = $this->consultaVer->archivo;
        $this->fecha_inicio = $this->consultaVer->fecha_inicio;
        $this->fecha_fin = $this->consultaVer->fecha_fin;
        $this->tipo = $this->consultaVer->tipo;
        $this->estado = $this->consultaVer->estado;
        $this->editar = true;

    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        if ($this->upload_archivo) {
            $this->archivo = $this->upload_archivo->store('storage');
        }
        $validatedData = $this->validate([
            'archivo' => 'nullable',
            'fecha_inicio' => 'required|date|after:tomorrow',
            'descripcion' => 'required',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'tipo' => 'required',
            'estado' => 'required',
        ]);


        Solicitudes::find($id)->update($validatedData);


        $this->editar = false;
        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();

    }

    public function limpiarInput()
    {
        
        $this->descripcion ='';
        $this->archivo = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->estado = '';

    }
}
