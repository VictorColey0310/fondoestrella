<?php
namespace App\Http\Livewire;

use App\Imports\UsersImport;
use App\Models\Cargos;
use App\Models\Empresas;
use App\Models\Informacion;
use App\Models\Planes;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;


class ShowImportarusuarios extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Importarusuarios';
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $buscar;
    public $user_id;
    public $empresa_id;
    public $importado;
    public $eliminarItem = ['1'];
    public $file;
    public $muestras;
    public $importados;
    public $noimportados;
    public $modalImportacion = false;
    public $rolTrabajador;
    public $modelo;



    public function mensajeEnviado($empresa_id)
    {
        $this->empresa_id = $empresa_id->id;
    }
    public function render()
    {
       
        if (empty($this->empresa_id)) {
            $this->empresa_id = config('app.empresa')->id;
        }

        $this->modelo = Informacion::first()->modelo;

        $this->rolTrabajador = Roles::where('empresa_id',$this->empresa_id)->where('nombre','Trabajador')->exists();
        

        $user = Auth::user();
        $this->user_id = $user->id;
        $buscar = $this->buscar;

        if (!empty($this->file)) {
            $this->muestras = Excel::toCollection(new UsersImport, $this->file)->take(50);

        }

        return view('livewire.show-importarusuarios');
    }

    public function import()
    {

        //$data=Excel::import(new UsersImport, $this->file);
        $collection = Excel::toCollection(new UsersImport, $this->file);
        // Itera sobre la colección de filas y guarda cada usuario en MongoDB
        $this->importados = 0;
        $this->noimportados =0;
        foreach ($collection[0] as $row) {

            $usuario = User::where('documento', $row[1])->first();
            //dd($usuario);
            if (empty($usuario)) {
                $this->importados++;
                $cargo = Cargos::where('nombre', $row[6])->where('empresa_id', $this->empresa_id)->first();
                if (empty($cargo)) {
                    $cargo = Cargos::create(['nombre' => $row[6], 'empresa_id' => $this->empresa_id]);
                    $cargo_id = $cargo->id;
                } else {
                    $cargo_id = $cargo->id;
                }

                $plan = Planes::where('nombre', $row[8])->where('empresa_id', $this->empresa_id)->first();
                if (empty($plan)) {
                    $plan = Planes::create(['nombre' => $row[8], 'empresa_id' => $this->empresa_id]);
                    $plan_id[] = $plan->id;
                } else {
                    $plan_id[] = $plan->id;
                }

                $rol = Roles::where('nombre', 'Trabajador')->where('empresa_id', $this->empresa_id)->first();

                $user = User::create([
                    'codigo_interno' => $row[0] ?? '',
                    'documento' => $row[1] ?? '',
                    'name' => $row[2] ?? '',
                    'segundo_name' => $row[3] ?? '',
                    'primer_apellido' => $row[4] ?? '',
                    'segundo_apellido' => $row[5] ?? '',
                    'cargoAspira_id' => $cargo_id ?? '',
                    'email' => $row[7] ?? '',
                    //'plan_id' => $plan_id ?? '',
                    'rol_id' => $rol->id ?? '',
                    'password' => Hash::make($row[1]) ?? '',
                    'estado' =>  1,
                    // Aquí usamos bcrypt para hashear la contraseña
                ]);
                $ids[] = $this->empresa_id;
                $user->empresas()->sync($ids);
                $user->planes()->sync($plan_id);
                $plan_id= [];
            }else{
                $this->noimportados++;
            }

        }

        $this->file = null;
        $this->importado = 'true';
        $this->modalImportacion = true;

        //dd($array);

        // aquí se puede procesar los datos obtenidos
    }


}