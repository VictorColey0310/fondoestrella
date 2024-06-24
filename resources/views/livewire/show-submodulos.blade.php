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
            <x-slot name="titulo"> Submodulos </x-slot>
            <x-slot name="subtitulo"> Descripcion de submodulos </x-slot>
            <x-slot name="filtro"></x-slot>
            <x-slot name="boton">Nuevo</x-slot>
            <x-slot name="tabla">
                {{-- Tabla lista --}}
                <x-table>
                    <x-slot name="head">
                        <x-tr class="font-semibold">
                            <th class="py-6"></th>
                            <th class=" ">Nombre</th>
                            <th class=" ">Descripcion</th>
                            <th class=" ">Modulo</th>
                            <th class=" ">Url</th>
                            <th class="">Estado</th>
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
                                <x-td wire:click="ver('{{ $item->id }}')"> {{ $item->modulo->nombre ?? '' }} </x-td>
                                <x-td wire:click="ver('{{ $item->id }}')"> {{ $item->url ?? '' }} </x-td>

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
            <x-slot name="titulo"> Crear Submodulo </x-slot>

            <x-slot name="campos">
                <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text"
                    value="" placeholder="Nombre" maxlength="40" />

                <x-select wire="modulo_id" label="Modulo" name="modulo" id="modulo" value="">
                    <x-slot name="option">
                        <option>Seleccionar</option>
                        @foreach ($consultaModulos as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </x-slot>
                </x-select>

                <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                    value="" type="text" placeholder="Descripción" maxlength="100" />

                <x-input-with-label wire="url" label="Url" name="url" id="url" type="text"
                    value="" placeholder="Url" maxlength="50" />

                <div class="flex justify-between">
                    <x-switch-status />

                    <div class="flex justify-center items-center">
                        <label for="crud"
                            class="cursor-pointer flex pr-4 items-center text-gray-700 text-sm font-semibold">
                            Crud
                        </label>
                        <input type="checkbox" name="crud" id="crud"
                            class="w-6 h-6 border border-gray-400 rounded-md flex-shrink-0 bg-white outline-0"
                            wire:model="crud">
                    </div>
                </div>

                @if ($crud)
                    <div class="flex justify-between items-center gap-8">
                        <div class="w-full">
                            <input type="text" name="dato" id="dato" wire:model.defer="dato"
                                placeholder="Nombre dato"
                                class="text-sm border border-gray-300 rounded-md w-full appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="w-full">
                            <input type="text" name="label" id="label" wire:model.defer="label"
                                placeholder="Label"
                                class="text-sm border border-gray-300 rounded-md w-full appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="w-full">
                            <select name="tipo" id="tipo" wire:model.defer="tipo"
                                class="text-sm border border-gray-300 rounded-md w-full appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="text">Texto</option>
                                <option value="number">Numero</option>
                                <option value="date">Fecha</option>
                                <option value="email">Email</option>
                                <option value="password">Contraseña</option>
                            </select>
                        </div>
                        <button
                            class="bg-green-500 text-white hover:bg-green-700 font-semibold rounded-lg px-2 py-1 text-sm"
                            wire:click="agregarDato">Agregar</button>
                    </div>

                    <table class="w-full my-2">
                        @foreach ($datos as $index => $dato)
                            <tr class="bg-gray-100">
                                <td class="py-1 px-4 border-b text-center"> {{ $dato['dato'] }}</td>
                                <td class="py-1 px-4 border-b text-center"> {{ $dato['label'] }}</td>
                                <td class="py-1 px-4 border-b text-center"> {{ $dato['tipo'] }}</td>
                                <td class="py-1 px-4 border-b text-center"><button
                                        class="text-red-500 hover:text-red-700 font-semibold"
                                        wire:click="eliminarDato({{ $index }})">Eliminar</button></td>
                            </tr>
                        @endforeach
                    </table>
                @endif


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
        <x-modal-crud x-show="editar">
            <x-slot name="titulo"> Editar submodulo </x-slot>
            @if (!empty($consultaVer))
                <x-slot name="campos">
                    <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text"
                        placeholder="" maxlength="40" value="" />
                    <x-select wire="modulo_id" label="Modulo" name="modulo" id="modulo" value="">
                        <x-slot name="option">
                            <option>Seleccionar</option>
                            @foreach ($consultaModulos as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                            @endforeach
                        </x-slot>
                    </x-select>

                    <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                        type="text" placeholder="Descripción" maxlength="100" value="" />

                    <x-input-with-label wire="url" label="Url" name="url" id="url" type="text"
                        value="" placeholder="Url" maxlength="50" />
                    <x-switch-status />
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
            <x-slot name="titulo"> Ver submodulo </x-slot>
            @if (!empty($consultaVer))
                <x-slot name="campos">
                    <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text"
                        disabled placeholder="" maxlength="0" value="" />

                    <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                        disabled type="text" placeholder="Descripción" maxlength="0" value="" />

                    <x-input-with-label wire="modulo_id" label="Modulo" name="modulo_id" id="modulo_id"
                        type="text" disabled placeholder="Modulo" maxlength="0" value="" />

                    <x-input-with-label wire="url" label="Url" name="url" id="url" type="text"
                        disabled placeholder="Url" maxlength="0" value="" />

                    <x-input-with-label wire="estado" label="estado" name="estado" id="estado" disabled
                        type="text" placeholder="estado" maxlength="0" value="" />

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
