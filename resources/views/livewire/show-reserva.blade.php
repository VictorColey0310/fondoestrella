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
                            <th>Cliente</th>
                            <th>Habitacion</th>
                            <th>Fecha y hora de entrada</th>
                            <th>Fecha y hora de salida</th>
                            <th>Cantidad de adultos</th>
                            <th>Cantidad de niños</th>
                            <th>Estado</th>
                            <th>Pago</th>
                            <th>Metodo pago</th>
                            <th>comentario</th>
                            <th>Fecha reserva</th>
                            <th>Estado reserva</th>
                            <th>Duracion estancia</th>
                            <th>Precio total</th>
                            <th></th>
                        </x-tr>
                    </x-slot>

                    <x-slot name="bodytable">
                            @forelse ($consultaReserva as $item)
                            <x-tr x-data="{ openOption: false }">
                                <x-td class="w-16">
                                    <input type="checkbox" wire:model.defer="eliminarItem" x-on:click="eliminar=true" value="{{ $item->id }}" class="ml-4 border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                </x-td>
                                <x-td>
                                    {{ $item->cliente->nombre ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->habitacion->nombre . ' - ' . $item->habitacion->numero ?? ''}}
                                </x-td>
                                <x-td>
                                    {{ $item->fecha_check_in ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->fecha_check_out ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->cantidad_adultos ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->cantidad_niños ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->estado ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->pago ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->metodos_pago->nombre ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->comentario ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->fecha_reserva ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->estado_reserva ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->duracion_estancia ?? '' }}
                                </x-td>
                                <x-td>
                                    {{ $item->precio_total ?? '' }}
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
                    <x-select wire="habitacion_id" label="Habitacion" name="habitacion_id" id="habitacion_id" value="">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            @foreach ($consultaHabitacion as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nombre }} : {{ $item->numero }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_check_in" label="Fecha y hora de Entrada" name="fecha_check_in" id="fecha_check_in" type="datetime-local" value="" placeholder="fecha y hora de entrada" maxlength="100" />
                    <x-input-with-label wire="fecha_check_out" label="Fecha y hora de Salida" name="fecha_check_out" id="fecha_check_out" type="datetime-local" value="" placeholder="fecha y hora de salida" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="cantidad_adultos" label="Cantidad de adultos" name="cantidad_adultos" id="cantidad_adultos" type="number" value="" placeholder="cantidad de adultos" maxlength="100" />
                    <x-input-with-label wire="cantidad_niños" label="Cantidad de niños" name="cantidad_niños" id="cantidad_niños" type="number" value="" placeholder="cantidad de niños" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="estado" label="Estado" name="estado" id="estado" type="text" value="" placeholder="estado" maxlength="100" />
                    <x-input-with-label wire="pago" label="Pago" name="pago" id="pago" type="number" value="" placeholder="pago" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-select wire="metodo_pago" label="Metodo de pago" name="metodo_pago" id="metodo_pago" value="">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            @foreach ($consultaMetodosPago as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <x-input-with-label wire="comentario" label="Comentario" name="comentario" id="comentario" type="text" value="" placeholder="comentario" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_reserva" label="Fecha reserva" name="fecha_reserva" id="fecha_reserva" type="date" value="" placeholder="fecha reserva" maxlength="100" />
                    <x-input-with-label wire="estado_reserva" label="Estado reserva" name="estado_reserva" id="estado_reserva" type="text" value="" placeholder="estado reserva" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="duracion_estancia" label="Duracion estancia" name="duracion_estancia" id="duracion_estancia" type="text" value="" placeholder="duracion estancia" maxlength="100" />
                    <x-input-with-label wire="precio_total" label="Precio total" name="precio_total" id="precio_total" type="number" value="" placeholder="precio total" maxlength="100" />
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
                    <x-select wire="habitacion_id" label="Habitacion" name="habitacion_id" id="habitacion_id" value="">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            @foreach ($consultaHabitacion as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nombre }} : {{ $item->numero }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_check_in" label="Fecha y hora de Entrada" name="fecha_check_in" id="fecha_check_in" type="datetime-local" value="" placeholder="fecha y hora de entrada" maxlength="100" />
                    <x-input-with-label wire="fecha_check_out" label="Fecha y hora de Salida" name="fecha_check_out" id="fecha_check_out" type="datetime-local" value="" placeholder="fecha y hora de salida" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="cantidad_adultos" label="Cantidad de adultos" name="cantidad_adultos" id="cantidad_adultos" type="number" value="" placeholder="cantidad de adultos" maxlength="100" />
                    <x-input-with-label wire="cantidad_niños" label="Cantidad de niños" name="cantidad_niños" id="cantidad_niños" type="number" value="" placeholder="cantidad de niños" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="estado" label="Estado" name="estado" id="estado" type="text" value="" placeholder="estado" maxlength="100" />
                    <x-input-with-label wire="pago" label="Pago" name="pago" id="pago" type="number" value="" placeholder="pago" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-select wire="metodo_pago" label="Metodo de pago" name="metodo_pago" id="metodo_pago" value="">
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            @foreach ($consultaMetodosPago as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <x-input-with-label wire="comentario" label="Comentario" name="comentario" id="comentario" type="text" value="" placeholder="comentario" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_reserva" label="Fecha reserva" name="fecha_reserva" id="fecha_reserva" type="date" value="" placeholder="fecha reserva" maxlength="100" />
                    <x-input-with-label wire="estado_reserva" label="Estado reserva" name="estado_reserva" id="estado_reserva" type="text" value="" placeholder="estado reserva" maxlength="100" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="duracion_estancia" label="Duracion estancia" name="duracion_estancia" id="duracion_estancia" type="text" value="" placeholder="duracion estancia" maxlength="100" />
                    <x-input-with-label wire="precio_total" label="Precio total" name="precio_total" id="precio_total" type="number" value="" placeholder="precio total" maxlength="100" />
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
                    <x-select wire="habitacion_id" label="Habitacion" name="habitacion_id" id="habitacion_id" value="" disabled>
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            @foreach ($consultaHabitacion as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nombre }} : {{ $item->numero }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_check_in" label="Fecha y hora de Entrada" name="fecha_check_in" id="fecha_check_in" type="datetime-local" value="" placeholder="fecha y hora de entrada" maxlength="100" disabled/>
                    <x-input-with-label wire="fecha_check_out" label="Fecha y hora de Salida" name="fecha_check_out" id="fecha_check_out" type="datetime-local" value="" placeholder="fecha y hora de salida" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="cantidad_adultos" label="Cantidad de adultos" name="cantidad_adultos" id="cantidad_adultos" type="number" value="" placeholder="cantidad de adultos" maxlength="100" disabled/>
                    <x-input-with-label wire="cantidad_niños" label="Cantidad de niños" name="cantidad_niños" id="cantidad_niños" type="number" value="" placeholder="cantidad de niños" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="estado" label="Estado" name="estado" id="estado" type="text" value="" placeholder="estado" maxlength="100" disabled/>
                    <x-input-with-label wire="pago" label="Pago" name="pago" id="pago" type="number" value="" placeholder="pago" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-select wire="metodo_pago" label="Metodo de pago" name="metodo_pago" id="metodo_pago" value="" disabled>
                        <x-slot name="option">
                            <option value="" selected>Seleccionar</option>
                            @foreach ($consultaMetodosPago as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nombre }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <x-input-with-label wire="comentario" label="Comentario" name="comentario" id="comentario" type="text" value="" placeholder="comentario" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="fecha_reserva" label="Fecha reserva" name="fecha_reserva" id="fecha_reserva" type="date" value="" placeholder="fecha reserva" maxlength="100" disabled/>
                    <x-input-with-label wire="estado_reserva" label="Estado reserva" name="estado_reserva" id="estado_reserva" type="text" value="" placeholder="estado reserva" maxlength="100" disabled/>
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="duracion_estancia" label="Duracion estancia" name="duracion_estancia" id="duracion_estancia" type="text" value="" placeholder="duracion estancia" maxlength="100" disabled/>
                    <x-input-with-label wire="precio_total" label="Precio total" name="precio_total" id="precio_total" type="number" value="" placeholder="precio total" maxlength="100" disabled/>
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
