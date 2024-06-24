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
                            <th class=" ">Tipo</th>
                            <th class=" ">Descripcion</th>
                            <th class=" ">Archivo</th>
                            <th class=" ">Fechas</th>
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
                                <x-td wire:click="ver('{{ $item->id }}')" class="uppercase">{{ $item->tipo ?? '' }}
                                </x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">{{ $item->descripcion ?? '' }}</x-td>
                                <x-td>
                                    @if (!empty($item->archivo))
                                        <a class="my-6" target="_blank" href="{{ asset($item->archivo ?? '') }}">
                                            <x-primary-button>
                                                Ver adjunto
                                            </x-primary-button>
                                        </a>
                                    @endif
                                </x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">{{ $item->fecha_inicio ?? '' }} -
                                    {{ $item->fecha_fin ?? '' }}</x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">
                                    <div class="px2 py-1 ">
                                        {{ $item->estado ?? '' }}
                                    </div>
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
            <x-slot name="titulo"> Crear {{ $nombreCrud }} </x-slot>

            <x-slot name="campos">

                <x-select wire="tipo" label="Tipo de permiso" name="tipo" id="tipo" value="">
                    <x-slot name="option">
                        <option value="">Seleccionar</option>
                        <option value="remunerado">Remunerado</option>
                        <option value="no remunerado">No remunerado</option>
                    </x-slot>
                </x-select>
                <x-input-doble>

                    <x-input-with-label wire="fecha_inicio" label="Fecha inicio" name="fecha_inicio" id="fecha_inicio"
                        value="" type="date" placeholder="fecha_inicio" maxlength="100" />

                    <x-input-with-label wire="fecha_fin" label="Fecha final" name="fecha_final" id="fecha_final"
                        value="" type="date" placeholder="fecha_final" maxlength="100" />
                </x-input-doble>
                <x-textarea-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                    type="text" value="" placeholder="Describa su solicitud" maxlength="1000" />

                <x-input-file wire="upload_archivo" label="Formato" name="Formato" id="Formato" type="file"
                    placeholder="Formato" maxlength="200" value="" />

            </x-slot>

            <x-slot name="botones">
                <x-secondary-button x-on:click="nuevo = false">
                    Cerrar
                </x-secondary-button>
                <x-primary-button wire:click="guardar()">
                    Guardar
                </x-primary-button>
            </x-slot>

        </x-modal-crud>

        {{-- Modal editar --}}
        <x-modal-crud x-cloak x-show="editar">
            <x-slot name="titulo"> Editar {{ $nombreCrud }} </x-slot>
            @if (!empty($consultaVer))
                <x-slot name="campos">
                    <x-select wire="tipo" label="Tipo de permiso" name="tipo" id="tipo" value="">
                        <x-slot name="option">
                            <option value="">Seleccionar</option>
                            <option value="remunerado">Remunerado</option>
                            <option value="no remunerado">No remunerado</option>
                        </x-slot>
                    </x-select>
                    <x-input-doble>
                        <x-input-with-label wire="fecha_inicio" label="Fecha inicio" name="fecha_inicio"
                            id="fecha_inicio" value="" type="date" placeholder="fecha_inicio"
                            maxlength="100" />

                        <x-input-with-label wire="fecha_fin" label="Fecha final" name="fecha_final" id="fecha_final"
                            value="" type="date" placeholder="fecha_final" maxlength="100" />
                    </x-input-doble>
                    <x-textarea-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                        type="text" value="" placeholder="Describa su solicitud" maxlength="1000" />

                    <x-input-file wire="upload_archivo" label="Adjunto" name="Formato" id="Formato"
                        type="file" placeholder="Formato" maxlength="200" value="" />

                    @if (!empty($archivo))
                        <a class="my-6" target="_blank" href="{{ asset($archivo ?? '') }}">
                            <x-primary-button>
                                Ver formato
                            </x-primary-button>
                        </a>
                    @endif
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
                    <x-select wire="tipo" label="Tipo de permiso" name="tipo" id="tipo" value=""
                        disabled>
                        <x-slot name="option">
                            <option value="">Seleccionar</option>
                            <option value="remunerado">Remunerado</option>
                            <option value="no remunerado">No remunerado</option>
                        </x-slot>
                    </x-select>
                    <x-input-doble>
                        <x-input-with-label wire="fecha_inicio" label="Fecha inicio" name="fecha_inicio"
                            id="fecha_inicio" value="" type="text" placeholder="fecha_inicio"
                            maxlength="100" disabled />

                        <x-input-with-label wire="fecha_fin" label="Fecha final" name="fecha_final" id="fecha_final"
                            value="" type="text" placeholder="fecha_final" maxlength="100" disabled />
                    </x-input-doble>
                    <x-textarea-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                        type="text" value="" placeholder="Describa su solicitud" maxlength="1000"
                        disabled />

                    <x-input-file wire="upload_archivo" label="Formato" name="Formato" id="Formato"
                        type="file" placeholder="Formato" maxlength="200" value="" />

                    @if (!empty($archivo))
                        <a class="my-6" target="_blank" href="{{ asset($archivo ?? '') }}">
                            <x-primary-button>
                                Ver archivo
                            </x-primary-button>
                        </a>
                    @endif

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
    </x-contenedor>
</div>
