<?php

namespace App\Http\Livewire;

use App\Models\Iconos;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;


class ShowIconos extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $nombre;
    public $icono;
    public $codigo;
   // public $estado = 1;
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;

    public $eliminarItem = ['1'];
    public function render()
    {
        $buscar = $this->buscar;

        $consulta = Iconos::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
            })
            ->paginate(20);

        return view('livewire.show-iconos', [
            'consulta' => $consulta
        ]);
    }

        //CREAR
        public function guardar()
        {
            $this->icono = $this->codigo;

            $validatedData = $this->validate([
                'nombre' => 'required',
                'icono' => 'required',
                'codigo' => 'required',
            ]);

            Iconos::create($validatedData);

            $this->alert('success', 'Creado correctamente!', [
                'position' => 'top'
            ]);
            $this->nuevo = false;
            $this->limpiarInput();
        }

        //VER
        public function ver($id)
        {
            $this->consultaVer = Iconos::find($id);
            $this->nombre = $this->consultaVer->nombre;
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

        public function getListeners()
        {
            return [
                'confirmed'
            ];
        }

        public function confirmed()
        {
            Iconos::whereIn('_id', $this->eliminarItem)->delete();

            $this->alert('success', 'Eliminado correctamente!', [
                'position' => 'top'
            ]);
            $this->eliminarItem=['1'];
        }

        //VER EDITAR
        public function editar($id)
        {

            $this->consultaVer = Iconos::find($id);
            $this->nombre = $this->consultaVer->nombre;
            $this->icono = $this->consultaVer->icono;
            $this->codigo = $this->consultaVer->codigo;

            $this->editar = true;

        }

        //ACTUALIZAR
        public function actualizar($id)
        {
            $this->icono = $this->codigo;
            $validatedData = $this->validate([
                'nombre' => 'required',
                'icono' => 'required',
                'codigo' => 'required',

            ]);

            Iconos::find($id)->update($validatedData);


            $this->editar = false;
            $this->alert('success', 'Actualizado correctamente!', [
                'position' => 'top'
            ]);

            $this->limpiarInput();

        }

        public function limpiarInput(){
            $this->nombre= '';
            $this->icono='';
            $this->codigo='';


        }
}
