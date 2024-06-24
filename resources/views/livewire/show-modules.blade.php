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
}" @keydown.escape="closeModal" tabindex="0"  class="h-full w-full md:my-2">
    <x-contenedor>
        {{-- Carga --}}
        @include('components/loading')

        <x-tabla-crud>
            <x-slot name="titulo"> Modulos </x-slot>
            <x-slot name="subtitulo"> Descripcion de modulos </x-slot>
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
                            <th class=" ">Icono</th>
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
                            <x-td  class="w-36" wire:click="ver('{{ $item->id }}')">
                                @if ($item->icono)
                                @svg($item->icono, 'w-6 h-6')
                                @endif
                            </x-td>

                            <x-td class="py-3 w-32" >
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
            <x-slot name="titulo"> Crear Modulo </x-slot>

            <x-slot name="campos">
                <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text" value=""
                    placeholder="Modulo" maxlength="40" />

                <x-select wire="icono" label="Icono" name="icono" id="icono" value="">
                    
                    <x-slot name="option">
                        <option value="">Seleccionar</option>
                        @foreach ($consultaIconos as $item)
                        <option value="{{ $item->icono }}">@svg($item->codigo, ['class' => 'w-4 h-4']){{ $item->nombre
                            }}</option>
                        @endforeach
                    </x-slot>
                </x-select>

                <div class="text-center justify-center w-full pb-4" id="icono">
                    @if ($icono)
                    @svg($icono, 'w-6 h-6 mx-auto')
                    @else
                    <div class="w-8 aspect-square bg-gray-300 mx-auto rounded"></div>
                    @endif
                </div>

                <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion" value=""
                    type="text" placeholder="Descripción" maxlength="100" />
                <x-switch-status />

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
            <x-slot name="titulo"> Editar Modulo </x-slot>

            @if (!empty($consultaVer))
            <x-slot name="campos">
                <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text" placeholder=""
                    maxlength="40" value="" />
                <x-select wire="icono" label="Icono" name="icono" id="icono" value="">
                    <x-slot name="option">
                        @foreach ($consultaIconos as $item)
                        <option value="{{ $item->icono }}">{{ $item->nombre }}</option>
                        @endforeach
                    </x-slot>
                </x-select>
                <div class="text-center justify-center w-full pb-4" id="icono">
                    @if ($icono)
                    @svg($icono, 'w-6 h-6 mx-auto')
                    @else
                    <div class="w-8 aspect-square bg-gray-300 mx-auto rounded"></div>
                    @endif
                </div>
                <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                    type="text" placeholder="Descripción" maxlength="100" value="" />

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
            <x-slot name="titulo"> Ver Modulo </x-slot>

            @if (!empty($consultaVer))

            <x-slot name="campos">
                <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text" disabled
                    placeholder="" maxlength="0" value="" />

                <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion" disabled
                    type="text" placeholder="Descripción" maxlength="0" value="" />
                <x-input-with-label wire="icono" label="Icono" name="icono" id="icono" type="text" disabled
                    placeholder="Icono" maxlength="0" value="" />
                <div class="text-center justify-center w-full pb-4" id="icono">
                    @if ($icono)
                    @svg($icono, 'w-6 h-6 mx-auto')
                    @else
                    <div class="w-8 aspect-square bg-gray-300 mx-auto rounded"></div>
                    @endif
                </div>
                <x-input-with-label wire="estado" label="estado" name="estado" id="estado" disabled type="text"
                    placeholder="estado" maxlength="0" value="" />

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