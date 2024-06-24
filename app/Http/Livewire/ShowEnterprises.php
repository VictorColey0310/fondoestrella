<?php
namespace App\Http\Livewire;

use App\Models\Caracterizacion;
use App\Models\Caracterizacion_empresa;
use App\Models\CIIU;
use App\Models\Ciudades;
use App\Models\Empresas;
use App\Models\Categorias;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class ShowEnterprises extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;
 

    public $logo;
    public $nombre;
    public $descripcion;
    public $estado = 1;
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;
    public $ciudad_id;
    public $nit;
    public $direccion;
    public $ciiu = [];
    public $eliminarItem = ['1'];
    public $usuario_creador;
    public $usuario_actualizador;
    public $categoria_id;
    public $consultaFiltro;
    public $filtro;
    public $riesgo;
    public $numero_trabajadores;
    public $color;
    public $logo_upload;

    public function render()
    {
        $buscar = $this->buscar;
        $filtro = $this->filtro;

        $consulta = Empresas::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%')->orWhere('nit', 'LIKE', '%' . $buscar . '%');
            })
            ->when(!empty($filtro), function ($query) use ($filtro) {
                return $query->where('categoria_id', 'LIKE', '%' . $filtro . '%');
            })
            ->paginate(20);
        $consultaCiudades = Ciudades::where('estado', 1)->get();
        $consultaCategorias = Categorias::get();
        $this->consultaFiltro = $consultaCategorias;
        $consultaCiiu = CIIU::get();

        if (empty($this->riesgo) && !empty($this->ciiu)) {
            $this->riesgo = CIIU::whereIn('codigo', $this->ciiu)
                ->orderBy('riesgo', 'desc')
                ->value('riesgo');
        }
        $empresa = Empresas::first();
        return view('livewire.show-enterprises', [
            'consulta' => $consulta,
            'consultaCiudades' => $consultaCiudades,
            'consultaCategorias' => $consultaCategorias,
            'consultaCiiu' => $consultaCiiu,
        ]);
    }

    //CREAR 
    public function guardar()
    {
        if($this->logo_upload){
            $this->logo = $this->logo_upload->store('storage');
        }
        
        $this->validar_nit($this->nit);
        //dd($this->validar_nit($this->nit));

        $this->usuario_creador = Auth::user()->id;
        $validatedData = $this->validate([

            'nit' => [
                'required',
                function ($attribute, $value, $fail) {
                    $nitValido = $this->validar_nit($value);
                    if (!$nitValido) {
                        $fail($attribute . ' no es válido.');
                    }
                }
            ],
            'nombre' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
            'usuario_creador' => 'required',
            'ciiu' => 'required',
            'ciudad_id' => 'required',
            'direccion' => 'required',
            'categoria_id' => 'required',
            'numero_trabajadores' => 'required',
            'riesgo' => 'required',
            'color' => 'required',
            'logo' => 'required'
        ]);

        $empresa = Empresas::create($validatedData);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
        $this->nuevo = false;
        //$this->caracterizacion($empresa);
        $this->limpiarInput();
    }

    //CAMBIAR ESTADO 
    public function cambiarEstado($id, $estado)
    {
        $estado = $estado ? 0 : 1;

        $actualizar = Empresas::find($id)->update(['estado' => $estado]);

        if ($actualizar && $estado == 1) {
            $this->alert('success', 'Activo!', [
                'position' => 'top'
            ]);
        }
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Empresas::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->estado = $this->consultaVer->estado == 1 ? 'Activo' : 'Inactivo';
        $this->ciiu = $this->consultaVer->ciiu;
        $this->ciudad_id = $this->consultaVer->ciudad->municipio . ' - ' . $this->consultaVer->ciudad->departamento;
        $this->direccion = $this->consultaVer->direccion;
        $this->nit = $this->consultaVer->nit;
        $this->categoria_id = $this->consultaVer->categoria->nombre;
        $this->numero_trabajadores = $this->consultaVer->numero_trabajadores;
        $this->riesgo = $this->consultaVer->riesgo;
        $this->logo = $this->consultaVer->logo;
        $this->color = $this->consultaVer->color;
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
        Empresas::whereIn('_id', $this->eliminarItem)->delete();

        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->consultaVer = Empresas::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->estado = $this->consultaVer->estado;
        $this->ciiu = $this->consultaVer->ciiu;
        $this->ciudad_id = $this->consultaVer->ciudad_id;
        $this->direccion = $this->consultaVer->direccion;
        $this->nit = $this->consultaVer->nit;
        $this->categoria_id = $this->consultaVer->categoria_id;
        $this->numero_trabajadores = $this->consultaVer->numero_trabajadores;
        $this->color = $this->consultaVer->color;
        $this->logo = $this->consultaVer->logo;
        $this->editar = true;

    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        if($this->logo_upload){
            $this->logo = $this->logo_upload->store('storage');
        }
        
        $this->validar_nit($this->nit);

        $this->usuario_actualizador = Auth::user()->id;
        $validatedData = $this->validate([
            'nit' => [
                'required',
                function ($attribute, $value, $fail) {
                    $nitValido = $this->validar_nit($value);
                    if (!$nitValido) {
                        $fail($attribute . ' no es válido.');
                    }
                }
            ],
            'nombre' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
            'usuario_actualizador' => 'required',
            'ciiu' => 'required',
            'ciudad_id' => 'required',
            'direccion' => 'required',
            'categoria_id' => 'required',
            'numero_trabajadores' => 'required',
            'riesgo' => 'required',
            'color' => 'required',
            'logo' => 'required'
        ]);

        //dd($validatedData);
        Empresas::find($id)->update($validatedData);

        $this->editar = false;
        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();

    }

    public function limpiarInput()
    {
        $this->nombre = '';
        $this->descripcion = '';
        $this->estado = 1;
        $this->ciudad_id = '';
        $this->nit = '';
        $this->direccion = '';
        $this->ciiu = [];
        $this->categoria_id = '';
        $this->riesgo = '';
        $this->numero_trabajadores = '';
        $this->logo = '';

    }

    public function selectCiiu($ciiu)
    {
        $this->ciiu[] = $ciiu;
        $this->riesgo = '';
    }

    public function deleteCiiu($ciiu)
    {
        $key = array_search($ciiu, $this->ciiu);
        if ($key !== false) {
            unset($this->ciiu[$key]);
        }
        $this->riesgo = '';
    }

    public function validar_nit($nit)
    {
        $nit = str_replace([' ', '-', '.'], '', $nit); // Eliminar espacios, guiones y puntos

        // Verificar longitud del NIT
        if (strlen($nit) !== 10) {
            return false;
        }

        // Obtener dígito de verificación
        $digitoVerificacion = intval($nit[9]);

        // Verificar que los primeros 9 caracteres sean dígitos
        if (!ctype_digit(substr($nit, 0, 9))) {
            return false;
        }



        if (!is_numeric($nit)) {
            return false;
        }

        $nit = substr($nit, 0, 9);

        $arr = array(
            1 => 3,
            4 => 17,
            7 => 29,
            10 => 43,
            13 => 59,
            2 => 7,
            5 => 19,
            8 => 37,
            11 => 47,
            14 => 67,
            3 => 13,
            6 => 23,
            9 => 41,
            12 => 53,
            15 => 71
        );
        $x = 0;
        $y = 0;
        $z = strlen($nit);
        $dv = '';

        for ($i = 0; $i < $z; $i++) {
            $y = substr($nit, $i, 1);
            $x += ($y * $arr[$z - $i]);
        }

        $y = $x % 11;

        if ($y > 1) {
            $dv = 11 - $y;

        } else {
            $dv = $y;

        }

        return $dv == $digitoVerificacion;

    }







}