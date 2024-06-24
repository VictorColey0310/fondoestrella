<div>
    <x-contenedor>
        {{-- Carga --}}
        @include('components/loading')
        <x-crud-individual>
            <x-slot name="titulo">
                Información de {{ $consulta->nombre ?? 'N/A' }}
            </x-slot>
            <x-slot name="subtitulo">
                Descripción de información de la empresa
            </x-slot>

            <x-slot name="contenido">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 w-full gap-x-3">
                    <x-input-with-label wire="nit" label="Nit" name="nit" id="nit" type="text" placeholder="Nit" maxlength="80" value="" />
                    <x-input-with-label wire="nombre" label="Nombre Empresa" name="nombre" id="nombre" type="text" placeholder="Nombre App" maxlength="20" value="" />
                    <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion" type="text" placeholder="Descripción" maxlength="100" value="" />
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
                    <x-input-with-label wire="direccion" label="Dirección" name="direccion" id="direccion" value="" type="text" placeholder="Dirección" maxlength="100" />
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
                    <x-select wire="numero_trabajadores" label="Numero trabajadores" name="trabajadores" id="trabajadores" value="">
                        <x-slot name="option">
                            <option value="">Rango de trabajadores</option>
                            <option value="1 - 10">1 - 10</option>
                            <option value="11 - 50">11 - 50</option>
                            <option value="51+">51+</option>
                        </x-slot>
                    </x-select>
                    <div class="relative w-full">
                        <div class="block text-gray-700 text-sm font-semibold mb-2 w-full">CIIU</div>
                        <div class="w-full" x-data="{ mostrarConsultaCiiu: false }" @click.away="mostrarConsultaCiiu = false">
                            <x-input-search name="buscar" type="search" wire="buscarItem" x-on:click="mostrarConsultaCiiu = true" id="buscar" placeholder="Buscar CIIU" />
                            <div x-transition x-show="mostrarConsultaCiiu" class="overflow-y-auto absolute  max-h-28 bg-white w-full">
                                <div class="w-full border rounded border-gray-200">
                                    @foreach ($consultaCiiu as $itemNuevo)
                                        <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100" wire:click="selectCiiu('{{ $itemNuevo->codigo }}')" x-on:click="mostrarConsultaCiiu = false">{{ $itemNuevo->codigo }} - {{ $itemNuevo->actividad }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap space-x-1 w-56">
                            @if ($ciiu)
                                @foreach ($ciiu as $itemCiiu)
                                    <div class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-xs flex align-middle capitalize">
                                        {{ $itemCiiu }}
                                        <span class="cursor-pointer my-auto" wire:click="deleteCiiu({{ $itemCiiu }})">@svg('heroicon-m-x-mark', 'w-4')</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
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
                    <x-input-with-label wire="color" label="Color" name="color" id="color" type="color" value="" placeholder="Color" maxlength=""/>
                    <x-input-file wire="logo_upload" label="Logo" name="logo" id="logo" type="file" placeholder="logo" maxlength="200" value="" />
                    <div class="mb-2">
                        @if ($logo_upload)
                            <img src="{{ $logo_upload->temporaryUrl() }}" alt="Logo" class="w-32 h-32 border mx-8  rounded-lg object-cover">
                        @elseif($logo)
                            <img src="{{ asset($logo) }}" alt="foto perfil" class="w-32 h-32 border mx-8  rounded-lg object-cover">
                        @else
                            <div class="w-32 h-32 border mx-8  rounded-lg"></div>
                        @endif
                    </div>
                </div>
            </x-slot>

            <x-slot name="boton">
                <x-primary-button wire:click="actualizar">
                    Guardar
                </x-primary-button>
            </x-slot>
        </x-crud-individual>

    </x-contenedor>
</div>
