<?php

namespace App\Http\Livewire;

use App\Models\Roles;
use Livewire\Component;
use App\Models\Modulos;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class ShowRoles extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $nombre;
    public $descripcion;
    public $estado = 1;
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;
    public $modulos = [];
    public $modulosEditar;
    public $modulosVer;
    public $eliminarItem = ['1'];
    public $usuario_creador;
    public $usuario_actualizador;


    public $rol_super=0;
    public $rol_administrador =0;
    //public $selectedItems = [];
    public $buscarItem;
    public function render()
    {
        $buscar = $this->buscar;

        $consulta = Roles::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
            })
            ->where('empresa_id', 'exists', false)->paginate(20);

        $buscarItem = $this->buscarItem;
        $consultaModulos = Modulos::query()
            ->when(!empty($buscarItem), function ($query) use ($buscarItem) {
                return $query->where('nombre', 'LIKE', '%' . $buscarItem . '%');
            })
            ->get();
        //dd($consultaIconos);

        return view('livewire.show-roles', [
            'consulta' => $consulta,
            'consultaModulos' => $consultaModulos,
        ]);
    }

    //CREAR 
    public function guardar()
    {
        if((($this->rol_administrador != 0)||($this->rol_super != 0)||($this->rol_administrador == 1)&&($this->rol_super == 1))){
            $this->usuario_creador = Auth::user()->id;

            $validatedData = $this->validate([
                'nombre' => 'required',
                'descripcion' => 'required',
                'usuario_creador' => 'required',
                'rol_administrador' => 'required',
                'rol_super' => 'required'
            ]);
    
    
            $roles = Roles::create($validatedData);
            if ($this->modulos) {
    
                $ids = array();
                foreach ($this->modulos as $modulo) {
                    if (isset($modulo['_id'])) {
                        $ids[] = $modulo['_id'];
                    }
                }
    
                $roles->modulos()->attach($ids);
            }
    
            $this->alert('success', 'Creado correctamente!', [
                'position' => 'top'
            ]);
    
    
            $this->nuevo = false;
            $this->limpiarInput();
        }else{
            $this->alert('warning', 'Seleccione un tipo de rol!!', [
                'position' => 'top'
            ]);
        }
        //dd($this->rol_empr    esarial);
        
    }
    //VER
    public function ver($id)
    {
        $this->consultaVer = Roles::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->modulosVer = $this->consultaVer->modulos;
        $this->rol_administrador = $this->consultaVer->rol_administrador;
        $this->rol_super = $this->consultaVer->rol_super;


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
        Roles::whereIn('_id', $this->eliminarItem)->delete();

        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {

        $this->consultaVer = Roles::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->modulos = $this->consultaVer->modulos->toArray();
        $this->rol_administrador = $this->consultaVer->rol_administrador;
        $this->rol_super = $this->consultaVer->rol_super;
        //dd($this->modulos);
        $this->editar = true;

    }

    //ACTUALIZAR
    public function actualizar($id)
    {   
        if((($this->rol_administrador != 0)||($this->rol_super != 0)||($this->rol_administrador == 1)&&($this->rol_super == 1))){

        $this->usuario_actualizador = Auth::user()->id;
        $validatedData = $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'usuario_actualizador' => 'required',
            'rol_administrador' => 'required',
            'rol_super' => 'required'
        ]);

        $roles = Roles::find($id);
        $roles->update($validatedData);

        if (!is_null($this->modulos)) {

            $ids = array();
            foreach ($this->modulos as $modulo) {

                if (isset($modulo['_id'])) {
                    $ids[] = $modulo['_id'];
                }
            }


            $roles->modulos()->sync($ids);
        }


        $this->editar = false;
        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();
    }else{
        $this->alert('warning', 'Seleccione un tipo de rol!!', [
            'position' => 'top'
        ]);
    }

    }

    public function limpiarInput()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->modulos = [];


    }

    public function itemSelected($id, $text)
    {
        $this->selectedItems[$id] = $text;
    }

    public function itemUnselected($id)
    {
        unset($this->selectedItems[$id]);
    }

    public function store(Request $request)
    {
        $tags = explode(',', $request->input('tags'));

        // Procesar las etiquetas aquí

        return redirect()->back();
    }

    public function selectModulo($id)
    {
        $id = json_decode($id);
        $id = (array) $id;
        //dd($id);
        // Verificar si el elemento ya existe en selectedItems
        if (!in_array($id, $this->modulos)) {
            $this->modulos[] = $id;
        }

        //dd($this->modulos);
    }

    public function deleteModulo($id)
    {

        $this->modulos = array_filter($this->modulos, function ($item) use ($id) {

            return $item['_id'] !== $id;
        });
    }


}