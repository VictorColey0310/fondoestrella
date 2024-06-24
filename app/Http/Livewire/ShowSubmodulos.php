<?php

namespace App\Http\Livewire;

use App\Models\Iconos;
use App\Models\Modulos;
use App\Models\Submodulos;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class ShowSubmodulos extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $nombre;
    public $modulo_id;
    public $descripcion;
    public $estado = 1;
    public $nuevo = false;
    public $editar = false;
    public $ver = false;
    public $consultaVer;
    public $buscar;
    public $url;
    public $eliminarItem = ['1'];
    public $usuario_creador;
    public $usuario_actualizador;


    public $dynamicInputs = '';
    public $dynamicCampos = '';
    public $dynamicRules = '';
    public $dynamicEdit = '';
    public $dynamicTh = '';
    public $dynamicTd = '';
    public $dynamicLimpiar = '';
    public $crud = false;
    public $datos = [];
    public $dato;
    public $label;
    public $tipo = 'text';

    public function render()
    {
        $this->generateDynamicInputs();
        $buscar = $this->buscar;

        $consulta = Submodulos::query()
            ->when(!empty($buscar), function ($query) use ($buscar) {
                return $query->where('nombre', 'LIKE', '%' . $buscar . '%');
            })
            ->paginate(20);
        $consultaModulos = Modulos::get();
        //dd($consultaIconos);
        return view('livewire.show-submodulos', [
            'consulta' => $consulta,
            'consultaModulos' => $consultaModulos
        ]);
    }

    public function agregarDato()
    {
        if (empty($this->dato) || empty($this->tipo) || empty($this->label)) {
            $this->alert('error', 'Debes llenar todos los campos!', [
                'position' => 'top'
            ]);
            return;
        }
        $this->datos[] = [
            'dato' => $this->dato,
            'label' => $this->label,
            'tipo' => $this->tipo,
        ];

        // Limpiar los campos después de agregar
        $this->generateDynamicInputs();
        $this->dato = '';
        $this->label = '';
        $this->tipo = 'text';
    }

    public function eliminarDato($index)
    {
        unset($this->datos[$index]);
        $this->datos = array_values($this->datos); // Reindexar el array
    }

    public function generateDynamicInputs()
    {
        $dynamicInputs = '';
        $dynamicCampos = '';
        $dynamicRules = '';
        $dynamicTh = '';
        $dynamicTd = '';
        $dynamicEdit = '';
        $dynamicLimpiar = '';

        foreach ($this->datos as $dato) {

            $dynamicInputs .= <<<EOD
                <x-input-with-label wire="{$dato['dato']}"
                    label="{$dato['label']}"
                    name="{$dato['dato']}"
                    id="{$dato['dato']}"
                    type="{$dato['tipo']}"
                    placeholder="{$dato['label']}"
                    maxlength="20"
                    value=""
                />
            EOD;

            $dynamicCampos .= <<<EOD
                public \${$dato['dato']}; \n
            EOD;

            $dynamicEdit .= <<<EOD
            \$this->{$dato['dato']} = \$this->consultaVer->{$dato['dato']};
            EOD;

            $dynamicTh .= <<<EOD
                <th class="capitalize">{$dato['dato']}</th> \n
            EOD;

            $dynamicTd .= <<<EOD
                <x-td wire:click="ver('{{ \$item->id }}')">
                    {{\$item->{$dato['dato']}}}
                </x-td>    \n
            EOD;

            $dynamicLimpiar .= <<<EOD
                \$this->{$dato['dato']} = null; \n
            EOD;

            if ($dato['tipo'] === 'number') {
                $dynamicRules .= <<<EOD
                    '{$dato['dato']}' => ['required','numeric','min:0'],\n
                EOD;
            } else {
                $dynamicRules .= <<<EOD
                    '{$dato['dato']}' => ['required'],\n
                EOD;
            }
        }

        $this->dynamicInputs = $dynamicInputs;
        $this->dynamicCampos = $dynamicCampos;
        $this->dynamicRules = $dynamicRules;
        $this->dynamicTh = $dynamicTh;
        $this->dynamicTd = $dynamicTd;
        $this->dynamicEdit = $dynamicEdit;
        $this->dynamicLimpiar = $dynamicLimpiar;
    }

    //CREAR
    public function guardar()
    {
        $this->usuario_creador = Auth::user()->id;
        $validatedData = $this->validate([
            'nombre' => 'required',
            'modulo_id' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
            'usuario_creador' => 'required',
            'url' => 'required'
        ]);


        if ($this->crud) {
            if (empty($this->datos)) {
                $this->alert('error', 'Debes tener almenos un dato!', [
                    'position' => 'top'
                ]);
                return;
            }
        }

        Submodulos::create($validatedData);

        // Crear la ruta /url en routes/web.php
        $routeCode = "Route::get('/" . $this->url . "', [MenuController::class, '$this->url'])->name('" . $this->url . "');\n";
        file_put_contents(base_path('routes/web.php'), $routeCode, FILE_APPEND | LOCK_EX);

        // Crear el controlador MenuController si no existe
        if (!file_exists(app_path('Http/Controllers/MenuController.php'))) {
            Artisan::call('make:controller MenuController');
        }

        // Crear el método Show$this->url() en MenuController si no existe
        $menuControllerFile = app_path('Http/Controllers/MenuController.php');
        $menuControllerContents = file_get_contents($menuControllerFile);

        if (!Str::contains($menuControllerContents, "public function $this->url()")) {
            $newMethod = <<<EOT

                public function $this->url()
                {
                    return view('menu.$this->url');
                }
            EOT;
            $menuControllerContents = Str::replaceLast('}', $newMethod . "\n}", $menuControllerContents);
            file_put_contents($menuControllerFile, $menuControllerContents);
        }

        // Crear el archivo $this->url.blade.php en views/menu/ si no existe
        $nombreBladePath = resource_path("views/menu/$this->url.blade.php");
        if (!file_exists($nombreBladePath)) {
            file_put_contents($nombreBladePath, '
                <x-app-layout>
                    <x-slot name="header">
                        <div>
                            <h1 class="text-2xl font-bold tracking-tight text-gray-900">' . $this->nombre . '</h1>
                        </div>
                    </x-slot>

                    <livewire:show-' . $this->url . ' />
                </x-app-layout>
                ');
        }

        $modeloNombre = ucfirst($this->url);

        if ($this->crud) {
            // Crear el modelo con la primera letra en mayúscula
            Artisan::call('make:model ' . $modeloNombre);



            // Reemplazar use Jenssegers\Mongodb\Eloquent\Model en el modelo
            $modeloFile = app_path('Models/' . $modeloNombre . '.php');
            $modeloContents = file_get_contents($modeloFile);
            $modeloContents = str_replace('use Illuminate\Database\Eloquent\Model;', 'use Jenssegers\Mongodb\Eloquent\Model;', $modeloContents);
            file_put_contents($modeloFile, $modeloContents);

            // Obtenemos el contenido actual del modelo
            $modeloContents = file_get_contents($modeloFile);

            // Añadimos el $fillable y $collection al modelo
            $fillableFields = array_keys(array_column($this->datos, null, 'dato'));
            $additionalFields = ['empresa_id', 'user_id'];
            $fillableFields = array_merge($fillableFields, $additionalFields);
            $fillableString = "'" . implode("',\n        '", $fillableFields) . "'";
            $newModelContent = "    protected \$fillable = [\n        $fillableString,\n    ];\n\n    protected \$collection = '$this->url';\n public function empresa() { return \$this->belongsTo(Empresas::class,'empresa_id'); } \n public function usuario() { return \$this->belongsTo(User::class,'user_id'); }";

            // Reemplazamos o agregamos el contenido del modelo
            if (strpos($modeloContents, 'use HasFactory;') !== false) {
                $modeloContents = str_replace('use HasFactory;', "use HasFactory;\n\n$newModelContent\n", $modeloContents);
            } else {
                $modeloContents = preg_replace('/class ' . $modeloNombre . ' extends Model\s*\{/', "class $modeloNombre extends Model\n{\n    use HasFactory;\n\n$newModelContent\n", $modeloContents);
            }

            // Guardamos los cambios en el archivo del modelo
            file_put_contents($modeloFile, $modeloContents);
        }



        // Guarda la ruta actual
        $workingDirectory = getcwd();

        // Cambia a la carpeta raíz del proyecto Laravel
        chdir(base_path());

        // Construye el comando de Artisan
        $componentName = 'Show' . ucfirst($this->url);
        $command = 'php artisan make:livewire ' . $componentName;

        $className = "Show" . $modeloNombre;

        // Ejecuta el comando
        exec($command, $output, $returnVar);

        // Vuelve a la ruta original
        chdir($workingDirectory);


        // Ruta del archivo de la vista Livewire recién creado
        $viewPath = resource_path('views/livewire/show-' . strtolower($this->url) . '.blade.php');

        // Contenido que quieres agregar en la vista
        if ($this->crud) {
            $contentToAdd = <<<EOD
            <div x-data="{
                nuevo: @entangle('nuevo'),
                editar: @entangle('editar'),
                ver: @entangle('ver'),
                eliminar: false,
                closeModal() {
                    if (this.nuevo) {
                        this.nuevo = false;
                    }
                    if (this.editar) {
                        this.editar = false;
                    }
                    if (this.ver) {
                        this.ver = false;
                    }
                }
            }" @keydown.escape="closeModal" tabindex="0" class="h-full w-full md:my-2">
                <x-contenedor>
                    {{-- Carga --}}
                    @include('components/loading')

                    <x-tabla-crud>
                        <x-slot name="titulo"> {{ \$nombreCrud }} </x-slot>
                        <x-slot name="subtitulo"> Descripcion de {{ \$nombreCrud }} </x-slot>
                        <x-slot name="boton">Nuevo</x-slot>
                        <x-slot name="filtro"></x-slot>
                        <x-slot name="tabla">
                            {{-- Tabla lista --}}
                            <x-table>
                                <x-slot name="head">
                                    <x-tr class="font-semibold">
                                        <th class="py-6"></th>

                                        $this->dynamicTh

                                    </x-tr>
                                </x-slot>

                                <x-slot name="bodytable">
                                    @foreach (\$consulta as \$item)
                                        <x-tr x-data="{ openOption: false }">
                                            <x-td class="w-16">
                                                <input type="checkbox" wire:model.defer="eliminarItem" x-on:click="eliminar=true"
                                                    value="{{ \$item->id }}"
                                                    class="ml-4 border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                            </x-td>

                                            $this->dynamicTd

                                            <x-td wire:click="ver('{{ \$item->id }}')">
                                            {{\$item->palabra}}
                                            </x-td>

                                            <x-td wire:click="ver('{{ \$item->id }}')">
                                                @if(\$item->respuestas )
                                                @foreach (\$item->respuestas as \$itemRespuesta)
                                                <div
                                                    class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-xs flex align-middle capitalize">
                                                    {{ \$itemRespuesta->respuesta }}
                                                </div>
                                                @endforeach
                                                @endif
                                            </x-td>
                                            <x-td class="py-3 w-16">
                                                <x-menu-option-table x-on:click="openOption=!openOption" />
                                                <div x-cloak x-show="openOption" @click.away="openOption = false"
                                                    class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
                                                    <x-boton-menu x-on:click="openOption=false"
                                                        wire:click="ver('{{ \$item->id }}')">Ver</x-boton-menu>
                                                    <x-boton-menu x-on:click="openOption=false"
                                                        wire:click="editar('{{ \$item->id }}')">Editar</x-boton-menu>
                                                    <x-boton-menu x-on:click="openOption=false"
                                                        wire:click="eliminar('{{ \$item->id }}')">Eliminar</x-boton-menu>
                                                </div>
                                            </x-td>
                                        </x-tr>
                                    @endforeach
                                </x-slot>
                                <x-slot name="link">
                                    {{ \$consulta->links() }}
                                </x-slot>
                            </x-table>
                        </x-slot>
                    </x-tabla-crud>

                    {{-- Modal añadir --}}
                    <x-modal-crud x-show="nuevo">
                        <x-slot name="titulo"> Crear {{ \$nombreCrud }} </x-slot>

                        <x-slot name="campos">

                                $this->dynamicInputs

                        </x-slot>

                        <x-slot name="botones">
                            <x-secondary-button wire:click="limpiarInput">
                                Cerrar
                            </x-secondary-button>
                            <x-primary-button wire:click="guardar">
                                Guardar
                            </x-primary-button>
                        </x-slot>

                    </x-modal-crud>

                    {{-- Modal editar --}}
                    <x-modal-crud x-cloak x-show="editar">
                        <x-slot name="titulo"> Editar {{ \$nombreCrud }} </x-slot>
                        @if (!empty(\$consultaVer))
                            <x-slot name="campos">

                                $this->dynamicInputs

                            </x-slot>
                            <x-slot name="botones">

                                <x-secondary-button wire:click="limpiarInput">Cerrar
                                </x-secondary-button>
                                <x-primary-button wire:click="actualizar('{{ \$consultaVer->id }}')">
                                    Guardar
                                </x-primary-button>

                            </x-slot>
                        @else
                            <x-slot name="campos">

                            </x-slot>
                            <x-slot name="botones">

                            </x-slot>
                        @endif

                    </x-modal-crud>

                    {{-- Modal ver --}}
                    <x-modal-crud x-show="ver">
                        <x-slot name="titulo"> Ver {{ \$nombreCrud }}</x-slot>

                        @if (!empty(\$consultaVer))
                            <x-slot name="campos">

                            $this->dynamicInputs

                            </x-slot>

                            <x-slot name="botones">
                                <x-secondary-button wire:click="limpiarInput">Cerrar</x-secondary-button>
                                <x-primary-button wire:click="editar('{{ \$consultaVer->id }}')">
                                    Editar
                                </x-primary-button>
                            </x-slot>
                        @else
                            <x-slot name="campos">
                            </x-slot>
                            <x-slot name="botones">
                            </x-slot>
                        @endif

                    </x-modal-crud>
                </x-contenedor>
            </div>
            EOD;
        } else {
            $contentToAdd = <<<EOD
            <div x-data="{
                nuevo: @entangle('nuevo'),
                editar: @entangle('editar'),
                ver: @entangle('ver'),
                eliminar: false,
                closeModal() {
                    if (this.nuevo) {
                        this.nuevo = false;
                    }
                    if (this.editar) {
                        this.editar = false;
                    }
                    if (this.ver) {
                        this.ver = false;
                    }
                }
            }" @keydown.escape="closeModal" tabindex="0" class="h-full w-full md:my-2">
                <x-contenedor>
                    {{-- Carga --}}
                    @include('components/loading')

                    <x-tabla-crud>
                        <x-slot name="titulo"> {{ \$nombreCrud }} </x-slot>
                        <x-slot name="subtitulo"> Descripcion de {{ \$nombreCrud }} </x-slot>
                        <x-slot name="boton">Nuevo</x-slot>
                        <x-slot name="filtro"></x-slot>
                        <x-slot name="tabla">
                            {{-- Tabla lista --}}
                            <x-table>
                                <x-slot name="head">
                                    <x-tr class="font-semibold">
                                        <th class="py-6"></th>
                                    </x-tr>
                                </x-slot>

                                <x-slot name="bodytable">

                                </x-slot>
                                <x-slot name="link">
                                </x-slot>
                            </x-table>
                        </x-slot>
                    </x-tabla-crud>

                    {{-- Modal añadir --}}
                    <x-modal-crud x-show="nuevo">
                        <x-slot name="titulo"> Crear {{ \$nombreCrud }} </x-slot>

                        <x-slot name="campos">



                        </x-slot>

                        <x-slot name="botones">
                            <x-secondary-button wire:click="limpiarInput">
                                Cerrar
                            </x-secondary-button>
                            <x-primary-button wire:click="guardar">
                                Guardar
                            </x-primary-button>
                        </x-slot>

                    </x-modal-crud>

                    {{-- Modal editar --}}
                    <x-modal-crud x-cloak x-show="editar">
                        <x-slot name="titulo"> Editar {{ \$nombreCrud }} </x-slot>
                        @if (!empty(\$consultaVer))
                            <x-slot name="campos">


                            </x-slot>
                            <x-slot name="botones">

                                <x-secondary-button wire:click="limpiarInput">Cerrar
                                </x-secondary-button>
                                <x-primary-button wire:click="actualizar('{{ \$consultaVer->id }}')">
                                    Guardar
                                </x-primary-button>

                            </x-slot>
                        @else
                            <x-slot name="campos">

                            </x-slot>
                            <x-slot name="botones">

                            </x-slot>
                        @endif

                    </x-modal-crud>

                    {{-- Modal ver --}}
                    <x-modal-crud x-show="ver">
                        <x-slot name="titulo"> Ver {{ \$nombreCrud }}</x-slot>

                        @if (!empty(\$consultaVer))
                            <x-slot name="campos">

                            </x-slot>

                            <x-slot name="botones">
                                <x-secondary-button wire:click="limpiarInput">Cerrar</x-secondary-button>
                                <x-primary-button wire:click="editar('{{ \$consultaVer->id }}')">
                                    Editar
                                </x-primary-button>
                            </x-slot>
                        @else
                            <x-slot name="campos">
                            </x-slot>
                            <x-slot name="botones">
                            </x-slot>
                        @endif

                    </x-modal-crud>
                </x-contenedor>
            </div>
            EOD;
        }

        // Escribe el contenido en el archivo de la vista
        file_put_contents($viewPath, $contentToAdd);


        // Ruta del archivo del controlador de la vista Livewire recién creado
        $controllerPath = app_path('Http/Livewire/' . $componentName . '.php');

        // Contenido que quieres agregar al controlador de la vista Livewire
        if ($this->crud) {
            $controllerContent = <<<EOD
        <?php
        namespace App\Http\Livewire;
        use App\Models\\$modeloNombre;
        use Illuminate\Support\Facades\Auth;
        use Jantinnerezo\LivewireAlert\LivewireAlert;
        use Livewire\Component;
        use Livewire\WithPagination;
        use Livewire\WithFileUploads;

        class $className extends Component
        {
            use WithFileUploads;
            use LivewireAlert;
            use WithPagination;
            public \$nombreCrud = '$modeloNombre';

            // MODALES
            public \$nuevo = false;
            public \$editar = false;
            public \$ver = false;

            // FILTROS
            public \$buscar;
            public \$user_id;
            public \$empresa_id;
            public \$eliminarItem = ['1'];

            // DATOS
            public \$consultaVer;

            $this->dynamicCampos

            public function getListeners()
            {
                return [
                    'confirmed',
                    'mensajeEnviado'
                ];
            }

            public function mensajeEnviado(\$empresa_id)
            {
                \$this->empresa_id= \$empresa_id->id;
            }

            public function mount()
            {
                \$user = Auth::user();
                \$this->user_id = \$user->id;
            }
            public function render()
            {
                if (empty(\$this->empresa_id)) {
                    \$this->empresa_id = config('app.empresa')->id;
                }
                \$buscar = \$this->buscar;

                \$consulta = $modeloNombre::query()
                    ->when(!empty(\$buscar), function (\$query) use (\$buscar) {
                        return \$query->where('nombre', 'LIKE', '%' . \$buscar . '%');
                    })
                    ->where('empresa_id',\$this->empresa_id)->paginate(20);

                return view('livewire.show-$modeloNombre', [
                    'consulta' => \$consulta,
                ]);
            }

            //CREAR
            public function guardar()
            {
                \$validatedData = \$this->validate([
                    $this->dynamicRules
                    'empresa_id' => ['required'],
                    'user_id' => ['required'],
                ]);

                $modeloNombre::create(\$validatedData);

                \$this->alert('success', 'Creado correctamente!', [
                    'position' => 'top'
                ]);

                \$this->nuevo = false;
                \$this->limpiarInput();
            }

            //VER
            public function ver(\$id)
            {
                \$this->consultaVer = $modeloNombre::find(\$id);

                $this->dynamicEdit

                \$this->ver = true;
            }

            //ELIMINAR
            public function eliminar(\$id)
            {
                \$this->eliminarItem[] = \$id;
                \$this->alert('warning', '¿Eliminar?', [
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
                $modeloNombre::whereIn('_id', \$this->eliminarItem)->delete();
                \$this->alert('success', 'Eliminado correctamente!', [
                    'position' => 'top'
                ]);
                \$this->eliminarItem = ['1'];
            }

            //VER EDITAR
            public function editar(\$id)
            {
                \$this->consultaVer = $modeloNombre::find(\$id);

                $this->dynamicEdit

                \$this->editar = true;
            }

            //ACTUALIZAR
            public function actualizar(\$id)
            {
                \$validatedData = \$this->validate([

                    $this->dynamicRules

                ]);

                $modeloNombre::find(\$id)->update(\$validatedData);

                \$this->editar = false;
                \$this->alert('success', 'Actualizado correctamente!', [
                    'position' => 'top'
                ]);

                \$this->limpiarInput();
            }

            public function limpiarInput()
            {
                $this->dynamicLimpiar
            }

        }
        EOD;
        } else {
            $controllerContent = <<<EOD
            <?php
            namespace App\Http\Livewire;
            use Illuminate\Support\Facades\Auth;
            use Jantinnerezo\LivewireAlert\LivewireAlert;
            use Livewire\Component;
            use Livewire\WithPagination;
            use Livewire\WithFileUploads;

            class $className extends Component
            {
                use WithFileUploads;
                use LivewireAlert;
                use WithPagination;
                public \$nombreCrud = '$modeloNombre';

                // MODALES
                public \$nuevo = false;
                public \$editar = false;
                public \$ver = false;

                // FILTROS
                public \$buscar;
                public \$user_id;
                public \$empresa_id;
                public \$eliminarItem = ['1'];

                // DATOS
                public \$consultaVer;


                public function getListeners()
                {
                    return [
                        'confirmed',
                        'mensajeEnviado'
                    ];
                }

                public function mensajeEnviado(\$empresa_id)
                {
                    \$this->empresa_id= \$empresa_id->id;
                }
                public function mount()
                {
                    \$user = Auth::user();
                    \$this->user_id = \$user->id;
                }
                public function render()
                {
                    if (empty(\$this->empresa_id)) {
                        \$this->empresa_id = config('app.empresa')->id;
                    }
                    \$buscar = \$this->buscar;

                    return view('livewire.show-$modeloNombre');
                }

                //CREAR
                public function guardar()
                {
                    \$validatedData = \$this->validate([
                        'empresa_id' => ['required'],
                        'user_id' => ['required'],
                    ]);

                    \$this->alert('success', 'Creado correctamente!', [
                        'position' => 'top'
                    ]);

                    \$this->nuevo = false;
                    \$this->limpiarInput();
                }

                //VER
                public function ver(\$id)
                {

                    \$this->ver = true;
                }

                //ELIMINAR
                public function eliminar(\$id)
                {
                    \$this->eliminarItem[] = \$id;
                    \$this->alert('warning', '¿Eliminar?', [
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
                    \$this->alert('success', 'Eliminado correctamente!', [
                        'position' => 'top'
                    ]);
                    \$this->eliminarItem = ['1'];
                }

                //VER EDITAR
                public function editar(\$id)
                {
                    \$this->ver = false;

                    \$this->editar = true;
                }

                //ACTUALIZAR
                public function actualizar(\$id)
                {
                    \$validatedData = \$this->validate([]);

                    \$this->editar = false;

                    \$this->alert('success', 'Actualizado correctamente!', [
                        'position' => 'top'
                    ]);

                    \$this->limpiarInput();
                }

                public function limpiarInput()
                {
                    \$this->ver = false;
                    \$this->editar = false;
                    \$this->nuevo = false;
                }

            }
            EOD;
        }


        // Escribe el contenido en el archivo del controlador de la vista Livewire
        file_put_contents($controllerPath, $controllerContent);

        // Limpiar la cache
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:cache');
        Artisan::call('config:cache');

        $this->alert('success', 'Creado correctamente!', [
            'position' => 'top'
        ]);
        $this->nuevo = false;
        $this->datos = [];
        $this->limpiarInput();
    }

    //CAMBIAR ESTADO
    public function cambiarEstado($id, $estado)
    {
        $estado = $estado ? 0 : 1;

        $actualizar = Submodulos::find($id)->update(['estado' => $estado]);

        if ($actualizar && $estado == 1) {
            $this->alert('success', 'Modulo activo!', [
                'position' => 'top'
            ]);
        }
    }

    //VER
    public function ver($id)
    {
        $this->consultaVer = Submodulos::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->modulo_id = $this->consultaVer->modulo->nombre;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->url = $this->consultaVer->url;
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
        $sub = Submodulos::whereIn('_id', $this->eliminarItem)->first();
        $this->url = $sub->url;
        // Inicia la transacción
        DB::beginTransaction();

        try {

            // Eliminar el Livewire component si existe
            $componentName = 'Show' . ucfirst($this->url);

            // Guarda la ruta actual
            $workingDirectory = getcwd();

            // Cambia a la carpeta raíz del proyecto Laravel
            chdir(base_path());

            //dd($componentName);
            $command = 'yes | php artisan livewire:delete ' . $componentName;
            exec($command, $output, $returnVar);


            // Vuelve a la ruta original
            chdir($workingDirectory);


            // Eliminar la ruta /url en routes/web.php
            $routeCode = "Route::get('/" . $this->url . "', [MenuController::class, '$this->url'])->name('" . $this->url . "');\n";
            $routesFile = base_path('routes/web.php');
            $routesContents = file_get_contents($routesFile);
            $routesContents = str_replace($routeCode, '', $routesContents);
            file_put_contents($routesFile, $routesContents);

            // Eliminar el método Show$this->url() en MenuController si existe
            $menuControllerFile = app_path('Http/Controllers/MenuController.php');
            $menuControllerContents = file_get_contents($menuControllerFile);
            $methodCode = <<<EOT

    public function $this->url()
    {
        return view('menu.$this->url');
    }
EOT;
            $menuControllerContents = str_replace($methodCode, '', $menuControllerContents);
            file_put_contents($menuControllerFile, $menuControllerContents);

            // Eliminar el archivo $this->url.blade.php en views/menu/ si existe
            $nombreBladePath = resource_path("views/menu/$this->url.blade.php");
            if (File::exists($nombreBladePath)) {
                File::delete($nombreBladePath);
            }

            // Eliminar el modelo si existe
            $modeloFile = app_path('Models/' . ucfirst($this->url) . '.php');
            if (File::exists($modeloFile)) {
                File::delete($modeloFile);
            }

            // Commit: confirma la transacción si todo es exitoso
            DB::commit();

            $this->alert('success', 'Eliminado correctamente!', [
                'position' => 'top'
            ]);
            $this->eliminarItem = ['1'];
        } catch (\Exception $e) {
            // Rollback: deshace todas las operaciones realizadas en la transacción
            DB::rollback();

            // Manejo del error, puedes agregar aquí cualquier código para notificar o registrar el error.
            $this->alert('error', 'Error al eliminar!', [
                'position' => 'top'
            ]);
        }



        $sub->delete();

        $this->alert('success', 'Eliminado correctamente!', [
            'position' => 'top'
        ]);
        $this->eliminarItem = ['1'];
    }

    //VER EDITAR
    public function editar($id)
    {

        $this->consultaVer = Submodulos::find($id);
        $this->nombre = $this->consultaVer->nombre;
        $this->modulo_id = $this->consultaVer->modulo_id;
        $this->descripcion = $this->consultaVer->descripcion;
        $this->estado = $this->consultaVer->estado;
        $this->url = $this->consultaVer->url;
        $this->editar = true;
    }

    //ACTUALIZAR
    public function actualizar($id)
    {
        $this->usuario_actualizador = Auth::user()->id;
        $validatedData = $this->validate([
            'nombre' => 'required',
            'modulo_id' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
            'usuario_actualizador' => 'required',
            'url' => 'required'
        ]);

        Submodulos::find($id)->update($validatedData);


        $this->editar = false;
        $this->alert('success', 'Actualizado correctamente!', [
            'position' => 'top'
        ]);

        $this->limpiarInput();
    }

    public function limpiarInput()
    {
        $this->nombre = '';
        $this->modulo_id = '';
        $this->descripcion = '';
        $this->estado = 1;
        $this->url = '';
    }
}
