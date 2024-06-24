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
                            <th class="py-6">titulo</th>
                            <th class="py-6">imagen</th>
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
                            <x-td wire:click="ver('{{ $item->id }}')">{{ $item->titulo ?? '' }}</x-td>
                            <x-td wire:click="ver('{{ $item->id }}')">{{ $item->imagen ?? '' }}</x-td>

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
                    </x-slot>
                </x-table>
            </x-slot>
        </x-tabla-crud>

        {{-- Modal añadir --}}
        <x-modal-crud x-show="nuevo">
            <x-slot name="titulo"> Crear {{ $nombreCrud }} </x-slot>

            <x-slot name="campos">

                <x-input-with-label wire="titulo" label="titulo" name="titulo" id="titulo" type="text"
                    value="" placeholder="Titulo" maxlength="40" />

                <x-input-file wire="imagen" label="imagen" name="imagen" id="imagen" type="file" placeholder="imagen" maxlength="200" value="" />
                <div class="mb-2">
                    @if ($imagen)
                        {{-- <img src="{{ $imagen->temporaryUrl() }}" alt="imagen" class="w-32 h-32 border mx-8  rounded-lg object-cover"> --}}
                        <div class="w-32 h-32 border mx-8  rounded-lg"></div>
                    @endif
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

                    <x-input-with-label wire="titulo" label="titulo" name="titulo" id="titulo" type="text" placeholder="" maxlength="40" value=""/>

                    @if ($imagen_data)
                    <div>
                        <img src="{{asset($imagen_data)}}" alt="">
                    </div>
                    @endif

                    <x-input-file wire="imagen" label="imagen" name="imagen" id="imagen" type="file" placeholder="imagen" maxlength="200" value="" />
                        <div class="mb-2">
                            @if ($imagen)
                                {{-- <img src="{{ $imagen->temporaryUrl() }}" alt="imagen" class="w-32 h-32 border mx-8  rounded-lg object-cover"> --}}
                                <div class="w-32 h-32 border mx-8  rounded-lg"></div>
                            @endif
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

                    <x-input-with-label wire="titulo" label="titulo" name="titulo" id="titulo" type="text"
                    disabled placeholder="" maxlength="0" value=""/>

                    <div>
                         <img src="{{asset($imagen)}}" alt="">
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
