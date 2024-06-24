<div x-data="{
    nuevo: @entangle('nuevo'),
    editar: @entangle('editar'),
    ver: @entangle('ver'),
    eliminar: false,
    download: false,

}" class="h-full w-full md:my-2">
    <x-contenedor>
        {{-- Carga --}}
        @include('components/loading')

        <x-tabla-crud>
            <x-slot name="titulo"> Ciudades </x-slot>
            <x-slot name="subtitulo"> Estas ciudades son sincronizadas directamente desde <a
                    href="https://www.datos.gov.co/Mapas-Nacionales/Departamentos-y-municipios-de-Colombia"
                    class="font-regular italic text-gray-400" target="_blank">datos.gov.co</a></x-slot>
            <x-slot name="filtro"></x-slot>
            <x-slot name="boton">Sincronizar</x-slot>
            <x-slot name="tabla">
                {{-- Tabla lista --}}
                <x-table>
                    <x-slot name="head">
                        <x-tr class="font-semibold">
                            <th class="py-6"></th>
                            <th class=" ">Ciudad</th>
                            <th class=" ">Codigo Dane</th>
                            <th class=" ">Estado</th>
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

                            <x-td wire:click="ver('{{ $item->id }}')">{{ $item->municipio ?? '' }} -
                                {{ $item->departamento ?? '' }}</x-td>
                            <x-td wire:click="ver('{{ $item->id }}')">{{ $item->codigo_dane_municipio ?? '' }}
                            </x-td>

                            <x-td class="py-3 w-32">
                                <x-switch-status-table estado="{{ $item->estado }}" id="{{ $item->id }}" />
                            </x-td>
                            <x-td class="py-3 w-16">
                                <x-menu-option-table x-on:click="openOption=!openOption" />
                                <div x-cloak x-show="openOption" @click.away="openOption = false"
                                    class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
                                    <x-boton-menu x-on:click="openOption=false"
                                        wire:click="ver('{{ $item->id }}')">Ver</x-boton-menu>

                                    <x-boton-menu x-on:click="openOption=false"
                                        wire:click="eliminar('{{ $item->id }}')">Eliminar</x-boton-menu>
                                </div>
                            </x-td>
                        </x-tr>
                        @endforeach
                    </x-slot>
                    <x-slot name="link">
                        <div></div>
                    </x-slot>
                </x-table>
            </x-slot>
        </x-tabla-crud>

        {{-- Modal añadir --}}
        <x-modal-crud  x-show="nuevo">
            <x-slot name="titulo">Actualizar ciudades</x-slot>
            <x-slot name="campos"></x-slot>
            <x-slot name="botones">
                <x-secondary-button x-on:click="nuevo = false">
                    Cerrar
                </x-secondary-button>
                <x-primary-button wire:click="guardar()">
                    Sincronizar ahora
                </x-primary-button>
            </x-slot>
        </x-modal-crud>

        {{-- Modal ver --}}
        <x-modal-crud  x-show="ver">
            <x-slot name="titulo"> Ver ciudad </x-slot>

            @if (!empty($consultaVer))
            <x-slot name="campos">
                <x-input-with-label wire="municipio" label="Ciudad" name="ciudad" id="ciudad" type="text" disabled
                    placeholder="Ciudad" maxlength="0" value="" />

                <x-input-with-label wire="codigo_dane_municipio" label="Codigo Dane del municipio"
                    name="codigo_dane_municipio" id="codigo_dane_municipio" disabled type="text"
                    placeholder="codigo_dane_municipio" maxlength="0" value="" />
                <x-input-with-label wire="departamento" label="Departamento" name="departamento" id="departamento"
                    type="text" disabled placeholder="Departamento" maxlength="0" value="" />
                <x-input-with-label wire="region" label="Region" name="region" id="region" type="text" disabled
                    placeholder="Region" maxlength="0" value="" />

                <x-input-with-label wire="estado" label="estado" name="estado" id="estado" disabled type="text"
                    placeholder="estado" maxlength="0" value="" />

            </x-slot>

            <x-slot name="botones">
                <x-secondary-button x-on:click="ver=false">Cerrar</x-secondary-button>
             {{--<x-primary-button x-on:click="ver = false" wire:click="editar('{{ $consultaVer->id }}')">
                    Editar
                </x-primary-button>--}}
            </x-slot>
            @else
            <x-slot name="campos"></x-slot>
            <x-slot name="botones"></x-slot>
            @endif

        </x-modal-crud>
    </x-contenedor>
</div>