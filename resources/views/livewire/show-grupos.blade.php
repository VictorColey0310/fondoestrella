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
            <x-slot name="titulo"> {{ $nombreCrud }} </x-slot>
            <x-slot name="subtitulo"> Descripcion de {{ $nombreCrud }} </x-slot>
            <x-slot name="boton">Nuevo</x-slot>
            <x-slot name="filtro"></x-slot>
            <x-slot name="tabla">
                {{-- Tabla lista --}}
                <x-table>
                    <x-slot name="head">
                        <x-tr class="font-semibold">
                            <th class="py-6"></th>
                            <th>Nombre</th>
                            <th>Criterios</th>
                            <th></th>
                        </x-tr>
                    </x-slot>

                    <x-slot name="bodytable">
                        @forelse ($consultaGrupo as $item)
                        <x-tr x-data="{ openOption: false }">
                            <x-td class="w-16">
                                <input type="checkbox" wire:model.defer="eliminarItem" x-on:click="eliminar=true"
                                    value="{{ $item->id }}"
                                    class="ml-4 border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                            </x-td>
                            <x-td>
                                {{ $item->nombre ?? '' }}
                            </x-td>
                            <x-td>
                                <div class="flex flex-wrap space-x-1 min-w-fit">
                                    @foreach ($item->criterios as $criterio)
                                        <x-chip>{{ $criterio->nombre }}</x-chip>
                                    @endforeach
                                </div>
                            </x-td>
                            <x-td class="py-3 w-16">
                                <x-menu-option-table x-on:click="openOption=!openOption" />
                                <div x-cloak x-show="openOption" @click.away="openOption = false"
                                    class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
                                    <x-boton-menu x-on:click="openOption=false" wire:click="ver('{{ $item->id }}')">Ver</x-boton-menu>
                                    <x-boton-menu x-on:click="openOption=false" wire:click="editar('{{ $item->id }}')">Editar</x-boton-menu>
                                    <x-boton-menu x-on:click="openOption=false" wire:click="eliminar('{{ $item->id }}')">Eliminar</x-boton-menu>
                                </div>
                            </x-td>
                        </x-tr>
                    @empty
                    @endforelse
                    </x-slot>

                    <x-slot name="link">
                    </x-slot>
                </x-table>
            </x-slot>
        </x-tabla-crud>

        {{-- Modal añadir --}}
        <x-modal-crud x-show="nuevo">
            <x-slot name="titulo"> Crear {{ $nombreCrud }} </x-slot>

            <x-slot name="campos">
                <x-input-doble>
                    <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text" value="" placeholder="Nombre" maxlength="100" />
                </x-input-doble>

                <div>
                    <div class="block text-gray-700 text-sm font-semibold mb-2">Criterios</div>

                    <div x-data="{ mostrarConsulta: false }" @click.away="mostrarConsulta = false">
                        <x-input-search name="buscar" type="search" wire="buscarItem"
                            x-on:click="mostrarConsulta = true" id="buscar" placeholder="Buscar criterios" />
                        <div x-transition x-show="mostrarConsulta" class="overflow-y-auto max-h-28 ">
                            <div class="w-full border rounded border-gray-200">
                                @foreach ($consultaCriterio as $itemCriterio)
                                    <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100 "
                                        wire:click="selectCriterio('{{ $itemCriterio }}')">{{ $itemCriterio->nombre }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap space-x-1 w-full">
                        @if ($criterios)
                            @foreach ($criterios as $item)
                                <div class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle">
                                    {{ $item['nombre'] ?? '' }}
                                    <span class="cursor-pointer my-auto capitalize" wire:click="deleteCriterio('{{ $item['_id'] }}')">@svg('heroicon-m-x-mark', 'w-4')</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
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
            <x-slot name="titulo"> Editar {{ $nombreCrud }} </x-slot>
            @if (!empty($consultaVer))
                <x-slot name="campos">
                    <x-input-doble>
                        <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text" value="" placeholder="Nombre" maxlength="100" />
                    </x-input-doble>

                    <div>
                        <div class="block text-gray-700 text-sm font-semibold mb-2">Criterios</div>

                        <div x-data="{ mostrarConsulta: false }" @click.away="mostrarConsulta = false">
                            <x-input-search name="buscar" type="search" wire="buscarItem"
                                x-on:click="mostrarConsulta = true" id="buscar" placeholder="Buscar criterios" />
                            <div x-transition x-show="mostrarConsulta" class="overflow-y-auto max-h-28 ">
                                <div class="w-full border rounded border-gray-200">
                                    @foreach ($consultaCriterio as $itemCriterio)
                                        <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100 "
                                            wire:click="selectCriterio('{{ $itemCriterio }}')">{{ $itemCriterio->nombre }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap space-x-1 w-full">
                            @if ($criterios)
                                @foreach ($criterios as $item)
                                    <div
                                        class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle">
                                        {{ $item['nombre'] ?? '' }}
                                        <span class="cursor-pointer my-auto capitalize"
                                            wire:click="deleteCriterio('{{ $item['_id'] }}')">@svg('heroicon-m-x-mark', 'w-4')</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </x-slot>
                <x-slot name="botones">

                    <x-secondary-button wire:click="limpiarInput">Cerrar
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

                    <x-input-doble>
                        <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text" value="" placeholder="Nombre" maxlength="100" disabled/>
                    </x-input-doble>

                    <div class="block text-gray-700 text-sm font-semibold mb-2">Criterios</div>

                    <div class="flex flex-wrap gap-1 min-w-fit">
                        @foreach ($consultaVer->criterios as $criterio)
                            <x-chip>{{ $criterio->nombre }}</x-chip>
                        @endforeach
                    </div>
                </x-slot>

                <x-slot name="botones">
                    <x-secondary-button wire:click="limpiarInput">Cerrar</x-secondary-button>
                    <x-primary-button wire:click="editar('{{ $consultaVer->id }}')">
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
