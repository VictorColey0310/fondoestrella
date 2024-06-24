<?php
namespace App\Http\Livewire;
use App\Models\Criterio;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowGrupos extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;

    public $nombreCrud = 'Grupos';

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

    public $buscarItem;
    public $criterios = [];
    public $criterio_ids;


    public function selectCriterio($id)
    {
        $id = json_decode($id);
        $id = (array) $id;

        if (!in_array($id, $this->criterios)) {
            $this->criterios[] = $id;
        }
    }

    public function deleteCriterio($id)
    {
        $this->criterios = array_filter($this->criterios, function ($item) use ($id) {

            return $item['_id'] !== $id;
        });
    }

    public function limpiarCriterios()
    {
        $this->criterios = [];
    }

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
        $buscarItem = $this->buscarItem;

        $consultaGrupo = Grupo::where(function ($query) use ($buscar) {
            if ($buscar != null) {
                $query->where('nombre', 'like', '%' . $buscar . '%');
            }
        })->paginate(20);

        $consultaCriterio = Criterio::query()
            ->when(!empty($buscarItem), function ($query) use ($buscarItem) {
                return $query->where('nombre', 'LIKE', '%' . $buscarItem . '%');
            })
            ->whereNull('grupo_id')
            ->get();

        return view('livewire.show-grupos',[
            'consultaGrupo' => $consultaGrupo,
            'consultaCriterio' => $consultaCriterio,
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'nombre' => 'required',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
        ]);

        if (!is_null($this->criterios)) {
            $criterios_ids = [];

            foreach ($this->criterios as $criterio) {
                if (isset($criterio['_id'])) {
                    $criterios_ids[] = $criterio['_id'];
                }
            }

            $grupo = Grupo::create([
                'nombre' => $this->nombre,
                'user_id' => $this->user_id,
                'criterio_ids' => $criterios_ids,
            ]);

            Criterio::whereIn('_id', $criterios_ids)->update(['grupo_id' => $grupo->id]);
        } else {
            $grupo = Grupo::create([
                'nombre' => $this->nombre,
                'user_id' => $this->user_id,
            ]);
        }
        $this->limpiarInput();

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Grupo::find($id);

        $this->nombre = $this->consultaVer->nombre;
        $this->criterio_ids = $this->consultaVer->criterio_ids;

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
        Grupo::whereIn('_id', $this->eliminarItem)->delete();
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->ver = false;

        $this->consultaVer = Grupo::find($id);
        $this->nombre = $this->consultaVer->nombre;

        if (!is_null($this->consultaVer->criterio_ids)) {
            $this->criterios = Criterio::whereIn('_id', $this->consultaVer->criterio_ids)->get()->toArray();
        }

        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->validate([
            'nombre' => 'required',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
        ]);

        $grupo = Grupo::find($id);

        $criteriosOld = $grupo->criterio_ids;

        if (!$grupo) {
            $this->alert('error', 'El grupo no existe!', [
                'position' => 'top'
            ]);

            return;
        }

        if (!is_null($this->criterios)) {
            $criterios_ids = [];

            foreach ($this->criterios as $criterio) {
                if (isset($criterio['_id'])) {
                    $criterios_ids[] = $criterio['_id'];
                }
            }

            $grupo->update([
                'nombre' => $this->nombre,
                'criterio_ids' => $criterios_ids,
                'user_id' => $this->user_id,
            ]);

            if (is_null($criteriosOld) || count($criteriosOld) == 0 || $criteriosOld != $criterios_ids) {
                Criterio::whereIn('_id', $criterios_ids)->update(['grupo_id' => $grupo->id]);
                Criterio::whereNotIn('_id', $criterios_ids)->where('grupo_id', $grupo->id)->update(['grupo_id' => null]);
            }
        } else {
            $grupo->update([
                'nombre' => $this->nombre,
                'user_id' => $this->user_id,
            ]);

            if (!is_null($criteriosOld) && count($criteriosOld) > 0) {
                Criterio::where('grupo_id', $grupo->id)->update(['grupo_id' => null]);
            }
        }

        $this->limpiarInput();

        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);
    }


    public function limpiarInput()
    {
        $this->ver = false;
        $this->editar = false;
        $this->nuevo = false;

        $this->nombre = null;
        $this->criterios = [];
    }

}
