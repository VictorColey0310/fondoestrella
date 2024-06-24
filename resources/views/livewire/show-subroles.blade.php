<div x-data="{
    nuevo: @entangle('nuevo'),
    editar: @entangle('editar'),
    ver: @entangle('ver'),
    eliminar: false,
    download: false,
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
            <x-slot name="titulo"> Roles </x-slot>
            <x-slot name="subtitulo"> Descripcion de Roles </x-slot>
            <x-slot name="filtro"></x-slot>
            <x-slot name="boton">Nuevo</x-slot>
            <x-slot name="tabla">
                {{-- Tabla lista --}}
                <x-table>
                    <x-slot name="head">
                        <x-tr class="font-semibold">
                            <th class="py-6"></th>
                            <th class="">Nombre</th>
                            <th class="">Descripción</th>
                            <th class="">SubModulos activos</th>
                            <th class="">Creado</th>
                            <th class=""></th>
                        </x-tr>
                    </x-slot>

                    <x-slot name="bodytable">
                        @foreach ($consulta as $item)
                            <x-tr x-data="{ openOption: false }">
                                <x-td class="w-16">
                                    <input type="checkbox" wire:model.defer="eliminarItem" x-on:click="eliminar=true"
                                        value="{{ $item->id }}"
                                        class="ml-4 border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                </x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">{{ $item->nombre ?? '' }}</x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">{{ $item->descripcion ?? '' }}</x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">
                                    @if (!empty($item->submodulos))
                                        <div class="flex flex-wrap space-x-1 min-w-fit">

                                            @foreach ($item->submodulos as $itemTabla)
                                                <div
                                                    class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-xs flex align-middle capitalize">
                                                    {{ $itemTabla->nombre }}
                                                </div>
                                            @endforeach

                                        </div>
                                    @endif
                                </x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">
                                    {{ $item->user->name ?? '' }}
                                </x-td>


                                <x-td class="py-3 w-16">
                                    <x-menu-option-table x-on:click="openOption=!openOption" />
                                    <div x-cloak x-show="openOption" @click.away="openOption = false"
                                        class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
                                        <x-boton-menu x-on:click="openOption=false"
                                            wire:click="ver('{{ $item->id }}')">Ver</x-boton-menu>
                                        <x-boton-menu x-on:click="openOption=false"
                                            wire:click="editar('{{ $item->id }}')">Editar</x-boton-menu>
                                        <x-boton-menu x-on:click="openOption=false"
                                            wire:click="eliminar('{{ $item->id }}')">Eliminar</x-boton-menu>
                                    </div>
                                </x-td>
                            </x-tr>
                        @endforeach
                    </x-slot>
                    <x-slot name="link">
                        {{ $consulta->links() }}
                    </x-slot>
                </x-table>
            </x-slot>
        </x-tabla-crud>

        {{-- Modal añadir --}}
        <x-modal-crud x-show="nuevo">
            <x-slot name="titulo"> Crear Rol </x-slot>
            <x-slot name="campos">

                <x-input-doble>
                    <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text"
                        value="" placeholder="Rol" maxlength="40" />

                    <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                        value="" type="text" placeholder="Descripción" maxlength="100" />
                </x-input-doble>

                <div class="block text-gray-700 text-sm font-semibold mb-2">SubModulos</div>

                <div x-data="{ mostrarConsultaModulos: false }" @click.away="mostrarConsultaModulos = false">
                    <x-input-search name="buscar" type="search" wire="buscarItem"
                        x-on:click="mostrarConsultaModulos = true" id="buscar" placeholder="Buscar Submodulos" />
                    <div x-transition x-show="mostrarConsultaModulos" class="overflow-y-auto max-h-28 ">
                        <div class="w-full border rounded border-gray-200">
                            @foreach ($consultaModulos as $itemNuevo)
                                <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100 "
                                    wire:click="selectModulo('{{ $itemNuevo }}')">{{ $itemNuevo->nombre ?? '' }} -
                                    {{ $itemNuevo->modulo->nombre ?? '' }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <div class="flex flex-wrap space-x-1 w-full">
                    @if ($modulos)
                        @foreach ($modulos as $item)
                            <div class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle">
                                {{ $item['nombre'] ?? '' }}
                                <span class="cursor-pointer my-auto capitalize"
                                    wire:click="deleteModulo('{{ $item['_id'] }}')">@svg('heroicon-m-x-mark', 'w-4')</span>
                            </div>
                        @endforeach
                    @endif
                </div>


            </x-slot>
            <x-slot name="botones">
                <x-secondary-button x-on:click="nuevo = false" wire:click="limpiarInput">
                    Cerrar
                </x-secondary-button>
                <x-primary-button x-on:click="nuevo = true" wire:click="guardar()">
                    Guardar
                </x-primary-button>
            </x-slot>

        </x-modal-crud>

        {{-- Modal editar --}}
        <x-modal-crud x-show="editar">
            <x-slot name="titulo"> Editar Rol </x-slot>

            @if (!empty($consultaVer))
                <x-slot name="campos">

                    <x-input-doble>

                        <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text"
                            placeholder="" maxlength="40" value="" />

                        <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                            type="text" placeholder="Descripción" maxlength="100" value="" />

                    </x-input-doble>

                    <div class="block text-gray-700 text-sm font-semibold mb-2">SubModulos</div>

                    <div x-data="{ mostrarConsultaModulos: false }" @click.away="mostrarConsultaModulos = false">
                        <x-input-search name="buscar" type="search" wire="buscarItem"
                            x-on:click="mostrarConsultaModulos = true" id="buscar" placeholder="Buscar modelos" />
                        <div x-transition x-show="mostrarConsultaModulos" class="overflow-y-auto  max-h-28 ">
                            <div class="w-full border rounded border-gray-200">
                                @foreach ($consultaModulos as $itemNuevo)
                                    <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100"
                                        wire:click="selectModulo('{{ $itemNuevo }}')">{{ $itemNuevo->nombre }} -
                                        {{ $itemNuevo->modulo->nombre ?? '' }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap space-x-1 w-full">
                        @if ($modulos)
                            @foreach ($modulos as $item)
                                <div
                                    class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle capitalize">
                                    {{ $item['nombre'] ?? '' }}
                                    <span class="cursor-pointer my-auto"
                                        wire:click="deleteModulo('{{ $item['_id'] }}')">@svg('heroicon-m-x-mark', 'w-4')</span>
                                </div>
                            @endforeach
                        @endif
                    </div>


                </x-slot>

                <x-slot name="botones">
                    <x-secondary-button x-on:click="editar=false" wire:click="limpiarInput">Cerrar
                    </x-secondary-button>
                    <x-primary-button x-on:click="editar = true" wire:click="actualizar('{{ $consultaVer->id }}')">
                        Guardar
                    </x-primary-button>
                </x-slot>
            @else
                <x-slot name="campos"></x-slot>
                <x-slot name="botones"></x-slot>
            @endif

        </x-modal-crud>

        {{-- Modal ver --}}
        <x-modal-crud x-show="ver">
            <x-slot name="titulo"> Ver rol </x-slot>
            @if (!empty($consultaVer))

                <x-slot name="campos">

                    <x-input-doble>
                        <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre"
                            type="text" disabled placeholder="" maxlength="0" value="" />

                        <x-input-with-label wire="descripcion" label="Descripción" name="descripcion"
                            id="descripcion" disabled type="text" placeholder="Descripción" maxlength="0"
                            value="" />
                    </x-input-doble>

                    <div class="block text-gray-700 text-sm font-semibold mb-2 ">SubModulos</div>
                    @if (!empty($modulosVer))
                        <div class="flex flex-wrap space-x-1 w-56">

                            @foreach ($modulosVer as $itemVer)
                                <div class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-sm flex align-middle capitalize">
                                    {{ $itemVer->nombre }}</div>
                            @endforeach

                        </div>
                    @else
                        <div class="text-gray-300 text-xs">Sin modulos</div>
                    @endif

                </x-slot>

                <x-slot name="botones">
                    <x-secondary-button x-on:click="ver=false" wire:click="limpiarInput">Cerrar</x-secondary-button>
                    <x-primary-button x-on:click="ver = false" wire:click="editar('{{ $consultaVer->id }}')">
                        Editar
                    </x-primary-button>
                </x-slot>
            @else
                <x-slot name="campos"></x-slot>
                <x-slot name="botones"></x-slot>
            @endif

        </x-modal-crud>
    </x-contenedor>
</div>
