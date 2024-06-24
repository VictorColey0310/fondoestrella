<?php

namespace App\Http\Livewire;

use App\Imports\UsersImport;
use App\Models\Cargos;
use App\Models\Certificado;
use App\Models\Ciudades;
use App\Models\Educacion;
use App\Models\Formatos;
use App\Models\Laboral;
use App\Models\Log;
use App\Models\Noformal;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use App\Rules\StartsWithThree;
use App\Rules\FechaExpedicionValida;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;


class ShowEditarcv extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;

    public $buscarItem;
    public $codigo_interno;
    public $name;
    public $segundo_name;
    public $foto_perfil;
    public $foto;
    public $primer_apellido;
    public $segundo_apellido;
    public $documento;
    public $informacion = true;
    public $tipo_documento;
    public $user;
    public $user_id;
    public $municipioExp_id;
    public $fecha_exp;
    public $estado_civil;
    public $fecha_nacimiento;
    public $grupo_sanguineo;
    public $genero;
    public $nacionalidad;
    public $municipioNac_id;
    public $numero_hijos;
    public $rango_edad;
    public $poblacion_vulnerable;
    public $cargoAspira_id;
    public $cabeza_familia;
    public $servicio_public;

    public $municipioResidencia_id;
    public $barrio;
    public $telefono_contacto;
    public $observaciones;
    public $direccion_residencia;
    //public $perfil_laboral;
    public $situacion_laboral;
    public $medio_transporte;
    public $nombre_cont_emerg;
    public $numero_cont_emerg;
    public $consultaUser;
    public $ciudadNacimiento;

    //// CERTIFICACIONES //

    public $consultaCertificados;
    public $estado_territorio;
    public $curso_alturas;
    public $fecha_vencimiento;
    public $curso_espacios_conf;
    public $nivel_curso_espacios;
    public $nivel_nccer;
    public $especialidad_nccer;
    public $certificado_nccer;
    public $certificado_alturas;
    public $certificado_alturas_upload;
    public $certificado_confinados;
    public $certificado_confinados_upload;
    public $fecha_vencimiento_confi;
    public $certificado_arc_nccer;
    public $certificado_nccer_upload;
    public $fecha_vencimiento_nccer;
    public $nacionalidad_otro;
    public $ciudadExpedicion;
    public $ciudadResidencia;



    //NIVEL EDUCATIVO //

    public $nivel;
    public $titulo;
    public $institucion;
    public $ubicacion;
    public $fecha_finalizacion;
    public $estado;
    public $observacionesNivel;
    public $consultaNivel;
    public $certificado_nivel;

    //Experiencia laboral
    public $consultaLaboral;
    public $tipo;
    public $nombre_empresa;
    public $fecha_ingreso;
    public $trabajo_actual = false;
    public $fecha_retiro;
    public $pais;
    public $telefono;
    public $cargo;
    public $funciones_logros;
    public $formatoExp;
    public $certificado_laboral;
    public $certificado_laboral_file;
    public $certificacion_laboral;

    //EDUCACION NO FORMAL

    public $consultaNoformal;
    public $tipo_noformal;
    public $institucion_noformal;
    public $estado_noformal;
    public $nombre_noformal;
    public $duracion;
    public $pais_noformal;
    public $certificado_noformal;
    public $muestras;
    public $planes = [];

    public function render()
    {
        //$this->planes[]='6503e313d85d8cbbfa0340b4';
        //$usuario= Auth::user();
        //$usuario->planes()->attach($this->planes);
        //dd('llegue');

        if (empty($this->empresa_id)) {
            $this->empresa_id = config('app.empresa');
        }

        $this->user = Auth::user();

        if (empty($this->user_id)) {
            $this->user_id = $this->user->id;
        }

        $consultaFormato = Formatos::where('experiencia_laboral', true)->where('empresa_id', config('app.empresa')->id)->first();

        if ($consultaFormato) {
            $this->formatoExp = $consultaFormato->archivo;
        }

        $logs = Laboral::where('user_id', $this->user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $ultimoLog = Laboral::where('user_id', $this->user_id)->latest('created_at')->first();



        $consulta = User::find($this->user_id);

        if (empty($this->documento)) {
            $this->documento = $consulta->documento ?? '';
            $this->codigo_interno = $consulta->codigo_interno ?? '';
            $this->name = $consulta->name ?? '';
            $this->foto_perfil = $consulta->foto_perfil;
            $this->segundo_name = $consulta->segundo_name ?? '';
            $this->primer_apellido = $consulta->primer_apellido ?? '';
            $this->segundo_apellido = $consulta->segundo_apellido ?? '';
            $this->tipo_documento = $consulta->tipo_documento ?? '';
            $this->municipioExp_id = $consulta->municipioExp_id ?? '';
            if ($this->municipioExp_id) {
                $this->ciudadExpedicion = Ciudades::find($this->municipioExp_id);
            }
            $this->fecha_exp = $consulta->fecha_exp ?? '';
            $this->estado_civil = $consulta->estado_civil ?? '';
            $this->fecha_nacimiento = $consulta->fecha_nacimiento ?? '';
            $this->grupo_sanguineo = $consulta->grupo_sanguineo ?? '';
            $this->genero = $consulta->genero ?? '';
            $this->nacionalidad = $consulta->nacionalidad ?? '';
            $this->municipioNac_id = $consulta->municipioNac_id  ?? '';
            if ($this->municipioNac_id) {
                $this->ciudadNacimiento = Ciudades::find($this->municipioNac_id);
            }
            $this->numero_hijos = $consulta->numero_hijos ?? '';
            $this->rango_edad = $consulta->rango_edad ?? '';
            $this->poblacion_vulnerable = $consulta->poblacion_vulnerable ?? '';
            $this->cargoAspira_id = $consulta->cargoAspira_id ?? '';
            $this->cabeza_familia = $consulta->cabeza_familia ?? '';
            $this->servicio_public = $consulta->servicio_public ?? '';
            $this->municipioResidencia_id = $consulta->municipioResidencia_id ?? '';
            if ($this->municipioResidencia_id) {
                $this->ciudadResidencia = Ciudades::find($this->municipioResidencia_id);
            }
            $this->barrio = $consulta->barrio ?? '';
            $this->telefono_contacto = $consulta->telefono_contacto ?? '';
            $this->observaciones = $consulta->observaciones ?? '';
            $this->direccion_residencia = $consulta->direccion_residencia ?? '';
            //$this->perfil_laboral = $consulta->perfil_laboral ?? '';
            $this->situacion_laboral = $consulta->situacion_laboral ?? '';
            $this->medio_transporte = $consulta->medio_transporte ?? '';
            $this->nombre_cont_emerg = $consulta->nombre_cont_emerg ?? '';
            $this->numero_cont_emerg = $consulta->numero_cont_emerg ?? '';
            $this->nacionalidad_otro = $consulta->nacionalidad_otro ?? '';
        }

        $buscarItem = $this->buscarItem;
        $consultaCiudades = Ciudades::where('estado', 1)->when(!empty($buscarItem), function ($query) use ($buscarItem) {
            return $query->where('municipio', 'LIKE', '%' . $buscarItem . '%');
        })->get();
        //dd($consultaCiudades);
        $consultaDocumentos = ['Cédula de ciudadanía', 'Cédula de Extranjería', 'Pasaporte'];
        $consultaEstado = ['Soltero(a)', 'Casado(a)', 'Separado o Divorciado(a)', 'Viudo(a)', 'Unión Libre'];
        $consultaGrupo = ['A+', 'O+', 'B+', 'AB+', 'A-', 'O-', 'B-', 'AB-'];
        $consultaGenero = ['Masculino', 'Femenino', 'Otro'];
        $consultaNacionalidad = ['Colombiana', 'otro'];
        $consultaEdad = ['0-5 años', '6-12 años', '13-20 años', '20-25 años', 'Mayores de 25 años', 'No tengo hijos'];
        $consultaHijos = ['0', '1', '2', '3', '4', '5', 'mas de 5'];
        $consultaPoblaciones = ['Afrodescendientes', 'Indigena', 'Discapacidad', 'Mujeres mayores de 45 años', 'victima del conflicto armado', 'Desmovilizado o ex-combatiente', 'Primer empleo', 'Adulto mayor', 'Población LBGTIQ+', 'Ninguna'];
        $ConsultaCargos = Cargos::where('empresa_id', $this->empresa_id->id)->get();
        $consultaSituacion = ['Primer empleo', 'Empleado', 'Desempleado', 'independiente'];

        //Certificados
        $consultaTerritorio = ['Nacido en Barrancabermeja', 'Aprobado', 'En Trámite', 'Vencido', 'Negado', 'Sin tramitar'];
        $consultaCurso = ['Sí', 'No', 'Vencido', 'No aplica para el cargo'];
        $consultaEspacios = ['Vigía', 'Supervisor', 'Administrador'];
        $consultaEspecialidad = ['Tubería', 'Pailera', 'Electricidad', 'Instrumentación', 'Andamios', 'Calderas', 'Aislamiento', 'Mecánica', 'Construccion', 'Soldadura', 'Basico'];
        $NivelCCNER = ['Curriculo Basico', 'Nivel 1', 'Nivel 2', 'Nivel 3', 'Nivel 4'];

        //NivelEducativo
        $niveles = ['Preescolar', 'Basica primaria', 'Basica secundaria', 'Media', 'Tecnica laboral', 'Tecnica profesional', 'Tecnología', 'Universitaria', 'Especialización', 'Maestría', 'Doctorado'];
        $estados = ['En curso', 'Incompleto', 'Graduado'];

        //ExperienciaLaboral
        $tipoExperiencia = ['Asalariado', 'Independiente', 'Pasantía o Práctica Laboral'];
        $tipoCurso = ['Curso', 'Taller', 'Diplomado', 'Seminario', 'Certificación de competencias'];

        $this->certificados();
        $this->nivelEducativo();
        $this->experienciaLaboral();
        $this->educacionNoformal();

        if (!empty($this->certificado_laboral_file)) {
            $this->muestras = Excel::toCollection(new UsersImport, $this->certificado_laboral_file)->take(50);
            //dd($this->muestras);

        }
        return view('livewire.show-editarcv', compact('tipoCurso', 'consultaDocumentos', 'consultaEstado', 'logs', 'ultimoLog', 'consultaCiudades', 'consultaGrupo', 'consultaGenero', 'consultaNacionalidad', 'consultaEdad', 'consultaHijos', 'consultaPoblaciones', 'ConsultaCargos', 'consultaSituacion', 'consultaTerritorio', 'consultaCurso', 'consultaEspacios', 'consultaEspecialidad', 'NivelCCNER', 'niveles', 'estados', 'tipoExperiencia'));
    }

    public function guardar()
    {
        if ($this->foto) {
            $this->foto_perfil = $this->foto->store('storage');
        }
        if ($this->ciudadNacimiento) {
            $this->municipioNac_id = $this->ciudadNacimiento['_id'] ?? '';
        }
        if ($this->ciudadExpedicion) {
            $this->municipioExp_id = $this->ciudadExpedicion['_id'] ?? '';
        }
        if ($this->ciudadResidencia) {
            $this->municipioResidencia_id = $this->ciudadResidencia['_id'] ?? '';
        }
        //dd($this->fecha_nacimiento);
        $validateData = $this->validate([
            'codigo_interno' => 'nullable|alpha_num',
            'name' => 'nullable|alpha',
            'segundo_name' => 'nullable|alpha',
            'primer_apellido' => 'nullable|alpha',
            'segundo_apellido' => 'nullable|alpha',
            'foto_perfil' => 'nullable',
            'documento' => 'nullable|numeric',
            'tipo_documento' => 'nullable',
            'municipioExp_id' => 'nullable',
            'fecha_nacimiento' => ['nullable', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
            'fecha_exp' => ['nullable', 'before_or_equal:today', new FechaExpedicionValida($this->fecha_nacimiento)],
            'estado_civil' => 'nullable',
            'genero' => 'nullable',
            'grupo_sanguineo' => 'nullable',
            'nacionalidad' => 'nullable',
            'nacionalidad_otro' => 'nullable',
            'rango_edad' => 'nullable',
            'numero_hijos' => 'nullable',
            'municipioNac_id' => 'nullable',
            'poblacion_vulnerable' => 'nullable',
            'cargoAspira_id' => 'nullable',
            'cabeza_familia' => 'nullable',
            'servicio_public' => 'nullable',
            'municipioResidencia_id' => 'nullable',
            'barrio' => 'nullable',
            'telefono_contacto' => ['nullable', 'numeric', new StartsWithThree],
            'observaciones' => 'nullable',
            'direccion_residencia' => 'nullable',
            //'perfil_laboral' => 'nullable',
            'situacion_laboral' => 'nullable',
            'medio_transporte' => 'nullable',
            'nombre_cont_emerg' => 'nullable',
            'numero_cont_emerg' => ['nullable', 'numeric', new StartsWithThree],
        ]);
        //dd($validateData);
        $user = User::find($this->user_id);

        $user->update($validateData);

  

        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);
    }

    public function certificados()
    {

        $consultaCertificados = Certificado::where('user_id', $this->user_id)->first();
        if (empty($this->curso_alturas)) {
            $this->estado_territorio = $consultaCertificados->estado_territorio ?? '';
            $this->curso_alturas = $consultaCertificados->curso_alturas ?? '';
            $this->fecha_vencimiento = $consultaCertificados->fecha_vencimiento ?? '';
            $this->curso_espacios_conf = $consultaCertificados->curso_espacios_conf ?? '';
            $this->nivel_curso_espacios = $consultaCertificados->nivel_curso_espacios ?? '';
            $this->nivel_nccer = $consultaCertificados->nivel_nccer ?? '';
            $this->especialidad_nccer = $consultaCertificados->estado_territorio ?? '';
            $this->certificado_nccer = $consultaCertificados->certificado_nccer ?? '';
            $this->certificado_alturas = $consultaCertificados->certificado_alturas ?? '';
            $this->certificado_confinados = $consultaCertificados->certificado_confinados ?? '';
            $this->fecha_vencimiento_confi = $consultaCertificados->fecha_vencimiento_confi ?? '';
            $this->certificado_arc_nccer = $consultaCertificados->certificado_arc_nccer ?? '';
            $this->fecha_vencimiento_nccer = $consultaCertificados->fecha_vencimiento_nccer ?? '';
        }
        $this->consultaCertificados = $consultaCertificados;
    }

    public function guardarCertificados()
    {
        if ($this->certificado_alturas_upload) {
            $this->certificado_alturas = $this->certificado_alturas_upload->store('storage');
        }
        if ($this->certificado_confinados_upload) {
            $this->certificado_confinados = $this->certificado_confinados_upload->store('storage');
        }
        if ($this->certificado_nccer_upload) {
            $this->certificado_arc_nccer = $this->certificado_nccer_upload->store('storage');
        }
        //dd($this->certificado_confinados);
        $validateData = $this->validate([
            'estado_territorio' => 'nullable',
            'curso_alturas' => 'nullable',
            'fecha_vencimiento' => 'date|after_or_equal:tomorrow|nullable',
            'curso_espacios_conf' => 'nullable',
            'fecha_vencimiento_confi' => 'date|after_or_equal:tomorrow|nullable',
            'nivel_curso_espacios' => 'nullable',
            'nivel_nccer' => 'nullable',
            'especialidad_nccer' => 'nullable',
            'certificado_nccer' => 'nullable',
            'user_id' => 'nullable',
            'certificado_alturas' => 'nullable',
            'certificado_confinados' => 'nullable',
            'certificado_arc_nccer' => 'nullable',
            'fecha_vencimiento_nccer' => 'date|after_or_equal:tomorrow|nullable'

        ]);

        //dd($validateData);
        Certificado::updateOrCreate(['user_id' => $this->user_id], $validateData);


        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);
    }

    public function nivelEducativo()
    {
        $this->consultaNivel = Educacion::where('user_id', $this->user_id)->get();
    }

    public function guardarNivel()
    {
        if ($this->certificado_nivel) {
            $this->certificado_nivel = $this->certificado_nivel->store('storage');
        }
        $validateData = $this->validate([
            'nivel' => 'required',
            'titulo' => 'required',
            'institucion' => 'required',
            'ubicacion' => 'nullable',
            'fecha_finalizacion' => 'date|before_or_equal:yesterday|nullable',
            'estado' => 'required',
            'observacionesNivel' => 'required',
            'user_id' => 'required',
            'certificado_nivel' => 'nullable'

        ]);
        Educacion::create($validateData);

        $user = Auth::user();

        $log = new Log([
            'user_id' => $user->id,
            'usuario_actualizador' => $user->id,
            'detalle' => 'El usuario ' . ($user->name ?? '') . ' ' .
                ($user->segundo_name ?? '') . ' ' .
                ($user->primer_apellido ?? '') . ' ' .
                ($user->segundo_apellido ?? '') . ' - ' .
                ($user->codigo_interno ?? '') . ' - ' . ($user->email ?? '') . ' ha añadido un nuevo nivel educativo a su cv',
            'empresa_id' => $user->empresa_seleccionada->first()->empresa_id,
        ]);
        $log->save();

        $this->limpiarInput();
        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);
    }

    public function eliminarNivel($id)
    {

        $consulta = Educacion::find($id);


        $consulta->delete();
        $this->alert('success', 'Eliminado correctamente', [
            'position' => 'top'
        ]);
    }

    public function experienciaLaboral()
    {
        $this->consultaLaboral = Laboral::where('user_id', $this->user_id)->get();
    }
    public function guardarCertificadoLaboral($certificado_laboral)
    {

        //dd($certificado_laboral);
        $user =  User::find($this->user_id);
        $documento = $user->documento;
        $nombre = $user->name . ' ' . $user->primer_apellido;
        $nombre = trim($nombre);


        if ($this->certificacion_laboral) {
            $nombrePersonalizado = 'certificacion-' . $documento . '-' . $nombre . '.' . $this->certificacion_laboral->getClientOriginalExtension();
            $this->certificacion_laboral = $this->certificacion_laboral->storeAs('storage', $nombrePersonalizado);
        }
        //$this->certificado_laboral = $id;
        
        Laboral::create([
            'user_id' => $this->user_id,
            'certificado_laboral' => $certificado_laboral,
            'certificacion_laboral' => $this->certificacion_laboral,
            'c' => true,
        ]);

        $log = new Log([
            'user_id' => $user->id,
            'usuario_actualizador' => $user->id,
            'detalle' => 'El usuario ' . ($user->name ?? '') . ' ' .
                ($user->segundo_name ?? '') . ' ' .
                ($user->primer_apellido ?? '') . ' ' .
                ($user->segundo_apellido ?? '') . ' - ' .
                ($user->codigo_interno ?? '') . ' - ' . ($user->email ?? '') . ' ha subido el certificado laboral',
            'empresa_id' => $user->empresa_seleccionada->first()->empresa_id,
        ]);
        $log->save();

        $this->limpiarInput();

        $this->alert('success', 'Agregado correctamente!', [
            'position' => 'top'
        ]);
    }
    public function guardarLaboral($certificacion_laboral)
    {
        //dd($certificacion_laboral);
        $user =  User::find($this->user_id);
        $documento = $user->documento;
        $nombre = $user->name . ' ' . $user->primer_apellido;

        if ($this->certificado_laboral_file) {
            $nombrePersonalizado = $documento . '-' . $nombre . '.' . $this->certificado_laboral_file->getClientOriginalExtension();
            $this->certificado_laboral = $this->certificado_laboral_file->storeAs('storage', $nombrePersonalizado);
        }
        $this->certificacion_laboral = $certificacion_laboral;
        $validateData = $this->validate([
            'user_id' => 'required',
            'certificado_laboral' => 'required',
        ]);

        Laboral::create($validateData);

        $log = new Log([
            'user_id' => $user->id,
            'usuario_actualizador' => $user->id,
            'detalle' => 'El usuario ' . ($user->name ?? '') . ' ' .
                ($user->segundo_name ?? '') . ' ' .
                ($user->primer_apellido ?? '') . ' ' .
                ($user->segundo_apellido ?? '') . ' - ' .
                ($user->codigo_interno ?? '') . ' - ' . ($user->email ?? '') . ' ha subido el formato de experiencia laboral',
            'empresa_id' => $user->empresa_seleccionada->first()->empresa_id,
        ]);
        $log->save();

        $this->limpiarInput();

        $this->alert('success', 'Agregado correctamente!', [
            'position' => 'top'
        ]);
    }


    // 'tipo' => 'required',
    // 'nombre_empresa' => 'required',
    // 'fecha_ingreso' => 'required|date|before_or_equal:yesterday',
    // 'trabajo_actual' => 'required',
    // 'fecha_retiro' => 'date|before_or_equal:yesterday|nullable',
    // 'pais' => 'required',
    // 'telefono' =>  ['required', 'numeric', new StartsWithThree],
    // 'cargo' => 'required',
    // 'funciones_logros' => 'required',


    public function eliminarLaboral($id)
    {

        $consulta = Laboral::find($id);

        $consulta->delete();
        $this->alert('success', 'Eliminado correctamente', [
            'position' => 'top'
        ]);
    }

    public function educacionNoformal()
    {
        $this->consultaNoformal = Noformal::where('user_id', $this->user_id)->get();
    }

    public function guardarNoformal()
    {
        if ($this->certificado_noformal) {
            $this->certificado_noformal = $this->certificado_noformal->store('storage');
        }

        $validateData = $this->validate([
            'tipo_noformal' => 'required',
            'institucion_noformal' => 'required',
            'estado_noformal' => 'required',
            'nombre_noformal' => 'required',
            'duracion' => 'required|numeric',
            'pais_noformal' => 'required',
            'user_id' => 'required',
            'certificado_noformal' => 'nullable'
            // 'archivo_noformal' => 'required',  

        ]);
        //dd($validateData);
        Noformal::create($validateData);

        $user = Auth::user();

        $log = new Log([
            'user_id' => $user->id,
            'usuario_actualizador' => $user->id,
            'detalle' => 'El usuario ' . ($user->name ?? '') . ' ' .
                ($user->segundo_name ?? '') . ' ' .
                ($user->primer_apellido ?? '') . ' ' .
                ($user->segundo_apellido ?? '') . ' - ' .
                ($user->codigo_interno ?? '') . ' - ' . ($user->email ?? '') . ' ha añadido una nueva capacitación o certificación a su cv',
            'empresa_id' =>$user->empresa_seleccionada->first()->empresa_id,
        ]);
        $log->save();

        $this->limpiarInput();

        $this->alert('success', 'Agregado correctamente!', [
            'position' => 'top'
        ]);
    }

    public function eliminarNoformal($id)
    {

        $consulta = Noformal::find($id);

        $consulta->delete();
        $this->alert('success', 'Eliminado correctamente', [
            'position' => 'top'
        ]);
    }

    public function eliminarCertificado()
    {
        $this->certificado_alturas = null;
    }

    public function eliminarCertificadoConfi()
    {
        $this->certificado_confinados = null;
    }

    public function eliminarCertificadoNccer()
    {
        $this->certificado_arc_nccer = null;
    }

    public function limpiarInput()
    {
        //NIVEL EDUCATIVO //

        $this->nivel = '';
        $this->titulo = '';
        $this->institucion = '';
        $this->ubicacion = '';
        $this->fecha_finalizacion = '';
        $this->estado = '';
        $this->observacionesNivel = '';
        $this->consultaNivel = '';
        $this->certificado_nivel = '';

        //Experiencia laboral
        $this->consultaLaboral = '';
        $this->tipo = '';
        $this->nombre_empresa = '';
        $this->fecha_ingreso = '';
        $this->trabajo_actual = false;
        $this->fecha_retiro = '';
        $this->pais = '';
        $this->telefono = '';
        $this->cargo = '';
        $this->funciones_logros = '';

        $this->certificado_laboral_file = '';

        //EDUCACION NO FORMAL

        $this->consultaNoformal = '';
        $this->tipo_noformal = '';
        $this->institucion_noformal = '';
        $this->estado_noformal = '';
        $this->nombre_noformal = '';
        $this->duracion = '';
        $this->pais_noformal = '';
        $this->certificado_noformal = '';
    }

    public $certificado = false;

    public $nivel_modal = false;
    public $informacion_modal = true;

    public function guardarBasico()
    {
        $this->guardar();

        $user = Auth::user();

        $log = new Log([
            'user_id' => $user->id,
            'usuario_actualizador' => $user->id,
            'detalle' => 'El usuario ' . ($user->name ?? '') . ' ' .
                ($user->segundo_name ?? '') . ' ' .
                ($user->primer_apellido ?? '') . ' ' .
                ($user->segundo_apellido ?? '') . ' - ' .
                ($user->codigo_interno ?? '') . ' - ' . ($user->email ?? '') . ' ha actualizado la información básica de su cv',
            'empresa_id' => $user->empresa_seleccionada->first()->empresa_id,
        ]);
        $log->save();

        $this->informacion_modal = false;
        $this->certificado = true;
        $this->nivel_modal = false;
    }
    public function guardarCertificado()
    {
        $this->guardarCertificados();

        $user = Auth::user();

        $log = new Log([
            'user_id' => $user->id,
            'usuario_actualizador' => $user->id,
            'detalle' => 'El usuario ' . ($user->name ?? '') . ' ' .
                ($user->segundo_name ?? '') . ' ' .
                ($user->primer_apellido ?? '') . ' ' .
                ($user->segundo_apellido ?? '') . ' - ' .
                ($user->codigo_interno ?? '') . ' - ' . ($user->email ?? '') . ' ha actualizado los certificados de su cv',
            'empresa_id' => $user->empresa_seleccionada->first()->empresa_id,
        ]);
        $log->save();


        $this->informacion_modal = false;
        $this->certificado = false;
        $this->nivel_modal = true;
    }

    public function selectItem($item)
    {
        $this->ciudadNacimiento = (array) $item;
    }

    public function deleteItem()
    {
        $this->ciudadNacimiento = '';
    }

    public function selectExpedicion($item)
    {
        $this->ciudadExpedicion = (array) $item;
    }

    public function deleteExpedicion()
    {
        $this->ciudadExpedicion = '';
    }

    public function selectResidencia($item)
    {
        $this->ciudadResidencia = (array) $item;
    }

    public function deleteResidencia()
    {
        $this->ciudadResidencia = '';
    }
}
