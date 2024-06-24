<?php

namespace App\Http\Livewire;

use App\Models\Ciudades;
use App\Models\Empresas;
use App\Models\Roles;
use App\Models\Submodulos;
use App\Models\subRoles;
use Livewire\Component;
use App\Models\Modulos;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class ShowSubroles extends Component
{
    use LivewireAlert;
    use WithPagination;

    // MODALES
    public $nuevo = false;
    public $editar = false;
    public $ver = false;

    // FILTROS
    public $buscar;
    public $user_id;

    // DATOS
    public $nombre;
    public $descripcion;
    public $estado = 1;
    public $consultaVer;
    public $modulos = [];
    public $modulosEditar;
    public $modulosVer;
    public $eliminarItem = ['1'];
    //public $selectedItems = [];
    public $buscarItem;
    public $empresa_id;
    public $nombre_empresa;

    protected $listeners = ['mensajeEnviado'];

    public function mensajeEnviado($empresa_id)
    {
        $this->empresa_id = $empresa_id;
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

        $consulta = Roles::where('empresa_id', $this->empresa_id)
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
            })
            ->paginate(20);

        $buscarItem = $this->buscarItem;
        $consultaModulos = Submodulos::query()
            ->when(!empty($buscarItem), function ($query) use ($buscarItem) {
                return $query->where('nombre', 'LIKE', '%' . $buscarItem . '%');
            })
            ->get();
        //dd($consultaIconos);
        $this->nombre_empresa = Empresas::find($this->empresa_id)->nombre;
        return view('livewire.show-subroles', [
            'consulta' => $consulta,
            'consultaModulos' => $consultaModulos,
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
        ]);

        $rol = Roles::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'user_id' => $this->user_id,
            'empresa_id' => $this->empresa_id
        ]);

        if ($this->modulos) {
            $ids = array();
            foreach ($this->modulos as $modulo) {
                if (isset($modulo['_id'])) {
                    $ids[] = $modulo['_id'];
                }
            }
            $rol->submodulos()->attach($ids);
        }

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);


        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Roles::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->modulosVer = $this->consultaVer->submodulos;
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
        $this->modulos = $this->consultaVer->submodulos->toArray();
        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
        ]);

        $rol = Roles::find($id);

        if ($rol) {
            $rol->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'user_id' => $this->user_id,
            ]);

            if (!is_null($this->modulos)) {
                $ids = array();
                foreach ($this->modulos as $modulo) {
                    if (isset($modulo['_id'])) {
                        $ids[] = $modulo['_id'];
                    }
                }
                $rol->submodulos()->sync($ids);
            }

            $this->limpiarInput();
            $this->alert('success', 'Actualizado correctamente!', [
                'position' => 'top'
            ]);
        } else {
            $this->alert('error', 'Rol no encontrado!', [
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
