<?php
namespace App\Http\Livewire;

use App\Models\Contacto;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowContacto extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Contacto';

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
    public $email;
    public $telefono;
    public $direccion;


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
        $consulta = Contacto::query()
        ->when(!empty($buscar), function ($query) use ($buscar) {
            return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
        })
        ->get();

        return view('livewire.show-contacto', [
            'consulta' => $consulta,
        ]);
    }

    //CREAR
    public function guardar()
    {

        $validatedData = $this->validate([
            'email' => 'required',
            'telefono' => 'required',
            'user_id' => 'required',
            'empresa_id' => 'required',
            'direccion' => 'required',
        ]);


        $roles = Contacto::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Contacto::find($id);
        $this->email = $this->consultaVer->email;
        $this->telefono = $this->consultaVer->telefono;
        $this->direccion = $this->consultaVer->direccion;
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
        Contacto::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->consultaVer = Contacto::find($id);
        $this->email = $this->consultaVer->email;
        $this->telefono = $this->consultaVer->telefono;
        $this->direccion = $this->consultaVer->direccion;
        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {

        $this->validate([
            'email' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
        ], [
            'email.required' => 'El email es obligatorio.',
            'telefono.required' => 'El telefono es obligatorio.',
            'direccion.required' => 'La direccion es obligatoria.',
        ]);

        $tarjetas = Contacto::find($id);

        if ($tarjetas) {
            $tarjetas->update([
                'email' => $this->email,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
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

        $this->email = '';
        $this->telefono = '';
        $this->direccion = '';
    }

}
