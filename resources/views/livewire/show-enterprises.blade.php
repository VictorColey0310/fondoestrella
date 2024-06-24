<div x-data="{
    nuevo: @entangle('nuevo'),
    editar: @entangle('editar'),
    ver: @entangle('ver'),
    download: false,
    
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
            <x-slot name="titulo"> Empresas </x-slot>
            <x-slot name="subtitulo"> Descripcion de empresas </x-slot>
            <x-slot name="filtro">
                @if ($consultaFiltro)
                    <x-select wire="filtro" label="" name="filtro" id="filtro" value="">
                        <x-slot name="option">
                            <option value="">Filtrar</option>
                            @foreach ($consultaFiltro as $itemFiltro)
                                <option value="{{ $itemFiltro->id }}">{{ $itemFiltro->nombre }}</option>
                            @endforeach
                        </x-slot>
                    </x-select>
                @endif
            </x-slot>
            <x-slot name="boton">Nuevo</x-slot>

            <x-slot name="tabla">
                {{-- Tabla lista --}}
                <x-table>
                    <x-slot name="head">
                        <x-tr class="font-semibold">
                            <th class="py-6"></th>
                            <th class=" ">Nit</th>
                            <th class=" ">Nombre</th>
                            <th class=" ">Descripcion</th>
                            <th class="">Trabajadores</th>
                            <th class=" ">CIIU</th>
                            <th class=" ">Riesgo</th>
                            <th class=" ">Color</th>
                            <th class=" ">Ciudad</th>
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

                                <x-td wire:click="ver('{{ $item->id }}')">{{ $item->nit ?? '' }}</x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">{{ $item->nombre ?? '' }}</x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">{{ $item->descripcion ?? '' }}</x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">{{ $item->numero_trabajadores ?? '' }}
                                </x-td>
                                <x-td class="w-32" wire:click="ver('{{ $item->id }}')">
                                    @if (!empty($item->ciiu))
                                        <div class="flex flex-wrap space-x-1 min-w-fit">
                                            @foreach ($item->ciiu as $itemciiu)
                                                <div
                                                    class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-xs flex align-middle capitalize">
                                                    {{ $itemciiu ?? '' }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                </x-td>
                                <x-td class="w-20" wire:click="ver('{{ $item->id }}')">{{ $item->riesgo ?? '' }}
                                </x-td>
                                <x-td class="w-20" wire:click="ver('{{ $item->id }}')">
                                    <div class=" bg-['{{ $item->color }}'] px-2 py-1 text-xs">
                                        {{ $item->color ?? '' }}</div>
                                </x-td>
                                <x-td wire:click="ver('{{ $item->id }}')">
                                    {{ $item->ciudad->municipio ?? '' }} - {{ $item->ciudad->departamento ?? '' }}
                                </x-td>
                                <x-td class="py-3 w-32">
                                    <x-switch-status-table estado="{{ $item->estado }}" id="{{ $item->id }}" />
                                </x-td>
                                <x-td class="py-3 w-16">
                                    <x-menu-option-table x-on:click="openOption=!openOption" />
                                    <div x-cloak x-show="openOption" @click.away="openOption = false"
                                        class="sm:absolute bg-white text-center shadow-gray-300 shadow-lg rounded-md sm:mr-12">
                                        <x-boton-menu x-on:click="openOption=false"
                                            wire:click="ver('{{ $item->id }}')">
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

        {{-- Modal añadir --}}
        <x-modal-crud x-show="nuevo">
            <x-slot name="titulo"> Crear empresa</x-slot>

            <x-slot name="campos">
                <x-input-doble>
                    <x-input-with-label wire="nit" label="Nit" name="nit" id="nit" value=""
                        type="tel" placeholder="Nit sin verificación" maxlength="13" />

                    <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre" type="text"
                        value="" placeholder="Nombre" maxlength="40" />
                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                        value="" type="text" placeholder="Descripción" maxlength="100" />
                    <x-select wire="categoria_id" label="Categoria" name="categoria" id="categoria" value="">
                        <x-slot name="option">
                            <option value="">Seleccionar</option>
                            @foreach ($consultaCategorias as $itemCategoria)
                                <option value="{{ $itemCategoria->id }}">
                                    {{ $itemCategoria->nombre }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>

                </x-input-doble>
                <x-input-doble>
                    <x-input-with-label wire="direccion" label="Dirección" name="direccion" id="direccion"
                        value="" type="text" placeholder="Dirección" maxlength="100" />

                    <x-select wire="ciudad_id" label="Ciudad" name="ciudad" id="ciudad" value="">
                        <x-slot name="option">
                            <option value="">Seleccionar</option>
                            @foreach ($consultaCiudades as $item)
                                <option value="{{ $item->id }}">{{ $item->municipio }} -
                                    {{ $item->departamento }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                </x-input-doble>
                <x-input-doble>

                    <x-input-with-label wire="numero_trabajadores" label="Numero trabajadores" name="trabajadores"
                        id="trabajadores" value="" type="tel" placeholder="0" maxlength="7" />
                    <div>
                        <div class="block text-gray-700 text-sm font-semibold mb-2 ">CIIU</div>
                        <div x-data="{ mostrarConsultaCiiu: false }" @click.away="mostrarConsultaCiiu = false">
                            <x-input-search name="buscar" type="search" wire="buscarItem"
                                x-on:click="mostrarConsultaCiiu = true" id="buscar" placeholder="Buscar CIIU" />
                            <div x-transition x-show="mostrarConsultaCiiu"
                                class="overflow-y-auto  max-h-28 fixed bg-white w-56">
                                <div class="w-full border rounded border-gray-200">
                                    @foreach ($consultaCiiu as $itemNuevo)
                                        <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100"
                                            wire:click="selectCiiu('{{ $itemNuevo->codigo }}')"
                                            x-on:click="mostrarConsultaCiiu = false">
                                            {{ $itemNuevo->codigo }} - {{ $itemNuevo->actividad }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <div class="flex flex-wrap space-x-1 w-56">
                            @if (!empty($ciiu))
                                @foreach ($ciiu as $itemCiiu)
                                    <div
                                        class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle capitalize">
                                        {{ $itemCiiu }}
                                        <span class="cursor-pointer my-auto"
                                            wire:click="deleteCiiu({{ $itemCiiu }})">@svg('heroicon-m-x-mark', 'w-4')</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </x-input-doble>

                <x-input-doble>


                    <x-select wire="riesgo" label="Riesgo" name="riesgo" id="riesgo" value="">
                        <x-slot name="option">
                            <option value="">Seleccionar</option>
                            <option value="1"> 1 </option>
                            <option value="2"> 2 </option>
                            <option value="3"> 3 </option>
                            <option value="4"> 4 </option>
                            <option value="5"> 5 </option>

                        </x-slot>
                    </x-select>

                    <x-input-with-label wire="color" label="Color" name="color" id="color" type="color"
                        value="" placeholder="Color" maxlength="" />




                </x-input-doble>
                <x-input-doble>

                    <x-input-file wire="logo_upload" label="Logo" name="logo" id="logo" type="file"
                        placeholder="logo" maxlength="200" value="" />
                    <div class="mb-2">
                        @if ($logo_upload)
                            <img src="{{ $logo_upload->temporaryUrl() }}" alt="Logo"
                                class="w-32 h-32 border mx-8  rounded-lg object-cover">
                        @elseif($logo)
                            <img src="{{ asset($logo) }}" alt="foto perfil"
                                class="w-32 h-32 border mx-8  rounded-lg object-cover">
                        @else
                            <div class="w-32 h-32 border mx-8  rounded-lg"></div>
                        @endif
                    </div>

                </x-input-doble>

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
            <x-slot name="titulo"> Editar Empresa </x-slot>

            @if (!empty($consultaVer))
                <x-slot name="campos">
                    <x-input-doble>
                        <x-input-with-label wire="nit" label="Nit" name="nit" id="nit"
                            value="" type="tel" placeholder="Nit" maxlength="13" />

                        <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre"
                            type="text" placeholder="" maxlength="40" value="" />
                    </x-input-doble>

                    <x-input-doble>
                        <x-input-with-label wire="descripcion" label="Descripción" name="descripcion"
                            id="descripcion" type="text" placeholder="Descripción" maxlength="100"
                            value="" />

                        <x-select wire="categoria_id" label="Categoria" name="categoria" id="categoria"
                            value="">
                            <x-slot name="option">
                                <option value="">Seleccionar</option>
                                @foreach ($consultaCategorias as $itemCategoria)
                                    <option value="{{ $itemCategoria->id }}">
                                        {{ $itemCategoria->nombre }}
                                    </option>
                                @endforeach
                            </x-slot>
                        </x-select>


                    </x-input-doble>
                    <x-input-doble>
                        <x-input-with-label wire="direccion" label="Dirección" name="direccion" id="direccion"
                            value="" type="text" placeholder="Dirección" maxlength="100" />



                        <x-select wire="ciudad_id" label="Ciudad" name="ciudad" id="ciudad" value="">
                            <x-slot name="option">
                                <option value="">Seleccionar</option>
                                @foreach ($consultaCiudades as $itemCiudad)
                                    <option value="{{ $itemCiudad->id }}">
                                        {{ $itemCiudad->municipio }} - {{ $itemCiudad->departamento }}
                                    </option>
                                @endforeach
                            </x-slot>
                        </x-select>
                    </x-input-doble>

                    <x-input-doble>

                        <x-input-with-label wire="numero_trabajadores" label="Numero trabajadores"
                            name="trabajadores" id="trabajadores" value="" type="tel" placeholder="0"
                            maxlength="7" />
                        <div>
                            <div class="block text-gray-700 text-sm font-semibold mb-2 ">CIIU</div>
                            <div x-data="{ mostrarConsultaCiiu: false }" @click.away="mostrarConsultaCiiu = false">
                                <x-input-search name="buscar" type="search" wire="buscarItem"
                                    x-on:click="mostrarConsultaCiiu = true" id="buscar"
                                    placeholder="Buscar CIIU" />
                                <div x-transition x-show="mostrarConsultaCiiu"
                                    class="overflow-y-auto  max-h-28 fixed bg-white w-56">
                                    <div class="w-full border rounded border-gray-200">
                                        @foreach ($consultaCiiu as $itemNuevo)
                                            <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100"
                                                wire:click="selectCiiu('{{ $itemNuevo->codigo }}')"
                                                x-on:click="mostrarConsultaCiiu = false">
                                                {{ $itemNuevo->codigo }} - {{ $itemNuevo->actividad }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="flex flex-wrap space-x-1 w-56">
                                @if ($ciiu)
                                    @foreach ($ciiu as $itemCiiu)
                                        <div
                                            class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle capitalize">
                                            {{ $itemCiiu }}
                                            <span class="cursor-pointer my-auto"
                                                wire:click="deleteCiiu({{ $itemCiiu }})">@svg('heroicon-m-x-mark', 'w-4')</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </x-input-doble>
                    <x-input-doble>


                        <x-select wire="riesgo" label="Riesgo" name="riesgo" id="riesgo" value="">
                            <x-slot name="option">
                                <option value="">Seleccionar</option>
                                <option value="1"> 1 </option>
                                <option value="2"> 2 </option>
                                <option value="3"> 3 </option>
                                <option value="4"> 4 </option>
                                <option value="5"> 5 </option>

                            </x-slot>
                        </x-select>


                        <x-input-with-label wire="color" label="Color" name="color" id="color"
                            type="color" value="" placeholder="Color" maxlength="" />
                    </x-input-doble>
                    <x-input-doble>

                        <x-input-file wire="logo_upload" label="Logo" name="logo" id="logo"
                            type="file" placeholder="logo" maxlength="200" value="" />
                        <div class="mb-2">
                            @if ($logo_upload)
                                <img src="{{ $logo_upload->temporaryUrl() }}" alt="Logo"
                                    class="w-32 h-32 border mx-8  rounded-lg object-cover">
                            @elseif($logo)
                                <img src="{{ asset($logo) }}" alt="foto perfil"
                                    class="w-32 h-32 border mx-8  rounded-lg object-cover">
                            @else
                                <div class="w-32 h-32 border mx-8  rounded-lg"></div>
                            @endif
                        </div>

                    </x-input-doble>

                </x-slot>

                <x-slot name="botones">
                    <x-secondary-button x-on:click="editar=false" wire:click="limpiarInput">Cerrar
                    </x-secondary-button>
                    <x-primary-button wire:click="actualizar('{{ $consultaVer->id }}')">
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
            <x-slot name="titulo"> Ver Empresa </x-slot>

            @if (!empty($consultaVer))
                <x-slot name="campos">
                    <x-input-doble>
                        <x-input-with-label wire="nit" label="Nit" name="nit" id="nit" disabled
                            value="" type="tel" placeholder="Nit sin verificación" maxlength="13" />
                        <x-input-with-label wire="nombre" label="Nombre" name="nombre" id="nombre"
                            type="text" disabled placeholder="" maxlength="0" value="" />
                    </x-input-doble>
                    <x-input-doble>
                        <x-input-with-label wire="descripcion" label="Descripción" name="descripcion"
                            id="descripcion" disabled type="text" placeholder="Descripción" maxlength="0"
                            value="" />
                        <x-input-with-label wire="categoria_id" label="Categoria" name="categoria" id="categoria"
                            disabled type="text" placeholder="Categoria" maxlength="0" value="" />
                    </x-input-doble>
                    <x-input-doble>
                        <x-input-with-label wire="direccion" label="Dirección" name="direccion" id="direccion"
                            disabled value="" type="text" placeholder="Dirección" maxlength="100" />

                        <x-input-with-label wire="ciudad_id" label="ciudad" name="ciudad" id="ciudad" disabled
                            value="" type="text" placeholder="ciudad" maxlength="100" />
                    </x-input-doble>
                    <x-input-doble>
                        <x-input-with-label wire="numero_trabajadores" label="Numero trabajadores"
                            name="trabajadores" disabled id="trabajadores" value="" type="tel"
                            placeholder="0" maxlength="7" />
                        <div>
                            <div class="block text-gray-700 text-sm font-semibold mb-2 ">CIIU</div>
                            @if (!empty($ciiu))
                                <div class="flex flex-wrap space-x-1 w-56">

                                    @foreach ($ciiu as $itemCiiu)
                                        <div
                                            class="rounded bg-blue-200 text-blue-600 my-1 px-2 py-1 text-sm flex align-middle h-auto capitalize">
                                            {{ $itemCiiu }}</div>
                                    @endforeach

                                </div>
                            @endif
                        </div>

                    </x-input-doble>
                    <x-input-doble>
                        <x-input-with-label wire="riesgo" label="Riesgo" name="riesgo" id="riesgo" disabled
                            type="text" placeholder="Riesgo" maxlength="0" value="" />

                        <x-input-with-label wire="estado" label="estado" name="estado" id="estado" disabled
                            type="text" placeholder="Estado" maxlength="0" value="" />

                    </x-input-doble>
                </x-slot>

                <x-slot name="botones">
                    <x-secondary-button x-on:click="ver=false" wire:click="limpiarInput">Cerrar
                    </x-secondary-button>
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
