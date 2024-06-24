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
            <x-slot name="titulo"> Reserva salon </x-slot>
            <x-slot name="subtitulo"> Descripcion de Reserva salon </x-slot>
            <x-slot name="boton">Nuevo</x-slot>
            <x-slot name="filtro"></x-slot>
            <x-slot name="tabla">
                {{-- Tabla lista --}}
                <x-table>
                    <x-slot name="head">
                        <x-tr class="font-semibold">
                            <th class="py-6"></th>
                            <th>Nombre del evento</th>
                            <th>Tipo</th>
                            <th>Fecha y hora de inicio</th>
                            <th>Fecha y hora de fin</th>
                            <th>Numero de asistentes</th>
                            <th>Descripcion</th>
                            <th>Cliente</th>
                            <th>Servicios Adicionales</th>
                            <th>Estado</th>
                            <th></th>
                        </x-tr>
                    </x-slot>

                    <x-slot name="bodytable">
                            @forelse ($consultaReservaSalon as $item)
                            <x-tr x-data="{ openOption: false }">
                                <x-td class="w-16">
                                    <input type="checkbox" wire:model.defer="eliminarItem" x-on:click="eliminar=true" value="{{ $item->id }}" class="ml-4 border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                </x-td>
                                <x-td>
                                    {{ $item->nombre_evento ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->tipo ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->fecha_hora_inicio ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->fecha_hora_fin ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->numero_asistentes ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->descripcion ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->cliente->nombre ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->estado ?? '' }}
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
            <x-slot name="titulo"> Crear Reserva salon</x-slot>

            <x-slot name="campos">
                <x-input-doble>
                    <x-input-with-label wire="nombre_evento" label="Nombre del evento" name="nombre_evento" id="nombre_evento" type="text" value="" placeholder="nombre de evento" maxlength="100" />
                    <x-select wire="tipo" label="Tipo" name="tipo" id="tipo" value="" class="uppercase">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            <option value="tipo1">Tipo 1</option>
                            <option value="tipo2">Tipo 2</option>
                        </x-slot>
                    </x-select>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_hora_inicio" label="Fecha y hora de inicio" name="fecha_hora_inicio" id="fecha_hora_inicio" type="datetime-local" value="" placeholder="fecha y hora de inicio" maxlength="100" />
                    <x-input-with-label wire="fecha_hora_fin" label="Fecha y hora de fin" name="fecha_hora_fin" id="fecha_hora_fin" type="datetime-local" value="" placeholder="fecha y hora de fin" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="numero_asistentes" label="Numero asistentes" name="numero_asistentes" id="numero_asistentes" type="number" value="" placeholder="numero de asistentes" maxlength="100" />
                    <x-input-with-label wire="descripcion" label="Descripcion" name="descripcion" id="descripcion" type="text" value="" placeholder="descripcion" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-select wire="cliente_id" label="Cliente" name="cliente_id" id="cliente_id" value="">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            @foreach ($consultaCliente as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <x-input-with-label wire="servicios_adicionales" label="Servicios adicionales" name="servicios_adicionales" id="servicios_adicionales" type="text" value="" placeholder="servicios adicionales" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="estado" label="Estado" name="estado" id="estado" type="text" value="" placeholder="estado" maxlength="100" />
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
            <x-slot name="titulo"> Editar Reserva salon </x-slot>
            @if (!empty($consultaVer))
                <x-slot name="campos">
                <x-input-doble>
                    <x-input-with-label wire="nombre_evento" label="Nombre del evento" name="nombre_evento" id="nombre_evento" type="text" value="" placeholder="nombre de evento" maxlength="100" />
                    <x-select wire="tipo" label="Tipo" name="tipo" id="tipo" value="" class="uppercase">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            <option value="tipo1">Tipo 1</option>
                            <option value="tipo2">Tipo 2</option>
                        </x-slot>
                    </x-select>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_hora_inicio" label="Fecha y hora de inicio" name="fecha_hora_inicio" id="fecha_hora_inicio" type="datetime-local" value="" placeholder="fecha y hora de inicio" maxlength="100" />
                    <x-input-with-label wire="fecha_hora_fin" label="Fecha y hora de fin" name="fecha_hora_fin" id="fecha_hora_fin" type="datetime-local" value="" placeholder="fecha y hora de fin" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="numero_asistentes" label="Numero asistentes" name="numero_asistentes" id="numero_asistentes" type="number" value="" placeholder="numero de asistentes" maxlength="100" />
                    <x-input-with-label wire="descripcion" label="Descripcion" name="descripcion" id="descripcion" type="text" value="" placeholder="descripcion" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-select wire="cliente_id" label="Cliente" name="cliente_id" id="cliente_id" value="">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            @foreach ($consultaCliente as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <x-input-with-label wire="servicios_adicionales" label="Servicios adicionales" name="servicios_adicionales" id="servicios_adicionales" type="text" value="" placeholder="servicios adicionales" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="estado" label="Estado" name="estado" id="estado" type="text" value="" placeholder="estado" maxlength="100" />
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
            <x-slot name="titulo"> Ver Reserva salon</x-slot>

            @if (!empty($consultaVer))
                <x-slot name="campos">
                <x-input-doble>
                    <x-input-with-label wire="nombre_evento" label="Nombre del evento" name="nombre_evento" id="nombre_evento" type="text" value="" placeholder="nombre de evento" maxlength="100" disabled/>
                    <x-select wire="tipo" label="Tipo" name="tipo" id="tipo" value="" class="uppercase" disabled>
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            <option value="tipo1">Tipo 1</option>
                            <option value="tipo2">Tipo 2</option>
                        </x-slot>
                    </x-select>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_hora_inicio" label="Fecha y hora de inicio" name="fecha_hora_inicio" id="fecha_hora_inicio" type="datetime-local" value="" placeholder="fecha y hora de inicio" maxlength="100" disabled/>
                    <x-input-with-label wire="fecha_hora_fin" label="Fecha y hora de fin" name="fecha_hora_fin" id="fecha_hora_fin" type="datetime-local" value="" placeholder="fecha y hora de fin" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="numero_asistentes" label="Numero asistentes" name="numero_asistentes" id="numero_asistentes" type="number" value="" placeholder="numero de asistentes" maxlength="100" disabled/>
                    <x-input-with-label wire="descripcion" label="Descripcion" name="descripcion" id="descripcion" type="text" value="" placeholder="descripcion" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-select wire="cliente_id" label="Cliente" name="cliente_id" id="cliente_id" value="" disabled>
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            @foreach ($consultaCliente as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <x-input-with-label wire="servicios_adicionales" label="Servicios adicionales" name="servicios_adicionales" id="servicios_adicionales" type="text" value="" placeholder="servicios adicionales" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="estado" label="Estado" name="estado" id="estado" type="text" value="" placeholder="estado" maxlength="100" disabled/>
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