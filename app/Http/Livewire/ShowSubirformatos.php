<?php

namespace App\Http\Livewire;


use App\Models\Formatos;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;



class ShowSubirformatos extends Component
{

    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = "Formatos";
    public $nombre;
    public $descripcion;
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;
    public $archivo;
    public $upload_archivo;
    public $empresa_id;
    public $experiencia_laboral;
    public $eliminarItem = ['1'];

    protected $listeners = ['mensajeEnviado'];


    public function mensajeEnviado($empresa_id)
    {   

        $this->empresa_id= $empresa_id->id;
        
    }

    public function render()
    {       
        if(empty($this->empresa_id)){
            $this->empresa_id = config('app.empresa')->id;
        }
        
        $buscar = $this->buscar;

        $consulta = Formatos::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
            })
            ->where('empresa_id',$this->empresa_id)->paginate(20);


        return view('livewire.show-subirformatos', [
            'consulta' => $consulta,

        ]);
    }


    //CREAR 
    public function guardar()
    {
        
        if ($this->upload_archivo) {
            $nombrePersonalizado = $this->nombre.'.' . $this->upload_archivo->getClientOriginalExtension();
            $this->archivo = $this->upload_archivo->storeAs('storage',$nombrePersonalizado);
        }


        $validatedData = $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'archivo' => 'required',
            'empresa_id'=> 'required',
            'experiencia_laboral'=> 'required',
        ]);

        Formatos::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Formatos::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->archivo = $this->consultaVer->archivo;
        $this->experiencia_laboral = $this->consultaVer->experiencia_laboral ;
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
        Formatos::whereIn('_id', $this->eliminarItem)->delete();

        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {

        $this->consultaVer = Formatos::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->archivo = $this->consultaVer->archivo;
        $this->experiencia_laboral = $this->consultaVer->experiencia_laboral ;
        $this->editar = true;

    }

    //ACTUALIZAR
    public function actualizar($id)
    {
            
        if ($this->upload_archivo) {
            $nombrePersonalizado = $this->nombre.'.' . $this->upload_archivo->getClientOriginalExtension();
            $this->archivo = $this->upload_archivo->storeAs('storage',$nombrePersonalizado);
        }

        $validatedData = $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'archivo' => 'required',
            'experiencia_laboral'=> 'required',
        ]);


        Formatos::find($id)->update($validatedData);


        $this->editar = false;
        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();

    }

    public function limpiarInput()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->archivo = '';
        $this->upload_archivo = '';

    }
}