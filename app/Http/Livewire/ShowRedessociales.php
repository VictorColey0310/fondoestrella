<?php
namespace App\Http\Livewire;

use App\Models\RedesSociales;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowRedessociales extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Redessociales';

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
    public $url;
    public $icono;
    public $codigo;


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
        $consulta = RedesSociales::query()
        ->when(!empty($buscar), function ($query) use ($buscar) {
            return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
        })
        ->get();

        return view('livewire.show-redessociales', [
            'consulta' => $consulta,
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->icono = $this->codigo;

        $validatedData = $this->validate([
            'nombre' => 'required',
            'icono' => 'required',
            'user_id' => 'required',
            'empresa_id' => 'required',
            'codigo' => 'required',
            'url' => 'required'
        ]);


        $roles = RedesSociales::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {

        $this->consultaVer = RedesSociales::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->url = $this->consultaVer->url;
        $this->icono = $this->consultaVer->icono;
        $this->codigo = $this->consultaVer->codigo;
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
        RedesSociales::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->consultaVer = RedesSociales::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->url = $this->consultaVer->url;
        $this->codigo = $this->consultaVer->codigo;
        $this->icono = $this->consultaVer->icono;
        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->icono = $this->codigo;

        $this->validate([
            'nombre' => 'required',
            'url' => 'required',
            'codigo' => 'required',
            'icono' => 'required',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'url.required' => 'La url es obligatoria.',
            'codigo.required' => 'El codigo es obligatorio.',
            'icono.required' => 'El icono es obligatorio.',
        ]);

        $redes_sociales = RedesSociales::find($id);

        if ($redes_sociales) {
            $redes_sociales->update([
                'nombre' => $this->nombre,
                'url' => $this->url,
                'codigo' => $this->codigo,
                'icono' => $this->icono,
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
        $this->ver = false;
        $this->editar = false;
        $this->nuevo = false;

        $this->nombre = '';
        $this->url = '';
        $this->codigo = '';
        $this->icono = '';
    }

}
