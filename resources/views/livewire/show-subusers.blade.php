<div>
    <div x-data="{
        nuevo: @entangle('nuevo'),
        editar: @entangle('editar'),
        ver: @entangle('ver'),
        editarPassword: @entangle('editarPassword'),
        modalnocertificado: @entangle('modalnocertificado'),
        eliminar: false,
        download: false,
        activarUser: false,
        DesactivarUser: false,
        exportar: false,
        reenviar: false,
        abrirActivarUserModal: false,
        activarUserModal: false,
        modalExportar: false,
        botones: false,
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
                <x-slot name="titulo"> Administración de Usuarios </x-slot>
                <x-slot name="subtitulo">
                    @if (!empty($consulta))
                        <div class="text-sm  border bg-gray-100 rounded-lg p-4 mx-4 my-2 w-32">
                            <div>
                                {{ $consulta->count() ?? '' }} Usuarios
                            </div>
                            <div>
                                {{ $activos ?? '' }} Activos
                            </div>
                            <div>
                                {{ $inactivos ?? '' }} Inactivos
                            </div>
                        </div>
                    @endif
                </x-slot>
                <x-slot name="filtro">

                </x-slot>
                <x-slot name="boton">Nuevo</x-slot>

                <x-slot name="tabla">
                    <div x-cloak x-show="botones">
                        <x-primary-button x-on:click="botones=false,activarUserModal=true,eliminar=false"
                            class="bg-green-400 hover:bg-green-600">Estado</x-primary-button>
                        <x-primary-button
                            x-on:click="botones=false,activarUser=false,exportar=false,reenviar=false,modalExportar=true,eliminar=false,download=false"
                            class="bg-blue-400 hover:bg-blue-600">Exportar</x-primary-button>
                        <x-primary-button
                            x-on:click="botones=false,activarUser=false,exportar=false,reenviar=false,eliminar=false,download=false"
                            wire:click="enviarInvitacionMasiva" class="bg-blue-400 hover:bg-blue-600">Reenviar
                            credenciales</x-primary-button>
                    </div>


                    {{-- Tabla lista --}}
                    <x-table>
                        <x-slot name="head">
                            <x-tr class="font-semibold">
                                <th class="py-6">
                                    <input
                                        x-on:click="botones=true,trasladar=true,DesactivarUser=true,activarUser=true,exportar=true,reenviar=true,eliminar=true"
                                        type="checkbox" wire:model="checkAll" wire:click="toggleCheckAll" id="checkAll"
                                        class="ml-4 border-gray-100 shadow shadow-gray-400 cursor-pointer rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                </th>
                                <th class="">Documento</th>
                                <th class="">Nombre</th>
                                <th class="">Correo</th>
                                <th class="">Rol</th>
                                <th class="mx-1">Empresa</th>
                                <th class="">Estado</th>
                                <th class="">Ultima conexión</th>
                                <th class=""></th>
                            </x-tr>
                        </x-slot>

                        <x-slot name="bodytable">
                            @forelse ($consultaUsuario as $item)
                                <x-tr x-data="{ openOption: false }">
                                    <x-td class="w-16">
                                        <input type="checkbox" wire:model.defer="eliminarItem"
                                            x-on:click="eliminar=true" value="{{ $item->id }}"
                                            class="ml-4 border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                    </x-td>
                                    <x-td>
                                        {{ $item->documento ?? '' }}
                                    </x-td>
                                    <x-td>
                                        {{ $item->name ?? '' }}
                                    </x-td>
                                    <x-td>
                                        {{ $item->email ?? '' }}
                                    </x-td>
                                    <x-td>
                                        {{ $item->rol->nombre ?? '' }}
                                    </x-td>
                                    <x-td>
                                        @if (!empty($item->empresas))
                                        <div class="flex flex-wrap space-x-1 min-w-fit">
                                            {{-- {{dd($item)}} --}}

                                            @foreach ($item->empresas as $itemEmpresa)
                                                <div class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-xs flex align-middle capitalize">
                                                    {{ $itemEmpresa->nombre }}
                                                </div>
                                            @endforeach

                                        </div>
                                        @else
                                        @endif

                                    </x-td>

                                    <x-td class="py-3 w-32">
                                        <x-switch-status-table estado="{{ $item->estado }}" id="{{ $item->id }}" />
                                    </x-td>
                                    <x-td>
                                        {{ $item->last_login ? \Carbon\Carbon::parse($item->last_login)->format('Y-m-d h:i:s A') : 'Nunca' }}
                                    </x-td>
                                    <x-td class="py-3 w-16">
                                        <x-menu-option-table x-on:click="openOption=!openOption" />
                                        <div x-cloak x-show="openOption" @click.away="openOption = false"
                                            class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
                                            <x-boton-menu x-on:click="openOption=false"
                                                wire:click="enviarInvitacion('{{ $item->id }}')">Reenviar
                                                credenciales</x-boton-menu>
                                            <x-boton-menu x-on:click="openOption=false"
                                                wire:click="ver('{{ $item->id }}')">Ver</x-boton-menu>
                                            <x-boton-menu x-on:click="openOption=false"
                                                wire:click="editar('{{ $item->id }}')">Editar</x-boton-menu>
                                            <x-boton-menu x-on:click="openOption=false"
                                                wire:click="eliminar('{{ $item->id }}')">Eliminar</x-boton-menu>
                                        </div>
                                    </x-td>
                                </x-tr>
                            @empty
                            @endforelse



                            {{-- @if ($consulta)
                                @foreach ($consulta as $item)
                                    @empty($item->rol->rol_super)
                                        <x-tr x-data="{ openOption: false }">
                                            <x-td class="w-16">
                                                <input type="checkbox" wire:model.defer="eliminarItem"
                                                    x-on:click="botones=true,trasladar=true,DesactivarUser=true,activarUser=true,exportar=true,reenviar=true,eliminar=true"
                                                    value="{{ $item->id }}"
                                                    class="ml-4 border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                                            </x-td>
                                            <x-td>
                                                {{ $item->codigo_interno ?? '' }}
                                            </x-td>
                                            <x-td>
                                                {{ $item->primer_apellido ?? '' }}
                                                {{ $item->segundo_apellido ?? '' }}
                                                {{ $item->name ?? '' }}
                                                {{ $item->segundo_name ?? '' }}


                                            </x-td>
                                            <x-td class="w-32">

                                                {{ $item->documento ?? '' }}

                                            </x-td>
                                            <x-td>

                                                {{ $item->email ?? '' }}

                                            </x-td>

                                            <x-td class="w-32" wire:click="ver('{{ $item->id }}')">
                                                {{ $item->telefono ?? '' }}</x-td>

                                            <x-td wire:click="ver('{{ $item->id }}')">
                                                @if (!empty($item->rol->nombre))
                                                    <span
                                                        class="
                                                 @if ($item->rol->nombre != 'Trabajador') rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-xs flex align-middle capitalize @endif
                                        ">{{ $item->rol->nombre ?? '' }}</span>
                                                @endif
                                            </x-td>
                                            <x-td>
                                                @foreach ($item->empresas as $empresa)
                                                    <span
                                                        class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-xs flex align-middle capitalize">
                                                        {{ $empresa->nombre ?? '' }}</span>
                                                @endforeach
                                            </x-td>

                                            <x-td><a href="{{ route('cv', ['user_id' => $item->id]) }}">
                                                    <x-primary-button>Ver CV</x-primary-button>
                                                </a> </x-td>
                                            <x-td class="py-3 w-32">
                                                <x-switch-status-table estado="{{ $item->estado }}"
                                                    id="{{ $item->id }}" />
                                            </x-td>
                                            <x-td>
                                                {{ $item->last_login ? \Carbon\Carbon::parse($item->last_login)->format('Y-m-d h:i:s A') : 'Nunca' }}
                                            </x-td>

                                            <x-td class="py-3 w-16">
                                                <x-menu-option-table x-on:click="openOption=!openOption" />
                                                <div x-cloak x-show="openOption" @click.away="openOption = false"
                                                    class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
                                                    <x-boton-menu x-on:click="openOption=false"
                                                        wire:click="enviarInvitacion('{{ $item->id }}')">Reenviar
                                                        credenciales</x-boton-menu>
                                                    <x-boton-menu x-on:click="openOption=false"
                                                        wire:click="ver('{{ $item->id }}')">Ver</x-boton-menu>
                                                    <x-boton-menu x-on:click="openOption=false"
                                                        wire:click="editar('{{ $item->id }}')">Editar</x-boton-menu>
                                                    <x-boton-menu x-on:click="openOption=false"
                                                        wire:click="eliminar('{{ $item->id }}')">Eliminar</x-boton-menu>
                                                </div>
                                            </x-td>
                                        </x-tr>
                                    @endempty
                                @endforeach
                            @endif --}}
                        </x-slot>
                        <x-slot name="link">
                            {{ $consultaUsuario->links() }}

                        </x-slot>
                    </x-table>
                </x-slot>
            </x-tabla-crud>

            {{-- Modal añadir --}}
            <x-modal-crud x-show="nuevo">
                <x-slot name="titulo">Crear Usuario</x-slot>
                <x-slot name="campos">
                    <x-input-doble>
                        <x-input-with-label wire="documento" label="Documento" name="documento" id="documento"
                            type="number" value="" placeholder="Documento" maxlength="15" />

                        <x-input-with-label wire="email" label="Email" name="email" id="email" type="email"
                            value="" placeholder="Email" maxlength="50" />
                    </x-input-doble>

                    <x-input-doble>
                        <x-input-with-label wire="name" label="Primer Nombre" name="nombre" id="nombre"
                            type="text" value="" placeholder="Primer nombre" maxlength="40" />
                        <x-input-with-label wire="segundo_name" label="Segundo Nombre" name="segundo_name"
                            id="segundo_name" type="text" value="" placeholder="Segundo nombre"
                            maxlength="40" />

                    </x-input-doble>

                    <x-input-doble>
                        <x-input-with-label wire="primer_apellido" label="Primer Apellido" name="`primer_apellido"
                            id="`primer_apellido" type="text" value="" placeholder="Primer apellido"
                            maxlength="40" />
                        <x-input-with-label wire="segundo_apellido" label="Segundo Apellido" name="segundo_apellido"
                            id="segundo_apellido" type="text" value="" placeholder="Segundo apellido"
                            maxlength="40" />

                    </x-input-doble>





                    <x-input-doble>
                        <x-input-with-label wire="password" label="Contraseña" name="Contraseña" id="Contraseña"
                            type="text" value="" placeholder="Contraseña" maxlength="12" />
                        <x-select wire="rol_id" label="Rol" name="rol" id="rol" value="">
                            <x-slot name="option">
                                <option value="" selected>Seleccionar</option>
                                @foreach ($consultaRoles as $itemRol)
                                    <option value="{{ $itemRol->id }}">{{ $itemRol->nombre }}</option>
                                @endforeach
                            </x-slot>
                        </x-select>
                    </x-input-doble>

                    <div>
                        <div class="block text-gray-700 text-sm font-semibold mb-2 ">Empresas</div>

                        <div x-data="{ mostrarConsulta: false }" @click.away="mostrarConsulta = false">
                            <x-input-search name="buscar" type="search" wire="buscarItem"
                                x-on:click="mostrarConsulta = true" id="buscar" placeholder="Buscar empresas" />
                            <div x-transition x-show="mostrarConsulta" class="overflow-y-auto  max-h-28 ">
                                <div class="w-full border rounded border-gray-200">
                                    @foreach ($consultaEmpresas as $itemEmpresa)
                                        <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100 "
                                            wire:click="selectEmpresa('{{ $itemEmpresa }}')">
                                            {{ $itemEmpresa->nombre }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap space-x-1 w-56">
                            @if ($empresas)
                                @foreach ($empresas as $item)
                                    <div
                                        class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle">
                                        {{ $item['nombre'] ?? '' }}
                                        <span class="cursor-pointer my-auto capitalize"
                                            wire:click="deleteEmpresa('{{ $item['_id'] }}')">@svg('heroicon-m-x-mark', 'w-4')</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
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
                <x-slot name="titulo"> Editar Usuario </x-slot>

                @if (!empty($consultaVer))
                    <x-slot name="campos">
                        <x-input-doble>
                            <x-input-with-label wire="documento" label="Documento" name="documento" id="documento"
                                type="number" value="" placeholder="Documento" maxlength="15" />

                            <x-input-with-label wire="email" label="Email" name="email" id="email" type="email"
                                value="" placeholder="Email" maxlength="50" />
                        </x-input-doble>

                        <x-input-doble>
                            <x-input-with-label wire="name" label="Primer Nombre" name="nombre" id="nombre"
                                type="text" value="" placeholder="Primer nombre" maxlength="40" />
                            <x-input-with-label wire="segundo_name" label="Segundo Nombre" name="segundo_name"
                                id="segundo_name" type="text" value="" placeholder="Segundo nombre"
                                maxlength="40" />

                        </x-input-doble>

                        <x-input-doble>
                            <x-input-with-label wire="primer_apellido" label="Primer Apellido" name="`primer_apellido"
                                id="`primer_apellido" type="text" value="" placeholder="Primer apellido"
                                maxlength="40" />
                            <x-input-with-label wire="segundo_apellido" label="Segundo Apellido" name="segundo_apellido"
                                id="segundo_apellido" type="text" value="" placeholder="Segundo apellido"
                                maxlength="40" />

                        </x-input-doble>





                        <x-input-doble>
                            <x-input-with-label wire="password" label="Contraseña" name="Contraseña" id="Contraseña"
                                type="text" value="" placeholder="Contraseña" maxlength="12" />
                            <x-select wire="rol_id" label="Rol" name="rol" id="rol" value="">
                                <x-slot name="option">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($consultaRoles as $itemRol)
                                        <option value="{{ $itemRol->id }}">{{ $itemRol->nombre }}</option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                        </x-input-doble>

                        <div>
                            <div class="block text-gray-700 text-sm font-semibold mb-2 ">Empresas</div>

                            <div x-data="{ mostrarConsulta: false }" @click.away="mostrarConsulta = false">
                                <x-input-search name="buscar" type="search" wire="buscarItem"
                                    x-on:click="mostrarConsulta = true" id="buscar" placeholder="Buscar empresas" />
                                <div x-transition x-show="mostrarConsulta" class="overflow-y-auto  max-h-28 ">
                                    <div class="w-full border rounded border-gray-200">
                                        @foreach ($consultaEmpresas as $itemEmpresa)
                                            <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100 "
                                                wire:click="selectEmpresa('{{ $itemEmpresa }}')">
                                                {{ $itemEmpresa->nombre }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap space-x-1 w-56">
                                @if ($empresas)
                                    @foreach ($empresas as $item)
                                        <div
                                            class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle">
                                            {{ $item['nombre'] ?? '' }}
                                            <span class="cursor-pointer my-auto capitalize"
                                                wire:click="deleteEmpresa('{{ $item['_id'] }}')">@svg('heroicon-m-x-mark', 'w-4')</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="botones">
                        <x-secondary-button wire:click="limpiarInput">Cerrar</x-secondary-button>
                        <x-primary-button wire:click="actualizar('{{ $consultaVer->id }}')">Guardar</x-primary-button>
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
                <x-slot name="titulo"> Ver Usuario </x-slot>
                @if (!empty($consultaVer))
                    <x-slot name="campos">
                        <x-input-doble>
                            <x-input-with-label wire="documento" label="Documento" name="documento" id="documento"
                                type="number" value="" placeholder="Documento" maxlength="15" disabled />
                            <x-input-with-label wire="email" label="Email" name="email" id="email" type="email"
                                value="" placeholder="Email" maxlength="50" disabled/>
                        </x-input-doble>

                        <x-input-doble>
                            <x-input-with-label wire="name" label="Primer Nombre" name="nombre" id="nombre"
                                type="text" value="" placeholder="Primer nombre" maxlength="40" disabled/>
                            <x-input-with-label wire="segundo_name" label="Segundo Nombre" name="segundo_name"
                                id="segundo_name" type="text" value="" placeholder="Segundo nombre"
                                maxlength="40" disabled />
                        </x-input-doble>

                        <x-input-doble>
                            <x-input-with-label wire="primer_apellido" label="Primer Apellido" name="`primer_apellido"
                                id="`primer_apellido" type="text" value="" placeholder="Primer apellido"
                                maxlength="40" disabled/>
                            <x-input-with-label wire="segundo_apellido" label="Segundo Apellido" name="segundo_apellido"
                                id="segundo_apellido" type="text" value="" placeholder="Segundo apellido"
                                maxlength="40" disabled/>
                        </x-input-doble>

                        <x-input-doble>
                            <x-input-with-label wire="password" label="Contraseña" name="Contraseña" id="Contraseña"
                                type="text" value="" placeholder="Contraseña" maxlength="12" disabled />
                            <x-select wire="rol_id" label="Rol" name="rol" id="rol" value="" disabled>
                                <x-slot name="option">
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($consultaRoles as $itemRol)
                                        <option value="{{ $itemRol->id }}">{{ $itemRol->nombre }}</option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                        </x-input-doble>

                        <div class="block text-gray-700 text-sm font-semibold mb-2 ">Empresas</div>
                        @if (!empty($empresasVer))
                            <div class="flex flex-wrap space-x-1 min-w-fit">
                                @foreach ($empresasVer as $itemVer)
                                    <div
                                        class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-xs flex align-middle capitalize">
                                        {{ $itemVer->nombre }}</div>
                                @endforeach
                            </div>
                        @endif
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

            {{-- Modal Editar Password --}}
            <x-modal-crud x-show="editarPassword">
                <x-slot name="titulo"> Cambiar contraseña</x-slot>

                <x-slot name="campos">
                    <x-input-with-label wire="password" label="Contraseña" name="Contraseña" id="Contraseña"
                        type="text" value="" placeholder="Contraseña" maxlength="12" />
                    <div class="w-full flex mb-2 justify-center text-center">
                        <x-secondary-button wire:click="generarPassword" class="mx-auto">
                            Generar contraseña
                        </x-secondary-button>
                    </div>
                </x-slot>

                <x-slot name="botones">
                    <x-secondary-button x-on:click="editarPassword=false">
                        Cerrar
                    </x-secondary-button>
                    <x-primary-button wire:click="guardarPassword">
                        Guardar
                    </x-primary-button>
                </x-slot>

            </x-modal-crud>

            {{-- Modal Exportar --}}
            <x-modal-crud x-show="modalExportar">
                <x-slot name="titulo"> Exportar</x-slot>

                <x-slot name="campos">
                    <x-input-doble>
                        <x-primary-button wire:click="Exformato()">
                            Descargar experiencia laboral.
                        </x-primary-button>
                        <x-primary-button wire:click="Exinformacion()">
                            Información principal.
                        </x-primary-button>
                    </x-input-doble>
                </x-slot>

                <x-slot name="botones">
                    <x-secondary-button x-on:click="modalExportar=false">
                        Cerrar
                    </x-secondary-button>

                </x-slot>

            </x-modal-crud>

            {{-- Modal Exportar --}}
            <x-modal-crud x-show="modalnocertificado">
                <x-slot name="titulo">Usuarios sin certificado</x-slot>

                <x-slot name="campos">

                    @foreach ($nocertificado as $certificado)
                        <li class="text-sm font-semibold ">{{ $certificado }}</li>
                    @endforeach

                </x-slot>

                <x-slot name="botones">
                    <x-secondary-button x-on:click="modalnocertificado=false">
                        Cerrar
                    </x-secondary-button>

                </x-slot>

            </x-modal-crud>

            <x-modal-crud x-show="activarUserModal">
                <x-slot name="titulo">Cambiar estado</x-slot>
                <x-slot name="campos">
                    <div class="flex justify-evenly items-center">
                        <x-primary-button x-on:click="activarUserModal=false" class="bg-green-400 hover:bg-green-600"
                            wire:click="activar('1')">Activar usuarios</x-primary-button>
                        <x-primary-button x-on:click="activarUserModal=false" class="bg-gray-400 hover:bg-gray-600"
                            wire:click="desactivar('1')">Desactivar usuarios</x-primary-button>
                    </div>
                </x-slot>
                <x-slot name="botones">
                    <x-secondary-button x-on:click="activarUserModal=false">
                        Cerrar
                    </x-secondary-button>
                </x-slot>
            </x-modal-crud>
        </x-contenedor>
    </div>
</div>
