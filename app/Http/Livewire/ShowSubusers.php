<?php

namespace App\Http\Livewire;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\Areas;
use App\Models\Cargos;
use App\Models\Empresas;
use App\Models\Log;
use App\Models\Modulos;
use App\Models\Plan;
use App\Models\Planes;
use App\Models\Roles;
use App\Models\Subareas;
use App\Models\subRoles;
use App\Models\User;
use App\Rules\StartsWithThree;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\WelcomeNotification;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use ZipArchive;



class ShowSubusers extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;

    // MODALES
    public $nuevo = false;
    public $editar = false;
    public $ver = false;

    // FILTROS
    public $buscar;
    public $user_id;
    public $empresa_id;

    public $name;
    public $plan_id;
    public $codigo_interno;
    public $segundo_name;
    public $primer_apellido;
    public $segundo_apellido;
    public $telefono;
    public $password;
    public $email;
    public $estado = 1;
    public $documento;
    public $rol_id;
    public $subarea_id;
    public $editarPassword = false;
    public $consultaVer;
    public $consulta;
    public $empresas = [];
    public $empresasVer;
    public $empresasEditar;
    public $eliminarItem = [];
    public $usuario_creador;
    public $usuario_actualizador;
    public $empresas_admin;
    public $file;
    public $checkAll = false;
    public $empresasRelacionadas;
    public $userEmpresas = [];
    public $nocertificado = [];
    public $modalnocertificado = false;
    public $filtro_plan_id;
    public $activarUser = false;
    public $empresa_user_id;


    public function mensajeEnviado($empresa_id)
    {
        $this->empresa_id = $empresa_id;
    }

    public function agregarEmpresa()
    {

        if ($this->empresa_user_id !== null && $this->empresa_user_id !== '') {
            $this->userEmpresas[] = $this->empresa_user_id;
        }

        $this->empresa_user_id = '';
    }

    public function eliminarEmpresa($empresaId)
    {
        $index = array_search($empresaId, $this->userEmpresas);

        if ($index !== false) {
            unset($this->userEmpresas[$index]);

            $this->userEmpresas = array_values($this->userEmpresas);
        }
    }

    public function toggleCheckAll()
    {
        if ($this->checkAll) {
            $this->eliminarItem = collect($this->consulta)->pluck('id')->toArray();
        } else {
            $this->eliminarItem = [];
        }
    }

    public function selectEmpresa($id)
    {
        $id = json_decode($id);
        $id = (array) $id;
        //dd($id);
        // Verificar si el elemento ya existe en selectedItems
        if (!in_array($id, $this->empresas)) {
            $this->empresas[] = $id;
        }

        //dd($this->modulos);
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

        $consultaUsuario = User::query()
        ->when(!empty($buscar), function ($query) use ($buscar) {
            return $query->where('name', 'LIKE', '%' . $buscar . '%');
        })
        ->whereNotNull('primer_apellido')
        ->paginate(20);


        //$consultaEmpresas= Empresas::get();
        if (empty($this->password)) {
            $this->password = $this->documento;
        }
        $activos = 0;
        $inactivos = 0;

        if (!empty($consultaUsuario)) {
            $activos = $consultaUsuario->where('estado', 1)->count();
            $inactivos = $consultaUsuario->where('estado', 0)->count();
        }

        $consultaEmpresas = Auth::user()->empresas;

        return view('livewire.show-subusers', [
            'consultaUsuario' => $consultaUsuario,
            'consultaRoles' =>  Roles::whereNull('rol_super')->get(),
            'consultaEmpresas' => $consultaEmpresas,
            'activos' => $activos,
            'inactivos' => $inactivos,
        ]);
    }

    //CREAR
    public function guardar()
    {
        $this->validate([
            'documento' => 'required|numeric|unique:users',
            'name' => 'required|alpha',
            'segundo_name' => 'nullable|alpha',
            'primer_apellido' => 'required|alpha',
            'segundo_apellido' => 'required|alpha',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'empresa_id' => 'required',
            'rol_id' => 'required',
            'estado' => 'required',
        ]);

        $user = User::create([
            'name' => $this->name,
            'segundo_name' => $this->segundo_name,
            'primer_apellido' => $this->primer_apellido,
            'segundo_apellido' => $this->segundo_apellido,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'documento' => $this->documento,
            'rol_id' => $this->rol_id,
            'estado' => $this->estado,
            'user_id' => $this->user_id,
        ]);

        if (!is_null($this->empresas)) {

            $ids = array();
            foreach ($this->empresas as $empresa) {

                if (isset($empresa['_id'])) {
                    $ids[] = $empresa['_id'];
                }
            }
        }

        if (!is_null($this->empresas)) {
            $user->empresas()->sync($ids);
        }

        $user->notify(new WelcomeNotification($user->name, $user->documento));

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();
    }


    public function cargarDatosExcel()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new UsersImport, $this->file);

        session()->flash('message', 'Datos cargados exitosamente.');
    }

    //CAMBIAR ESTADO
    public function cambiarEstado($id, $estado)
    {
        $estado = $estado ? 0 : 1;

        $actualizar = User::find($id)->update(['estado' => $estado]);

        if ($actualizar && $estado == 1) {
            $this->alert('success', 'Activo!', [
                'position' => 'top'
            ]);
        }
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = User::find($id);
        $this->codigo_interno = $this->consultaVer->codigo_interno;
        $this->name = $this->consultaVer->name;
        $this->segundo_name = $this->consultaVer->segundo_name;
        $this->primer_apellido = $this->consultaVer->primer_apellido;
        $this->segundo_apellido = $this->consultaVer->segundo_apellido;
        $this->documento = $this->consultaVer->documento;
        $this->telefono = $this->consultaVer->telefono;
        $this->email = $this->consultaVer->email;
        $this->rol_id = $this->consultaVer->rol_id;
        $this->empresasVer = $this->consultaVer->empresas;
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
            'confirmed',
            'confirmedEnviarInvitacionMasiva'
        ];
    }

    public function confirmed()
    {
        foreach ($this->eliminarItem as $userId) {
            $user = User::find($userId);
            if ($user) {
                User::where('_id', $userId)->delete();

                $logEliminacion = new Log([
                    'user_id' => $user->id,
                    'usuario_actualizador' => auth()->user()->id,
                    'empresa_id' => config('app.empresa')->id,
                    'detalle' => 'Eliminación de usuario ' .
                        ($user->name ?? '') . ' ' .
                        ($user->segundo_name ?? '') . ' ' .
                        ($user->primer_apellido ?? '') . ' ' .
                        ($user->segundo_apellido ?? '') . ' - ' .
                        ($user->codigo_interno ?? ''),
                ]);

                $logEliminacion->save();
            }
        }

        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);

        $this->eliminarItem = [];
    }

    //VER EDITAR
    public function editar($id)
    {
        $this->ver = false;

        $this->consultaVer = User::find($id);
        $this->name = $this->consultaVer->name;
        $this->segundo_name = $this->consultaVer->segundo_name;
        $this->primer_apellido = $this->consultaVer->primer_apellido;
        $this->segundo_apellido = $this->consultaVer->segundo_apellido;
        $this->documento = $this->consultaVer->documento;
        $this->email = $this->consultaVer->email;
        $this->rol_id = $this->consultaVer->rol_id;
        $this->empresas = $this->consultaVer->empresas->toArray();

        $this->editar = true;
    }

    public function deleteEmpresa($id)
    {
        $this->empresas = array_filter($this->empresas, function ($item) use ($id) {

            return $item['_id'] !== $id;
        });
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'segundo_name' => 'nullable|alpha',
            'primer_apellido' => 'required|alpha',
            'segundo_apellido' => 'required|alpha',
            'email' => 'required|email',
            'documento' => 'required',
            'user_id' => 'required',
            'estado' => 'required',
            'rol_id' => 'required'
        ]);

        $user = User::find($id);
        $user->update($validatedData);

        if (!is_null($this->empresas)) {

            $ids = array();
            foreach ($this->empresas as $empresa) {

                if (isset($empresa['_id'])) {
                    $ids[] = $empresa['_id'];
                }
            }
            $user->empresas()->sync($ids);
        }

        $this->limpiarInput();

        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);
    }
    public function limpiarInput()
    {
        $this->nuevo = false;
        $this->editar = false;
        $this->ver = false;

        $this->name = null;
        $this->segundo_name = null;
        $this->primer_apellido = null;
        $this->segundo_apellido = null;
        $this->email = null;
        $this->documento = null;
        $this->telefono = null;
        $this->rol_id = null;
        $this->subarea_id = null;
        $this->userEmpresas = [];
    }

    public function generarPassword()
    {
        $this->password = Str::random(10);
    }

    public function guardarPassword()
    {
        $validatedData = $this->validate([
            'password' => 'required'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::find($this->consultaVer->id);
        $user->update($validatedData);
        $this->editarPassword = false;

        $logNewPassword = new Log([
            'user_id' => $user->id,
            'usuario_actualizador' => auth()->user()->id,
            'empresa_id' => config('app.empresa')->id,
            'detalle' => 'Se cambió la contraseña al usuario ' .
                ($user->name ?? '') . ' ' .
                ($user->segundo_name ?? '') . ' ' .
                ($user->primer_apellido ?? '') . ' ' .
                ($user->segundo_apellido ?? '') . ' - ' .
                ($user->codigo_interno ?? ''),
        ]);

        $logNewPassword->save();

        $this->alert('success', 'Contraseña actualizada!', [
            'position' => 'top'
        ]);
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
                } else {
                    $estado = ($archivo->estado == 1) ? "Activo" : "Inactivo";
                    $this->nocertificado[] = $archivo->documento . ' - ' . $archivo->name . ' ' . $archivo->segundo_name . ' ' . $archivo->primer_apellido . ' ' . $archivo->segundo_apellido . ' - ' . $estado . ' - Sin Formato';
                }
                if (!empty($archivo->laboral->sortByDesc('_id')->first()->certificacion_laboral)) {
                    $rutaArchivoCert = $archivo->laboral->sortByDesc('_id')->first()->certificacion_laboral;
                    if (Storage::exists($rutaArchivoCert)) {
                        // Copiamos el archivo a la carpeta temporal
                        $archivoNombreCert = pathinfo($rutaArchivoCert, PATHINFO_BASENAME);
                        copy(Storage::path($rutaArchivoCert), $tempFolderPath . '/' . $archivoNombreCert);

                        // Agregamos el archivo a la compresión del zip
                        $zip->addFile($tempFolderPath . '/' . $archivoNombreCert, $archivoNombreCert);
                    }
                } else {
                    $estado = ($archivo->estado == 1) ? "Activo" : "Inactivo";
                    $this->nocertificado[] = $archivo->documento . ' - ' . $archivo->name . ' ' . $archivo->segundo_name . ' ' . $archivo->primer_apellido . ' ' . $archivo->segundo_apellido . ' - ' . $estado . ' - Sin certificaciones';
                }
            }
            if ($this->nocertificado) {
                $this->modalnocertificado = true;
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

    public function enviarInvitacion($id)
    {
        $user = User::find($id);
        $user->notify(new WelcomeNotification($user->name, $user->documento));
        $this->alert('success', 'Correo enviado!', [
            'position' => 'top'
        ]);

        $logCredenciales = new Log([
            'user_id' => $user->id,
            'usuario_actualizador' => auth()->user()->id,
            'empresa_id' => config('app.empresa')->id,
            'detalle' => 'Se enviaron credenciales al usuario ' .
                ($user->name ?? '') . ' ' .
                ($user->segundo_name ?? '') . ' ' .
                ($user->primer_apellido ?? '') . ' ' .
                ($user->segundo_apellido ?? '') . ' - ' .
                ($user->codigo_interno ?? ''),
        ]);

        $logCredenciales->save();

        $this->limpiarInput();
    }

    public function enviarInvitacionMasiva()
    {
        $usuariosNum = count($this->eliminarItem);

        $this->alert('warning', '¿Enviar credenciales a ' . $usuariosNum . ' usuarios?', [
            'position' => 'center',
            'timer' => '10000',
            'toast' => false,
            'text' => 'Esta seguro',
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmedEnviarInvitacionMasiva',
            'showDenyButton' => false,
            'onDenied' => '',
            'showCancelButton' => true,
            'onDismissed' => '',
            'cancelButtonText' => 'Salir',
            'confirmButtonText' => 'Si',
        ]);
    }

    public function confirmedEnviarInvitacionMasiva()
    {
        $usuariosNum = count($this->eliminarItem);

        foreach ($this->eliminarItem as $i => $v) {
            $user = User::find($v);
            $user->notify(new WelcomeNotification($user->name, $user->documento));

            $logCredenciales = new Log([
                'user_id' => $user->id,
                'usuario_actualizador' => auth()->user()->id,
                'empresa_id' => config('app.empresa')->id,
                'detalle' => 'Se enviaron credenciales al usuario ' .
                    ($user->name ?? '') . ' ' .
                    ($user->segundo_name ?? '') . ' ' .
                    ($user->primer_apellido ?? '') . ' ' .
                    ($user->segundo_apellido ?? '') . ' - ' .
                    ($user->codigo_interno ?? ''),
            ]);

            $logCredenciales->save();
        }

        $this->alert('success', 'Correo enviado a ' . $usuariosNum . ' usuarios!!', [
            'position' => 'top'
        ]);

        $this->eliminarItem = [];
    }

    public function activar()
    {
        $users = User::whereIn('_id', $this->eliminarItem)->get();

        foreach ($users as $user) {
            $user->update(['estado' => 1]);
            $logEstado = new Log([
                'user_id' => $user->id,
                'usuario_actualizador' => auth()->user()->id,
                'empresa_id' => config('app.empresa')->id,
                'detalle' => 'Se activo al usuario ' .
                    ($user->name ?? '') . ' ' .
                    ($user->segundo_name ?? '') . ' ' .
                    ($user->primer_apellido ?? '') . ' ' .
                    ($user->segundo_apellido ?? '') . ' - ' .
                    ($user->codigo_interno ?? ''),
            ]);

            $logEstado->save();
        }
        $this->alert('success', 'Usuarios activados correctamente!', [
            'position' => 'top'
        ]);

        $this->eliminarItem = [];
    }

    public function desactivar()
    {
        $users = User::whereIn('_id', $this->eliminarItem)->get();

        foreach ($users as $user) {
            $user->update(['estado' => 0]);

            $logEstado = new Log([
                'user_id' => $user->id,
                'usuario_actualizador' => auth()->user()->id,
                'empresa_id' => config('app.empresa')->id,
                'detalle' => 'Se desactivo al usuario ' .
                    ($user->name ?? '') . ' ' .
                    ($user->segundo_name ?? '') . ' ' .
                    ($user->primer_apellido ?? '') . ' ' .
                    ($user->segundo_apellido ?? '') . ' - ' .
                    ($user->codigo_interno ?? ''),
            ]);

            $logEstado->save();
        }
        $this->alert('success', 'Usuarios desactivados correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = [];
    }
}
