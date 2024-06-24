<?php

namespace App\Http\Livewire;

use App\Models\Ciudades;
use Livewire\Component;
use App\Models\Modulos;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ShowCiudades extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $region;
    public $municipio;
    public $departamento;
    public $codigo_dane_municipio;
    public $estado = 1;
    public $nuevo = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;

    public $eliminarItem = ['1'];
  
    public function render()
    {   $buscar = $this->buscar;

        $consulta = Ciudades::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('municipio', 'LIKE', '%' . $buscar . '%')->orWhere('departamento', 'LIKE', '%' . $buscar . '%');
            })
            ->limit(10)->get();
       
        return view('livewire.show-ciudades', [
            'consulta' => $consulta,

        ]);
    }
    
    //CREAR 
    public function guardar()
    {
        $response = Http::get('https://www.datos.gov.co/resource/xdk5-pm3f.json');
        
        if ($response->successful()) {
            $data = $response->json();
    
            $nuevosRegistros = 0;
    
            foreach ($data as $item) {
                $codigoDaneMunicipio = $item['c_digo_dane_del_municipio'];
    
                // Verificar si el registro ya existe en la tabla Ciudades
                $existente = Ciudades::where('codigo_dane_municipio', $codigoDaneMunicipio)->first();
    
                if (!$existente) {
                    Ciudades::create([
                        'region' => $item['region'],
                        'codigo_dane_departamento' => $item['c_digo_dane_del_departamento'],
                        'departamento' => $item['departamento'],
                        'codigo_dane_municipio' => $codigoDaneMunicipio,
                        'municipio' => $item['municipio'],
                        'estado' => 0 // Asegúrate de tener el valor correcto para el estado
                    ]);
    
                    $nuevosRegistros++;
                }
            }
    
            $this->alert('success', $nuevosRegistros . ' registros nuevos ingresados!', [
                'position' => 'top'
            ]);
        } else {
            $this->alert('warning', 'Error al consultar la API!', [
                'position' => 'top'
            ]);
        }
    
        $this->nuevo = false;
    }
    

    //CAMBIAR ESTADO 
    public function cambiarEstado($id, $estado)
    {
        $estado = $estado ? 0 : 1;

        $actualizar = Ciudades::find($id)->update(['estado' => $estado]);
        
        if ($actualizar && $estado == 1) {
            $this->alert('success', 'Activo!', [
                'position' => 'top'
            ]);
        }
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Ciudades::find($id);
        $this->region = $this->consultaVer->region;
        $this->codigo_dane_municipio = $this->consultaVer->codigo_dane_municipio;
        $this->departamento = $this->consultaVer->departamento;
        $this->municipio = $this->consultaVer->municipio;
        $this->estado = $this->consultaVer->estado == 1 ? 'Activo' : 'Inactivo';

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
        Ciudades::whereIn('_id', $this->eliminarItem)->delete();
        
        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem=['1'];
    }



  

}
