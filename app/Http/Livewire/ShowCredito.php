<?php
namespace App\Http\Livewire;

use App\Models\Credito;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowCredito extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Credito';

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
    public  $monto;
    public $plazo_maximo;
    public $tasa_interes;
    public  $tasa_preferencial;
    public $novacion;
    public $requisitos;
    public  $imagen;
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
        $consulta = Credito::query()
        ->when(!empty($buscar), function ($query) use ($buscar) {
            return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
        })
        ->get();

        return view('livewire.show-credito', [
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
            'monto' => 'required',
            'plazo_maximo' => 'required',
            'tasa_interes' => 'required',
            'tasa_preferencial' => 'required',
            'novacion' => 'required',
            'requisitos' => 'required',
            'imagen' => 'required',
            'user_id' => 'required',
            'empresa_id' => 'required',
        ]);

        $credito = Credito::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Credito::find($id);
        $this->titulo = $this->consultaVer->titulo;
        $this->monto = $this->consultaVer->monto;
        $this->plazo_maximo = $this->consultaVer->plazo_maximo;
        $this->tasa_interes = $this->consultaVer->tasa_interes;
        $this->tasa_preferencial = $this->consultaVer->tasa_preferencial;
        $this->novacion = $this->consultaVer->novacion;
        $this->requisitos = $this->consultaVer->requisitos;
        $this->tasa_interes = $this->consultaVer->tasa_interes;
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
        Credito::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->consultaVer = Credito::find($id);
        $this->titulo = $this->consultaVer->titulo;
        $this->monto = $this->consultaVer->monto;
        $this->plazo_maximo = $this->consultaVer->plazo_maximo;
        $this->tasa_interes = $this->consultaVer->tasa_interes;
        $this->tasa_preferencial = $this->consultaVer->tasa_preferencial;
        $this->novacion = $this->consultaVer->novacion;
        $this->requisitos = $this->consultaVer->requisitos;
        $this->tasa_interes = $this->consultaVer->tasa_interes;
        $this->editar = true;
        $this->imagen_data = $this->consultaVer->imagen;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'titulo' => 'required',
            'monto' => 'required',
            'plazo_maximo' => 'required',
            'tasa_interes' => 'required',
            'tasa_preferencial' => 'required',
            'novacion' => 'required',
            'requisitos' => 'required',
            'imagen' => 'nullable',
        ], [
            'titulo.required' => 'El titulo es obligatorio.',
            'monto.required' => 'El monto es obligatorio.',
            'plazo_maximo.required' => 'El plazo maximo es obligatorio.',
            'tasa_interes.required' => 'La tasa de interes es obligatoria.',
            'tasa_preferencial.required' => 'La tasa preferencial es obligatoria.',
            'novacion.required' => 'La novación es obligatoria.',
            'requisitos.required' => 'Los requisitos es obligatorio.',
            'imagen.required' => 'La imagen es obligatoria.',
        ]);

        if ($this->imagen) {
            $url_imagen = $this->imagen->store('storage', ['disk' => 'local']);
        } else {
            $url_imagen = $this->imagen_data;
        }

        $creditos = Credito::find($id);

        if ($creditos) {
            $creditos->update([
                'titulo' => $this->titulo,
                'monto' => $this->monto,
                'plazo_maximo' =>$this->plazo_maximo,
                'tasa_interes' => $this->tasa_interes,
                'tasa_preferencial' =>$this->tasa_preferencial,
                'novacion' => $this->novacion,
                'requisitos' =>$this->requisitos,
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
        $this->ver = false;
        $this->editar = false;
        $this->nuevo = false;

        $this->titulo = '';
        $this->monto = '';
        $this->plazo_maximo = '';
        $this->tasa_interes ='';
        $this->tasa_preferencial = '';
        $this->novacion = '';
        $this->requisitos = '';
        $this->tasa_interes = '';
        $this->imagen='';
    }

}
