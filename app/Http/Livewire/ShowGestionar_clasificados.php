<?php
namespace App\Http\Livewire;

use App\Models\Clasificados;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowGestionar_clasificados extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Gestionar clasificados';

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
    public $titulo;
    public $imagen;
    public $imagen_data;
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
        $consulta = Clasificados::query()
        ->when(!empty($buscar), function ($query) use ($buscar) {
            return $query->where('titulo', 'LIKE', '%' . $buscar . '%');
        })
        ->get();

        return view('livewire.show-gestionar_clasificados', [
            'consulta' => $consulta,
        ]);
    }

    //CREAR
    public function guardar()
    {
        if ($this->imagen) {
            $this->imagen = $this->imagen->store('storage');
        }
        $validatedData = $this->validate([
            'titulo' => 'required',
            'imagen' => 'required',
            'user_id' => 'required',
            'empresa_id' => 'required',
            'descripcion' => 'required'
        ]);


        $clasificados = Clasificados::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {

        $this->consultaVer = Clasificados::find($id);
        $this->titulo = $this->consultaVer->titulo;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->imagen = $this->consultaVer->imagen;
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
        Clasificados::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->consultaVer = Clasificados::find($id);
        $this->titulo = $this->consultaVer->titulo;
        $this->descripcion = $this->consultaVer->descripcion;
        //$this->imagen = $this->consultaVer->imagen;
        $this->editar = true;
        $this->imagen_data = $this->consultaVer->imagen;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'imagen' => 'nullable',
        ], [
            'titulo.required' => 'El titulo es obligatorio.',
            'descripcion.required' => 'La descripcion es obligatoria.',
            'imagen.required' => 'La imagen es obligatoria.',
        ]);

        if ($this->imagen) {
            $url_imagen = $this->imagen->store('storage', ['disk' => 'local']);
        } else {
            $url_imagen = $this->imagen_data;
        }

        $clasificados = Clasificados::find($id);

        if ($clasificados) {
            $clasificados->update([
                'titulo' => $this->titulo,
                'descripcion' => $this->descripcion,
                'imagen' => $url_imagen,
                'user_id' => $this->user_id,
            ]);

            $this->limpiarInput();
            $this->alert('success', 'Actualizado correctamente!', [
                'position' => 'top'
            ]);
        } else {
            $this->alert('error', 'titulo no encontrado!', [
                'position' => 'top'
            ]);
        }
    }

    public function limpiarInput()
    {
        $this->nuevo = false;
        $this->editar = false;
        $this->ver = false;

        $this->titulo = '';
        $this->descripcion = '';
        $this->imagen = '';
    }

}
