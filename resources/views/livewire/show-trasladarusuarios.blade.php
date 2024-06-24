<div x-data="{
    nuevo: @entangle('nuevo'),
    editar: @entangle('editar'),
    ver: @entangle('ver'),
    eliminar: false,
    download: false,
    exportar: false,
    modalExportar: false,
    trasladar: false,
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
            <x-slot name="titulo"> {{ $nombreCrud }} </x-slot>
            <x-slot name="subtitulo"> Descripcion de {{ $nombreCrud }} </x-slot>
            <x-slot name="boton">Nuevo</x-slot>
            <x-slot name="filtro">
                <div class="flex flex-col gap-4">
                    <select name="filtro_empresa_id" wire:model="filtro_empresa_id" id="filtro_empresa_id"
                        class="mx-auto text-sm border border-gray-300 rounded-md w-full appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Filtro por empresa</option>
                        @foreach ($consultaEmpresas as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @if (!empty($consultaPlanes))
                        <select name="filtro_plan_id" wire:model="filtro_plan_id" id="filtro_plan_id"
                            class="mx-auto text-sm border border-gray-300 rounded-md w-full appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($consultaPlanes as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </x-slot>
            <x-slot name="tabla">
                <div class="flex justify-start items-center gap-10">
                    <div class="flex items-center gap-4 mx-auto p-4 border rounded-lg bg-gray-100 shadow m-4 ">
                        <div>
                            <select name="trasladar_empresa_id" wire:model="trasladar_empresa_id"
                                id="trasladar_empresa_id"
                                class="mx-auto text-sm border border-gray-300 rounded-md w-full appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Trasladar a empresa</option>
                                @foreach ($consultaEmpresas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="trasladar_plan_id" wire:model.defer="trasladar_plan_id" id="trasladar_plan_id"
                                class="mx-auto text-sm border border-gray-300 rounded-md w-full appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">Trasladar a plan</option>
                                @if (!empty($consultaPlanes1))
                                    @foreach ($consultaPlanes1 as $item1)
                                        <option value="{{ $item1->id }}">{{ $item1->nombre }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div x-show="trasladar">
                            <x-primary-button wire:click="trasladarUsers">Transladar</x-primary-button>
                        </div>
                    </div>
                </div>
                {{-- Tabla lista --}}
                <x-table>
                    <x-slot name="head">
                        <x-tr class="font-semibold">
                            <th class="py-6">
                                <input x-on:click="eliminar=true,trasladar=true,exportar=true" type="checkbox"
                                    wire:model="checkAll" wire:click="toggleCheckAll" id="checkAll"
                                    class="ml-4 border-gray-100 shadow shadow-gray-400 cursor-pointer rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                            </th>
                            <th class="">
                                Nombre
                            </th>
                            <th class="">Documento</th>
                            <th class="">Correo</th>
                            <th class="">Empresa</th>
                            <th class="">Telefono</th>
                            <th class="">Rol</th>
                            <th class="">Plan</th>
                            <th class="">CV</th>
                            <th class=""></th>
                        </x-tr>
                    </x-slot>

                    <x-slot name="bodytable">
                        @if ($consulta)
                            @foreach ($consulta as $item)
                                @if (!$item->rol->rol_administrador)
                                    <x-tr x-data="{ openOption: false }">
                                        <x-td class="w-16">
                                            <input type="checkbox" wire:model.defer="eliminarItem"
                                                x-on:click="eliminar=true,trasladar=true,exportar=true"
                                                value="{{ $item->id }}"
                                                class="ml-4 border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                        </x-td>

                                        <x-td>
                                            <a href="{{ route('ficha', ['user_id' => $item->id]) }}">
                                                {{ $item->name ?? '' }}
                                                {{ $item->segundo_name ?? '' }}
                                                {{ $item->primer_apellido ?? '' }}
                                                {{ $item->segundo_apellido ?? '' }}
                                            </a>
                                        </x-td>
                                        <x-td class="w-32">
                                            <a href="{{ route('ficha', ['user_id' => $item->id]) }}">
                                                {{ $item->documento ?? '' }}
                                            </a>
                                        </x-td>
                                        <x-td>
                                            <a href="{{ route('ficha', ['user_id' => $item->id]) }}">
                                                {{ $item->email ?? '' }}
                                            </a>
                                        </x-td>
                                        <x-td>
                                            @if (!empty($item->empresas))
                                                <div class="flex flex-wrap space-x-1 min-w-fit">

                                                    @foreach ($item->empresas as $itemTabla)
                                                        <div
                                                            class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-xs flex align-middle capitalize">
                                                            {{ $itemTabla->nombre }}
                                                        </div>
                                                    @endforeach

                                                </div>
                                            @endif
                                        </x-td>
                                        <x-td class="w-32">
                                            {{ $item->telefono ?? '' }}</x-td>
                                        <x-td> {{ $item->rol->nombre ?? '' }}</x-td>
                                        <x-td>


                                            @foreach ($item->planes as $plan)
                                                <div
                                                    class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-xs flex align-middle capitalize">
                                                    {{ $plan->nombre ?? '' }}</div>
                                            @endforeach




                                        </x-td>
                                        <x-td><a href="{{ route('cv', ['user_id' => $item->id]) }}">
                                                <x-primary-button>Ver hoja de vida</x-primary-button>
                                            </a> </x-td>

                                        <x-td class="py-3 w-16">
                                            {{-- <x-menu-option-table x-on:click="openOption=!openOption" />
                                    <div x-cloak x-show="openOption" @click.away="openOption = false"
                                        class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
                                        <x-boton-menu x-on:click="openOption=false"
                                            wire:click="enviarInvitacion('{{ $item->id }}')">Reenviar
                                            credenciales</x-boton-menu>
                                        <x-boton-menu x-on:click="openOption=false"
                                            wire:click="ver('{{ $item->id }}')">Ver</x-boton-menu>
                                        <x-boton-menu x-on:click="openOption=false"
                                            wire:click="editar('{{ $item->id }}')">Editar</x-boton-menu>
                                        <x-boton-menu x-on:click="openOption=false"
                                            wire:click="eliminar('{{ $item->id }}')">Eliminar</x-boton-menu>
                                    </div> --}}
                                        </x-td>
                                    </x-tr>
                                @endif
                            @endforeach
                        @endif
                    </x-slot>
                    <x-slot name="link">
                        {{-- $consulta->links() --}}

                    </x-slot>
                </x-table>
            </x-slot>
        </x-tabla-crud>

        {{-- Modal añadir --}}
        <x-modal-crud x-show="nuevo">
            <x-slot name="titulo"> Crear {{ $nombreCrud }} </x-slot>

            <x-slot name="campos">



            </x-slot>

            <x-slot name="botones">
                <x-secondary-button x-on:click="nuevo = false">
                    Cerrar
                </x-secondary-button>
                <x-primary-button wire:click="guardar">
                    Guardar
                </x-primary-button>
            </x-slot>

        </x-modal-crud>

        {{-- Modal editar --}}
        <x-modal-crud x-cloak x-show="editar">
            <x-slot name="titulo"> Editar {{ $nombreCrud }} </x-slot>
            @if (!empty($consultaVer))
                <x-slot name="campos">


                </x-slot>
                <x-slot name="botones">

                    <x-secondary-button x-on:click="editar=false" wire:click="limpiarInput">Cerrar
                    </x-secondary-button>
                    <x-primary-button wire:click="actualizar('{{ $consultaVer->id }}')">
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
            <x-slot name="titulo"> Ver {{ $nombreCrud }}</x-slot>

            @if (!empty($consultaVer))
                <x-slot name="campos">

                </x-slot>

                <x-slot name="botones">
                    <x-secondary-button x-on:click="ver=false" wire:click="limpiarInput">Cerrar</x-secondary-button>
                    <x-primary-button x-on:click="ver = false" wire:click="editar('{{ $consultaVer->id }}')">
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

        <x-modal-crud x-show="modalExportar">
            <x-slot name="titulo"> Exportar</x-slot>

            <x-slot name="campos">
                <x-input-doble>
                    <x-primary-button wire:click="Exformato()">
                        Formato experiencia laboral.
                    </x-primary-button>
                    <x-primary-button wire:click="Exinformacion()">
                        Información principal.
                    </x-primary-button>
                </x-input-doble>
            </x-slot>

            <x-slot name="botones">
                <x-secondary-button x-on:click="modalExportar=false">
                    Cerrar
                </x-secondary-button>

            </x-slot>

        </x-modal-crud>
    </x-contenedor>
</div>
