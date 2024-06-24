<?php
namespace App\Http\Livewire;

use App\Models\Convenios;
use App\Models\GrupoConvenios;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowConvenios extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Convenios';

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
    public $imagen;
    public $imagen_data;
    public $url;
    public $nombre;
    public $descripcion;
    public $grupo_id;


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
        $consulta = Convenios::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
            })
            ->get();
        $consulta_grupo = GrupoConvenios::get();

        return view('livewire.show-convenios', [
            'consulta' => $consulta,
            'consulta_grupo' => $consulta_grupo,
        ]);
    }

    //CREAR
    public function guardar()
    {
        if ($this->imagen) {
            $this->imagen = $this->imagen->store('storage');
        }

        $validatedData = $this->validate([
            'grupo_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'imagen' => 'required',
            'user_id' => 'required',
            'empresa_id' => 'required',
            'url' => 'required',
        ]);

        $convenios = Convenios::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {

        $this->consultaVer = Convenios::find($id);
        $this->grupo_id = $this->consultaVer->grupo_convenios->titulo;
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->url = $this->consultaVer->url;
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
        Convenios::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->consultaVer = Convenios::find($id);
        $this->grupo_id = $this->consultaVer->grupo_id;
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->url = $this->consultaVer->url;
        $this->editar = true;
        $this->imagen_data = $this->consultaVer->imagen;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'grupo_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'url' => 'required',
            'imagen' => 'nullable',

        ], [
            'grupo_id.required' => 'El grupo es obligatorio',
            'nombre.required' => 'El nombre es obligatorio',
            'descripcion.required' => 'La descripción es obligatoria',
            'url.required' => 'La URL es obligatoria.',
            'imagen.required' => 'La imagen es obligatoria.',
        ]);

        $convenios = Convenios::find($id);

        if (!$convenios) {
            $this->alert('error', 'Título no encontrado!', ['position' => 'top']);
            return;
        }

        if ($this->imagen) {
            $url_imagen = $this->imagen->store('storage', ['disk' => 'local']);
        } else {
            $url_imagen = $this->imagen_data;
        }

        $convenios->update([
            'grupo_id' => $this->grupo_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'url' => $this->url,
            'imagen' => $url_imagen,
            'user_id' => $this->user_id,
        ]);

        $this->limpiarInput();
        $this->alert('success', '¡Actualizado correctamente!', ['position' => 'top']);
    }

    public function limpiarInput()
    {
        $this->nuevo = false;
        $this->editar = false;
        $this->ver = false;

        $this->grupo_id = '';
        $this->nombre = '';
        $this->descripcion = '';
        $this->url = '';
        $this->imagen = '';
    }

}
