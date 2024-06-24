<?php

namespace App\Http\Livewire;

use App\Models\Empresas;
use App\Models\Planes;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Models\Log;
use App\Models\Logtraslados;

class ShowTrasladarusuarios extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;
    public $nombreCrud = 'Trasladarusuarios';
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $buscar;
    public $user_id;
    public $eliminarItem = [];
    public $consultaEmpresas;
    public $consultaPlanes;
    public $empresa_id;
    public $filtro_empresa_id;
    public $filtro_plan_id;
    public $consulta;
    public $rolTrabajadorId;
    public $checkAll = false;
    public $trasladar = false;
    public $trasladar_empresa_id;
    public $trasladar_plan_id;
    public $consultaPlanes1;
    public $trabajador_id;
    public function getListeners()
    {
        return [
            'confirmed',
            'mensajeEnviado'
        ];
    }
    public function mensajeEnviado($empresa_id)
    {
        $this->empresa_id = $empresa_id->id;
    }
    public function mount()
    {
        $this->rolTrabajadorId = Roles::where('nombre', 'Trabajador')->value('id');
        $this->consultaEmpresas = Auth::user()->empresas;
        // $this->trasladar_empresa_id = Empresas::first()->id;
        $this->filtro_empresa_id = Auth::user()->empresas->first()->id;


        if (empty($this->empresa_id)) {
            $this->empresa_id = config('app.empresa');
        }



        $consultaSuper = Auth::user()->rol->rol_administrador;
        if ($consultaSuper) {
            $this->consultaPlanes = Planes::where('empresa_id', $this->empresa_id->id)->orderBy('nombre', 'asc')->get();
            $this->filtro_plan_id = Planes::where('empresa_id', $this->empresa_id->id)->first()->id ?? '';
        } else {
            $this->filtro_plan_id = Auth::user()->planes->first()->id ?? '';
            $this->consultaPlanes = Auth::user()->planes; // Reemplaza 'nombre' con el nombre del atributo que deseas usar para ordenar los planes.

        }
    }
    public function render()
    {
        if (empty($this->empresa_id)) {
            $this->empresa_id = config('app.empresa')->id;
        }
        if (!empty($this->filtro_empresa_id)) {
            $this->consultaPlanes = Planes::where('empresa_id', $this->filtro_empresa_id)->orderBy('nombre', 'asc')->get();
        }

        if (!empty($this->trasladar_empresa_id)) {
            //dd($this->trasladar_empresa_id);
            $this->consultaPlanes1 = Planes::where('empresa_id', $this->trasladar_empresa_id)->orderBy('nombre', 'asc')->get();
        }

        $user = Auth::user();
        $this->user_id = $user->id;
        $buscar = $this->buscar;

        //$this->trabajador_id= Roles::where('nombre','Trabajador')->value('_id');

        $this->consulta = Planes::where('_id', $this->filtro_plan_id)->with([
            'usuarios' => function ($query) use ($buscar) {
                if (!empty($buscar)) {
                    $query->where(function ($query) use ($buscar) {
                        $query->where('name', 'LIKE', '%' . $buscar . '%')
                            ->orWhere('segundo_name', 'LIKE', '%' . $buscar . '%')
                            ->orWhere('primer_apellido', 'LIKE', '%' . $buscar . '%')
                            ->orWhere('segundo_apellido', 'LIKE', '%' . $buscar . '%');
                    });
                }
                $query->orderBy('primer_apellido', 'asc');
            }
        ])->first()->usuarios ?? '';



        //$this->consulta = $this->consulta->where('rol_id', $this->rolTrabajadorId)->get();

        return view('livewire.show-trasladarusuarios', [
            'consulta' => $this->consulta,
            'consultaEmpresas' => $this->consultaEmpresas,
            'consultaPlanes' => $this->consultaPlanes,
        ]);
    }

    public function toggleCheckAll()
    {
        if ($this->checkAll) {
            $this->eliminarItem = collect($this->consulta)->pluck('id')->toArray();
        } else {
            $this->eliminarItem = [];
        }
    }

    //CREAR 
    public function guardar()
    {
        $validatedData = $this->validate([
            'empresa_id' => ['required'],
            'user_id' => ['required'],
        ]);

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->nuevo = false;
        $this->limpiarInput();
    }

    //VER
    public function ver($id)
    {

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

        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $validatedData = $this->validate([]);

        $this->editar = false;

        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();
    }

    public function trasladarUsers()
    {
        foreach ($this->eliminarItem as $item) {
            $user =  User::find($item);

            if (empty($this->trasladar_empresa_id) && empty($this->trasladar_plan_id)) {

                $this->alert('error', 'Para trasladar usuarios debes elegir una empresa o un plan!', [
                    'position' => 'top'
                ]);

                return;
            } else {

                if (!empty($this->trasladar_empresa_id)) {

                    $logTraslado = new Log([
                        'user_id' => $user->id,
                        'usuario_actualizador' => auth()->user()->id,
                        'empresa_id' => config('app.empresa')->id,
                        'detalle' => 'Traslado de empresa al usuario ' . 
                            ($user->name ?? '') . ' ' .
                            ($user->segundo_name ?? '') . ' ' .
                            ($user->primer_apellido ?? '') . ' ' .
                            ($user->segundo_apellido ?? '') . ' - ' .
                            ($user->codigo_interno ?? ''),
                    ]);

                    $logTraslado->save();

                    $empIds = array();
                    $empIds[] = $this->trasladar_empresa_id;
                    $user->empresas()->sync($empIds);
                }

                if (!empty($this->trasladar_plan_id)) {

                    $logTraslado = new Log([
                        'user_id' => $user->id,
                        'usuario_actualizador' => auth()->user()->id,
                        'empresa_id' => config('app.empresa')->id,
                        'detalle' => 'Traslado de plan al usuario ' . 
                            ($user->name ?? '') . ' ' .
                            ($user->segundo_name ?? '') . ' ' .
                            ($user->primer_apellido ?? '') . ' ' .
                            ($user->segundo_apellido ?? '') . ' - ' .
                            ($user->codigo_interno ?? ''),
                    ]);

                    $logTraslado->save();

                    $plnIds = array();
                    $plnIds[] = $this->trasladar_plan_id;
                    $user->planes()->sync($plnIds);
                }
            }
        }
        $this->alert('success', 'Usuarios trasladados correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = [];
    }


    public function limpiarInput()
    {
    }

    public function Exformato()
    {
        $archivos = User::whereIn('_id', $this->eliminarItem)->get();
        //dd($archivos);
        $tempFolderPath = storage_path('app/temp'); // Carpeta temporal donde se guardarán los archivos

        if (!file_exists($tempFolderPath)) {
            mkdir($tempFolderPath, 0777, true);
        }

        $zipFileName = 'Certificados_laborales.zip';
        $zipFilePath = $tempFolderPath . '/' . $zipFileName;

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {

            foreach ($archivos as $archivo) {
                if (!empty($archivo->laboral->sortByDesc('_id')->first()->certificado_laboral)) {
                    $rutaArchivo = $archivo->laboral->sortByDesc('_id')->first()->certificado_laboral;
                    if (Storage::exists($rutaArchivo)) {
                        // Copiamos el archivo a la carpeta temporal
                        $archivoNombre = pathinfo($rutaArchivo, PATHINFO_BASENAME);
                        copy(Storage::path($rutaArchivo), $tempFolderPath . '/' . $archivoNombre);

                        // Agregamos el archivo a la compresión del zip
                        $zip->addFile($tempFolderPath . '/' . $archivoNombre, $archivoNombre);
                    }
                }
            }
            $zip->close();

            // Verificamos que el archivo zip se haya creado correctamente
            if (file_exists($zipFilePath)) {
                // Descargamos el archivo zip al usuario desde el directorio storage
                $this->alert('success', 'Descargando archivos!', [
                    'position' => 'top'
                ]);
                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            } else {
                // Si no se puede crear el archivo zip, puedes devolver una respuesta de error o realizar otra acción
                return response()->json(['error' => 'No se pudo crear el archivo zip'], 500);
            }
        } else {
            // Si no se puede abrir el archivo zip, puedes devolver una respuesta de error o realizar otra acción
            return response()->json(['error' => 'No se pudo abrir el archivo zip'], 500);
        }
    }

    public function Exinformacion()
    {
        $this->alert('success', 'Descargando archivos!', [
            'position' => 'top'
        ]);
        return Excel::download(new UsersExport($this->eliminarItem), 'Usuarios.xlsx');
        //$collection = Excel::toCollection(new UsersImport, $this->file);
    }
}
