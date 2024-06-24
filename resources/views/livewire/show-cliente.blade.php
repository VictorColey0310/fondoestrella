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
                            <th>Identificacion</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Pais</th>
                            <th>Fecha de nacimiento</th>
                            <th>Genero</th>
                            {{--<th>Preferencias de habitacion</th>
                            <th>Membresia</th>
                            <th>Comentarios</th>--}}
                            <th>Fecha de registro</th>
                            <th>Ultima fecha de estancia</th>
                            <th>Notas</th>
                            <th></th>
                        </x-tr>
                    </x-slot>

                    <x-slot name="bodytable">
                    @forelse ($consultaCliente as $item)
                            <x-tr x-data="{ openOption: false }">
                                <x-td class="w-16">
                                    <input type="checkbox" wire:model.defer="eliminarItem" x-on:click="eliminar=true" value="{{ $item->id }}" class="ml-4 border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                </x-td>
                                <x-td>
                                    {{ $item->nombre ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->identificacion ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->email ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->telefono ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->direccion ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->pais ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->fecha_nacimiento ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->genero ?? '' }}
                                </x-td>
                                {{--<x-td>
                                    {{ $item->preferencias_habitacion ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->membresia ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->comentarios ?? '' }}
                                </x-td>--}}
                                <x-td>
                                    {{ $item->fecha_registro ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->ultima_fecha_estancia ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->notas_personal ?? '' }}
                                </x-td>
                                <x-td class="py-3 w-16">
                                    <x-menu-option-table x-on:click="openOption=!openOption" />
                                    <div x-cloak x-show="openOption" @click.away="openOption = false" class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
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
                    <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text" value="" placeholder="nombre" maxlength="100" />
                    <x-input-with-label wire="identificacion" label="Identificacion" name="identificacion" id="identificacion" type="number" value="" placeholder="identificacion" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="email" label="Email" name="email" id="email" type="email" value="" placeholder="email" maxlength="100" />
                    <x-input-with-label wire="telefono" label="Telefono" name="telefono" id="telefono" type="number" value="" placeholder="telefono" maxlength="10" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="direccion" label="Direccion" name="direccion" id="direccion" type="text" value="" placeholder="direccion" maxlength="100" />
                    <x-input-with-label wire="pais" label="Pais" name="pais" id="pais" type="text" value="" placeholder="pais" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_nacimiento" label="Fecha de nacimiento" name="fecha_nacimiento" id="fecha_nacimiento" type="date" value="" placeholder="fecha nacimiento" maxlength="100" />
                    <x-select wire="genero" label="Genero" name="genero" id="genero" value="" class="uppercase">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                        </x-slot>
                    </x-select>
                </x-input-doble>
                {{--<x-input-doble>
                    <x-input-with-label wire="preferencias_habitacion" label="Preferencias de habitacion" name="preferencias_habitacion" id="preferencias_habitacion" type="text" value="" placeholder="preferencias habitacion" maxlength="100" />
                    <x-input-with-label wire="membresia" label="Membresia" name="membresia" id="membresia" type="text" value="" placeholder="membresia" maxlength="100" />
                <x-input-doble>--}}
                <x-input-doble>
                    {{--<x-input-with-label wire="comentarios" label="Comentarios" name="comentarios" id="comentarios" type="text" value="" placeholder="comentarios" maxlength="100" />--}}
                    <x-input-with-label wire="fecha_registro" label="Fecha de registro" name="fecha_registro" id="fecha_registro" type="date" value="" placeholder="fecha registro" maxlength="100" />
                    <x-input-with-label wire="ultima_fecha_estancia" label="Ultima fecha de estancia" name="ultima_fecha_estancia" id="ultima_fecha_estancia" type="date" value="" placeholder="ultima fecha estancia" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-textarea-label wire="notas_personal" label="Nota" name="notas_personal" id="notas_personal" type="text" value="" placeholder="notas personal" maxlength="100" />
                </x-input-doble>

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
                    <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text" value="" placeholder="nombre" maxlength="100" />
                    <x-input-with-label wire="identificacion" label="Identificacion" name="identificacion" id="identificacion" type="number" value="" placeholder="identificacion" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="email" label="Email" name="email" id="email" type="email" value="" placeholder="email" maxlength="100" />
                    <x-input-with-label wire="telefono" label="Telefono" name="telefono" id="telefono" type="number" value="" placeholder="telefono" maxlength="10" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="direccion" label="Direccion" name="direccion" id="direccion" type="text" value="" placeholder="direccion" maxlength="100" />
                    <x-input-with-label wire="pais" label="Pais" name="pais" id="pais" type="text" value="" placeholder="pais" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_nacimiento" label="Fecha de nacimiento" name="fecha_nacimiento" id="fecha_nacimiento" type="date" value="" placeholder="fecha nacimiento" maxlength="100" />
                    <x-select wire="genero" label="Genero" name="genero" id="genero" value="" class="uppercase">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                        </x-slot>
                    </x-select>
                </x-input-doble>
                {{--<x-input-doble>
                    <x-input-with-label wire="preferencias_habitacion" label="Preferencias de habitacion" name="preferencias_habitacion" id="preferencias_habitacion" type="text" value="" placeholder="preferencias habitacion" maxlength="100" />
                    <x-input-with-label wire="membresia" label="Membresia" name="membresia" id="membresia" type="text" value="" placeholder="membresia" maxlength="100" />
                </x-input-doble>--}}
                <x-input-doble>
                    {{--<x-input-with-label wire="comentarios" label="Comentarios" name="comentarios" id="comentarios" type="text" value="" placeholder="comentarios" maxlength="100" />--}}
                    <x-input-with-label wire="fecha_registro" label="Fecha de registro" name="fecha_registro" id="fecha_registro" type="date" value="" placeholder="fecha registro" maxlength="100" />
                    <x-input-with-label wire="ultima_fecha_estancia" label="Ultima fecha de estancia" name="ultima_fecha_estancia" id="ultima_fecha_estancia" type="date" value="" placeholder="ultima fecha estancia" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-textarea-label wire="notas_personal" label="Nota" name="notas_personal" id="notas_personal" type="text" value="" placeholder="notas personal" maxlength="100" />
                </x-input-doble>

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
                    <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text" value="" placeholder="nombre" maxlength="100" disabled/>
                    <x-input-with-label wire="identificacion" label="Identificacion" name="identificacion" id="identificacion" type="number" value="" placeholder="identificacion" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="email" label="Email" name="email" id="email" type="email" value="" placeholder="email" maxlength="100" disabled/>
                    <x-input-with-label wire="telefono" label="Telefono" name="telefono" id="telefono" type="number" value="" placeholder="telefono" maxlength="10" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="direccion" label="Direccion" name="direccion" id="direccion" type="text" value="" placeholder="direccion" maxlength="100" disabled/>
                    <x-input-with-label wire="pais" label="Pais" name="pais" id="pais" type="text" value="" placeholder="pais" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_nacimiento" label="Fecha de nacimiento" name="fecha_nacimiento" id="fecha_nacimiento" type="date" value="" placeholder="fecha nacimiento" maxlength="100" disabled/>
                    <x-select wire="genero" label="Genero" name="genero" id="genero" value="" class="uppercase" disabled>
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                        </x-slot>
                    </x-select>
                </x-input-doble>
                {{--<x-input-doble>
                    <x-input-with-label wire="preferencias_habitacion" label="Preferencias de habitacion" name="preferencias_habitacion" id="preferencias_habitacion" type="text" value="" placeholder="preferencias habitacion" maxlength="100" disabled/>
                    <x-input-with-label wire="membresia" label="Membresia" name="membresia" id="membresia" type="text" value="" placeholder="membresia" maxlength="100" disabled/>
                </x-input-doble>--}}
                <x-input-doble>
                    {{--<x-input-with-label wire="comentarios" label="Comentarios" name="comentarios" id="comentarios" type="text" value="" placeholder="comentarios" maxlength="100" disabled/>--}}
                    <x-input-with-label wire="fecha_registro" label="Fecha de registro" name="fecha_registro" id="fecha_registro" type="date" value="" placeholder="fecha registro" maxlength="100" disabled/>
                    <x-input-with-label wire="ultima_fecha_estancia" label="Ultima fecha de estancia" name="ultima_fecha_estancia" id="ultima_fecha_estancia" type="date" value="" placeholder="ultima fecha estancia" maxlength="100" disabled/>
                </x-input-doble>

                <x-input-doble>
                    <x-textarea-label wire="notas_personal" label="Nota" name="notas_personal" id="notas_personal" type="text" value="" placeholder="notas personal" maxlength="100" disabled/>
                </x-input-doble>

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