<?php
namespace App\Http\Livewire;

use App\Models\QuienesSomos;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowQuienes_somos extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Quienes_somos';

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
    public $descripcion;
    public $imagen;
    public $imagen_data;




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
        $consulta = QuienesSomos::query()
        ->when(!empty($buscar), function ($query) use ($buscar) {
            return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
        })
        ->get();

        return view('livewire.show-quienes_somos', [
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
            'nombre' => 'required',
            'imagen' => 'required',
            'user_id' => 'required',
            'empresa_id' => 'required',
            'descripcion' => 'required'
        ]);


        $roles = QuienesSomos::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = QuienesSomos::find($id);
        $this->nombre = $this->consultaVer->nombre;
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
        QuienesSomos::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->consultaVer = QuienesSomos::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->editar = true;
        $this->imagen_data = $this->consultaVer->imagen;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'imagen' => 'nullable',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripcion es obligatoria.',
            'imagen.required' => 'La imagen es obligatoria.',
        ]);

        if ($this->imagen) {
            $url_imagen = $this->imagen->store('storage', ['disk' => 'local']);
        } else {
            $url_imagen = $this->imagen_data;
        }

        $quienes_somos = QuienesSomos::find($id);

        if ($quienes_somos) {
            $quienes_somos->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'imagen' => $url_imagen,
                'user_id' => $this->user_id,
            ]);

            $this->limpiarInput();
            $this->alert('success', 'Actualizado correctamente!', [
                'position' => 'top'
            ]);
        } else {
            $this->alert('error', 'Slider no encontrado!', [
                'position' => 'top'
            ]);
        }
    }

    public function limpiarInput()
    {
        $this->nuevo = false;
        $this->editar = false;
        $this->ver = false;

        $this->nombre = '';
        $this->descripcion = '';
        $this->imagen = '';
    }

}
