<?php

namespace App\Http\Livewire;

use App\Models\Categorias;
use App\Models\CIIU;
use App\Models\Ciudades;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ShowPerfilempresa extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;

    public $nombreCrud = 'Perfilempresa';
    public $consulta;
    public $ciiu = [];
    public $logo;
    public $logo_upload;
    public $nit;
    public $nombre;
    public $descripcion;
    public $categoria_id;
    public $direccion;
    public $ciudad_id;
    public $numero_trabajadores;
    public $color;
    public $riesgo;
    public $consultaFiltro;
    public $usuario_actualizador;

    public function mount()
    {
        $this->consulta = config('app.empresa');

        $this->nit = $this->consulta->nit;
        $this->nombre = $this->consulta->nombre;
        $this->descripcion = $this->consulta->descripcion;
        $this->ciiu = $this->consulta->ciiu;
        $this->ciudad_id = $this->consulta->ciudad_id;
        $this->direccion = $this->consulta->direccion;
        $this->categoria_id = $this->consulta->categoria_id;
        $this->numero_trabajadores = $this->consulta->numero_trabajadores;
        $this->riesgo = $this->consulta->riesgo;
        $this->color = $this->consulta->color;
        $this->logo = $this->consulta->logo;
    }

    public function render()
    {
        $consultaCategorias = Categorias::get();
        $consultaCiudades = Ciudades::where('estado', 1)->get();
        $consultaCiiu = CIIU::get();

        $this->consultaFiltro = $consultaCategorias;
        if (empty($this->riesgo) && !empty($this->ciiu)) {
            $this->riesgo = CIIU::whereIn('codigo', $this->ciiu)
                ->orderBy('riesgo', 'desc')
                ->value('riesgo');
        }

        return view('livewire.show-perfilempresa', [
            'consultaCiudades' => $consultaCiudades,
            'consultaCategorias' => $consultaCategorias,
            'consultaCiiu' => $consultaCiiu,
        ]);
    }

    public function actualizar()
    {
        if ($this->logo_upload) {
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

        $this->consulta->update($validatedData);

        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);
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
