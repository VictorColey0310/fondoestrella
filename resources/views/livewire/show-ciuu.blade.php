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
            <x-slot name="titulo"> CIIU </x-slot>
            <x-slot name="subtitulo"></x-slot>
            <x-slot name="filtro"></x-slot>
            <x-slot name="boton">Nuevo</x-slot>
            <x-slot name="tabla">
                {{-- Tabla lista --}}
                <x-table>
                    <x-slot name="head">
                        <x-tr class="font-semibold">
                            <th class="py-6"></th>
                            <th class=" ">Codigo</th>
                            <th class=" ">Actividad</th>
                            <th class=" ">Riesgo</th>
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
                            <x-td wire:click="ver('{{ $item->id }}')">{{ $item->codigo ?? '' }}</x-td>
                            <x-td wire:click="ver('{{ $item->id }}')">{{ $item->actividad ?? '' }}</x-td>
                            <x-td wire:click="ver('{{ $item->id }}')">{{ $item->riesgo ?? '' }}</x-td>

                            <x-td class="py-3 w-16">
                                <x-menu-option-table x-on:click="openOption=!openOption" />
                                <div x-cloak x-show="openOption" @click.away="openOption = false"
                                    class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
                                    <x-boton-menu x-on:click="openOption=false" wire:click="ver('{{ $item->id }}')">
                                        Ver</x-boton-menu>
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

        {{-- Modal nuevo --}}
        <x-modal-crud x-show="nuevo">
            <x-slot name="titulo"> Crear CIIU</x-slot>

            <x-slot name="campos">
                <x-input-with-label wire="codigo" label="Codigo" name="codigo" id="codigo" type="text" value=""
                    placeholder="Codigo" maxlength="4" />

                <x-input-with-label wire="actividad" label="Actividad economica" name="actividad" id="actividad" type="text" value=""
                    placeholder="actividad" maxlength="200" />

                <x-select wire="riesgo" label="Clase de riesgo" name="riesgo" id="riesgo" type="text" value=""
                placeholder="riesgo" maxlength="40" >
                <x-slot name="option">
                    <option value="">Seleccionar</option>
                    <option value="1">I</option>
                    <option value="2">II</option>
                    <option value="3">III</option>
                    <option value="4">IV</option>
                    <option value="5">V</option>
                </x-slot>
                
                </x-select>
            </x-slot>


            <x-slot name="botones">
                <x-secondary-button x-on:click="nuevo = false">
                    Cerrar
                </x-secondary-button>
                <x-primary-button x-on:click="nuevo = true" wire:click="guardar()">
                    Guardar
                </x-primary-button>
            </x-slot>

        </x-modal-crud>

        {{-- Modal editar --}}
        <x-modal-crud x-show="editar">
            <x-slot name="titulo"> Editar CIIU </x-slot>

            @if (!empty($consultaVer))
            <x-slot name="campos">
                <x-input-with-label wire="codigo" label="Codigo" name="codigo" id="codigo" type="text"
                    placeholder="Codigo" maxlength="100" value="" />
                <x-input-with-label wire="actividad" label="Actividad" name="actividad" id="actividad" type="text" placeholder=""
                    maxlength="40" value="" />                
              
                    <x-select wire="riesgo" label="Clase de riesgo" name="riesgo" id="riesgo" type="text" value=""
                    placeholder="riesgo" maxlength="40" >
                    <x-slot name="option">
                        <option value="">Seleccionar</option>
                        <option value="1">I</option>
                        <option value="2">II</option>
                        <option value="3">III</option>
                        <option value="4">IV</option>
                        <option value="5">V</option>
                    </x-slot>
                    
                    </x-select>
            </x-slot>

            <x-slot name="botones">
                <x-secondary-button x-on:click="editar=false">Cerrar</x-secondary-button>
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
            <x-slot name="titulo"> Ver CIIU</x-slot>

            @if (!empty($consultaVer))
            <x-slot name="campos">
                <x-input-with-label wire="codigo" label="Codigo" name="codigo" id="codigo" disabled type="text"
                    placeholder="Codigo" maxlength="0" value="" />
                <x-input-with-label wire="actividad" label="Actividad" name="actividad" id="actividad" type="text" disabled
                    placeholder="" maxlength="0" value="" />         
                    
                    <x-input-with-label wire="riesgo" label="Riesgo" name="riesgo" id="riesgo" type="text" disabled
                    placeholder="" maxlength="0" value="" />      
                                  
            </x-slot>

            <x-slot name="botones">
                <x-secondary-button x-on:click="ver=false">Cerrar</x-secondary-button>
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