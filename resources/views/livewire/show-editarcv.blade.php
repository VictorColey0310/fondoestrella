<div>
    <x-contenedor>
        {{-- Carga --}}
        @include('components/loading')
        <x-crud-individual>
            <x-slot name="titulo">
            </x-slot>
            <x-slot name="subtitulo">
            </x-slot>
            <x-slot name="contenido" class="">

                <div x-data="{ informacion_modal: @entangle('informacion_modal'), certificado: @entangle('certificado'), nivel_modal: @entangle('nivel_modal'), experiencia: false, noformal: false }" class="w-full max-w-3xl mx-auto">
                    <div class="flex flex-col md:flex-row space-y-1 space-x-2 w-full ">
                        <div class="flex items-center justify-center w-auto cursor-pointer  px-4 h-16  rounded-lg transform skew-x-12 hover:scale-105 transition-transform duration-300"
                            x-bind:class="{
                                'bg-gradient-to-br from-gray-400 to-gray-600': !
                                    informacion_modal,
                                'bg-gradient-to-br from-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}90] to-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}] shadow-inner': informacion_modal
                            }">
                            <span class="transform -skew-x-12 text-white font-semibold leading-5"
                                x-on:click="informacion_modal = true , certificado= false, nivel_modal= false, experiencia= false, noformal= false ">INFORMACIÓN
                                BASICA</span>
                        </div>
                        <div class="flex items-center justify-center w-auto cursor-pointer px-4 h-16 rounded-lg transform skew-x-12 hover:scale-105 transition-transform duration-300"
                            x-bind:class="{
                                'bg-gradient-to-br from-gray-400 to-gray-600': !
                                    certificado,
                                'bg-gradient-to-br from-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}90] to-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}] shadow-inner': certificado
                            }"
                            x-on:click="informacion_modal = false, certificado = true, nivel_modal = false, experiencia = false, noformal = false">
                            <span class="transform -skew-x-12 text-white font-semibold leading-5">CERTIFICADOS</span>
                        </div>

                        <div class="flex items-center justify-center w-auto  cursor-pointer px-4 h-16  rounded-lg transform skew-x-12 hover:scale-105 transition-transform duration-300"
                            x-bind:class="{
                                'bg-gradient-to-br from-gray-400 to-gray-600': !
                                    nivel_modal,
                                'bg-gradient-to-br from-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}90] to-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}] shadow-inner': nivel_modal
                            }">
                            <span class="transform -skew-x-12 text-white font-semibold leading-5"
                                x-on:click="informacion_modal = false , certificado= false, nivel_modal= true, experiencia= false, noformal= false ">NIVEL
                                EDUCATIVO</span>
                        </div>
                        <div class="flex items-center justify-center w-auto  cursor-pointer px-4 h-16  rounded-lg transform skew-x-12 hover:scale-105 transition-transform duration-300"
                            x-bind:class="{
                                'bg-gradient-to-br from-gray-400 to-gray-600': !
                                    experiencia,
                                'bg-gradient-to-br from-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}90] to-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}] shadow-inner': experiencia
                            }">
                            <span class="transform -skew-x-12 text-white font-semibold leading-5"
                                x-on:click="informacion_modal = false , certificado= false, nivel_modal= false, experiencia= true, noformal= false ">EXPERIENCIA
                                LABORAL</span>
                        </div>
                        <div class="flex items-center justify-center w-auto cursor-pointer  px-4 h-16  rounded-lg transform skew-x-12 hover:scale-105 transition-transform duration-300"
                            x-bind:class="{
                                'bg-gradient-to-br from-gray-400 to-gray-600': !
                                    noformal,
                                'bg-gradient-to-br from-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}90] to-[{{ config('app.empresa') ? config('app.empresa')->color : \App\Models\Apariencia::first()->color_boton }}] shadow-inner': noformal
                            }">
                            <span class="transform -skew-x-12 text-white font-semibold  leading-5"
                                x-on:click="informacion_modal = false , certificado= false, nivel_modal= false, experiencia= false, noformal= true ">EDUCACIÓN
                                NO FORMAL</span>
                        </div>
                    </div>

                    <div x-cloak x-transition.1000ms x-show="informacion_modal" class="py-4">
                        <x-input-doble>
                            <x-input-doble>
                                {{-- Nombre --}}
                                <div class="w-full">
                                    <x-input-with-label wire="codigo_interno" label="Codigo del trabajador"
                                        name="codigo_interno" id="codigo_interno" type="text" placeholder="Codigo"
                                        maxlength="10" value="" />
                                    <x-input-with-label wire="primer_apellido" label="Primer Apellido" name="nombre"
                                        id="nombre" type="text" placeholder="Primero apellido" maxlength="100"
                                        value="" />
                                </div>
                                <div class="w-full">
                                    <x-input-with-label wire="name" label="Primer Nombre" name="nombre"
                                        id="nombre" type="text" placeholder="Primer nombre" maxlength="100"
                                        value="" />

                                    <x-input-with-label wire="segundo_name" label="Segundo Nombre" name="segundo_nombre"
                                        id="nombre" type="text" placeholder="Segundo nombre" maxlength="100"
                                        value="" />
                                </div>
                            </x-input-doble>

                            <div>
                                <x-input-file wire="foto" label="Foto perfil" name="foto perfil" id="foto perfil"
                                    type="file" placeholder="foto perfil" maxlength="200" value="" />
                                <div class="mb-2">
                                    @if ($foto)
                                        <img src="{{ $foto->temporaryUrl() }}" alt="foto perfil"
                                            class="w-32 h-32 border mx-8  rounded-lg object-cover">
                                    @elseif($foto_perfil)
                                        <img src="{{ asset($foto_perfil) }}" alt="foto perfil"
                                            class="w-32 h-32 border mx-8  rounded-lg object-cover">
                                    @else
                                        <div class="w-32 h-32 border mx-8  rounded-lg"></div>
                                    @endif
                                </div>
                            </div>
                        </x-input-doble>

                        <x-input-doble>
                            <x-input-with-label wire="segundo_apellido" label="Segundo Apellido" name="nombre"
                                id="nombre" type="text" placeholder="Segundo apellido" maxlength="100"
                                value="" />
                            {{-- fecha_nacimiento --}}
                            <x-input-with-label wire="fecha_nacimiento" label="Fecha nacimiento" name="fecha_nacimiento"
                                id="fecha_nacimiento" type="date" placeholder="fecha_nacimiento" maxlength="15"
                                value="" />

                            {{-- tipo documento --}}
                            <x-select wire="tipo_documento" label="Tipo de documento" name="tipo_documento"
                                id="tipo_documento" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($consultaDocumentos as $documento)
                                        <option value="{{ $documento }}">
                                            {{ $documento }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                            {{-- Documento --}}
                            <x-input-with-label wire="documento" label="No. Documento" name="documento" id="documento"
                                type="tel" placeholder="documento" maxlength="15" value="" />
                            {{-- municipio --}}

                        </x-input-doble>
                        <x-input-doble>
                            <div class="item-end">
                                <div class="my-1 w-56 relative">
                                    <div class="block text-gray-700 text-sm font-semibold mb-2 ">Municipio expedición
                                        del documento</div>

                                    <div class="  ">

                                        @if ($ciudadExpedicion)
                                            <div>
                                                <div
                                                    class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle ">
                                                    {{ $ciudadExpedicion['municipio'] ?? '' }} -
                                                    {{ $ciudadExpedicion['departamento'] ?? '' }}
                                                    <span class="cursor-pointer my-auto capitalize"
                                                        wire:click="deleteExpedicion('{{ $ciudadExpedicion['_id'] }}')">@svg('heroicon-m-x-mark', 'w-4')</span>
                                                </div>
                                                <div class="text-white">file</div>
                                            </div>
                                        @else
                                            <div x-data="{ VerExpedicion: false }" @click.away="VerExpedicion = false">
                                                <x-input-search name="buscar" type="search"
                                                    x-on:click="VerExpedicion =true" wire="buscarItem" id="buscar"
                                                    placeholder="Buscar ciudad" />
                                                <div x-transition x-cloak x-show="VerExpedicion"
                                                    class="overflow-y-auto  max-h-8  bg-white  max-w-sm absolute  bottom-0 right-0   drop-shadow-2xl border-lg  border-orange-600 border-2 ">
                                                    <div class="w-full border rounded border-gray-200">

                                                        @foreach ($consultaCiudades as $itemCiudad)
                                                            <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100 "
                                                                wire:click="selectExpedicion({{ $itemCiudad }})"
                                                                x-on:click="VerExpedicion=false">
                                                                {{ $itemCiudad->municipio }} -
                                                                {{ $itemCiudad->departamento }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="text-white">file</div>
                                            </div>

                                        @endif

                                        <div class="flex justify-between text-sm opacity-80">
                                            <div>
                                                @error($municipioNac_id)
                                                    <div class="text-red-500 ">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- fecha_expedicion_cedula --}}
                            <x-input-with-label wire="fecha_exp" label="Fecha expedición documento" name="fecha_exp"
                                id="fecha_exp" type="date" placeholder="Fecha_ expedicion" maxlength="15"
                                value="" />
                            {{-- estado_civil --}}
                            <x-select wire="estado_civil" label="Estado civil" name="estado_civil" id="estado_civil"
                                value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($consultaEstado as $estadoCivil)
                                        <option value="{{ $estadoCivil }}">
                                            {{ $estadoCivil }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>

                        </x-input-doble>

                        <x-input-doble>


                            {{-- nacionalidad --}}
                            <x-select wire="nacionalidad" label="Nacionalidad" name="nacionalidad" id="nacionalidad"
                                value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($consultaNacionalidad as $itemnacionalidad)
                                        <option value="{{ $itemnacionalidad }}">
                                            {{ $itemnacionalidad }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                            @if ($nacionalidad == 'otro')
                                <x-input-with-label wire="nacionalidad_otro" label="¿Cual nacionalidad?"
                                    name="Nacionalidad" id="Nacionalidad" type="text"
                                    placeholder="Otra nacionalidad" maxlength="100" value="" />
                            @else
                                <x-input-with-label wire="nacionalidad_otro" label="¿Cual nacionalidad?"
                                    name="Nacionalidad" id="Nacionalidad" type="text"
                                    placeholder="Otra nacionalidad" maxlength="100" value="" disabled />
                            @endif

                            <div class="item-end">
                                @if ($nacionalidad == 'otro')
                                    <x-select wire="municipioNac_id" label="Ciudad de nacimiento" name="ciudad"
                                        id="ciudad" value="" disabled>
                                        <x-slot name="option">
                                            <option value="">Seleccionar</option>
                                            @foreach ($consultaCiudades as $ciudad)
                                                <option value="{{ $ciudad->id }}">
                                                    {{ $ciudad->municipio }} - {{ $ciudad->departamento }}
                                                </option>
                                            @endforeach
                                        </x-slot>
                                    </x-select>
                                @else
                                    <div class="my-1 w-56 relative">
                                        <div class="block text-gray-700 text-sm font-semibold mb-2 ">Ciudad de
                                            nacimiento</div>

                                        <div class="  ">

                                            @if ($ciudadNacimiento)
                                                <div>
                                                    <div
                                                        class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle ">
                                                        {{ $ciudadNacimiento['municipio'] ?? '' }} -
                                                        {{ $ciudadNacimiento['departamento'] ?? '' }}
                                                        <span class="cursor-pointer my-auto capitalize"
                                                            wire:click="deleteItem('{{ $ciudadNacimiento['_id'] }}')">@svg('heroicon-m-x-mark', 'w-4')</span>
                                                    </div>
                                                    <div class="text-white">file</div>
                                                </div>
                                            @else
                                                <div x-data="{ verCiudadNac: false }" @click.away="verCiudadNac = false">
                                                    <x-input-search name="buscar" type="search"
                                                        x-on:click="verCiudadNac =true" wire="buscarItem"
                                                        id="buscar" placeholder="Buscar ciudad" />
                                                    <div x-transition x-cloak x-show="verCiudadNac"
                                                        class="overflow-y-auto  max-h-8  bg-white  max-w-sm absolute  bottom-0 right-0   drop-shadow-2xl border-lg  border-orange-600 border-2 ">
                                                        <div class="w-full border rounded border-gray-200">

                                                            @foreach ($consultaCiudades as $itemCiudad)
                                                                <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100 "
                                                                    wire:click="selectItem({{ $itemCiudad }})"
                                                                    x-on:click="verCiudadNac=false">
                                                                    {{ $itemCiudad->municipio }} -
                                                                    {{ $itemCiudad->departamento }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="text-white">file</div>
                                                </div>

                                            @endif

                                            <div class="flex justify-between text-sm opacity-80">
                                                <div>
                                                    @error($municipioNac_id)
                                                        <div class="text-red-500 ">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                @endif
                            </div>
                        </x-input-doble>
                        <x-input-doble>

                            {{-- genero --}}
                            <x-select wire="genero" label="Genero" name="genero" id="genero" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($consultaGenero as $genero)
                                        <option value="{{ $genero }}">
                                            {{ $genero }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                            {{-- grupo --}}
                            <x-select wire="grupo_sanguineo" label="Grupo sanguineo" name="grupo_sanguineo"
                                id="grupo_sanguineo" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($consultaGrupo as $grupo_sanguineo)
                                        <option value="{{ $grupo_sanguineo }}">
                                            {{ $grupo_sanguineo }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>

                            {{-- hijos --}}
                            <x-select wire="numero_hijos" label="Numero de hijos" name="numero_hijos"
                                id="numero_hijos" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($consultaHijos as $hijos)
                                        <option value="{{ $hijos }}">
                                            {{ $hijos }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                            {{-- Rango edad --}}
                            @if ($numero_hijos != '0')
                                <x-select wire="rango_edad" label="Rango edad hijos" name="rango_edad"
                                    id="rango_edad" value="">
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>
                                        @foreach ($consultaEdad as $edad)
                                            <option value="{{ $edad }}">
                                                {{ $edad }}
                                            </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>
                            @else
                                <x-select wire="rango_edad" label="Rango edad" name="rango_edad" id="rango_edad"
                                    disabled value="">
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>
                                        @foreach ($consultaEdad as $edad)
                                            <option value="{{ $edad }}">
                                                {{ $edad }}
                                            </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>
                            @endif

                        </x-input-doble>
                        <x-input-doble>
                            {{-- Cabeza de familia --}}
                            @if ($numero_hijos != '0')
                                <x-select wire="cabeza_familia" label="Es madre o padre cabeza de familia"
                                    name="cabeza_familia" id="cabeza_familia" value="">
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>

                                        <option value="Si">
                                            Si
                                        </option>
                                        <option value="No">
                                            No
                                        </option>

                                    </x-slot>
                                </x-select>
                            @else
                                <x-select wire="cabeza_familia" label="Es madre o padre cabeza de familia"
                                    name="cabeza_familia" id="cabeza_familia" value="" disabled>
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>

                                        <option value="Si">
                                            Si
                                        </option>
                                        <option value="No">
                                            No
                                        </option>

                                    </x-slot>
                                </x-select>
                            @endif
                            {{-- poblacion --}}
                            <x-select wire="poblacion_vulnerable"
                                label="Pertecene a alguna de las siguientes poblaciones" name="poblacion_vulnerable"
                                id="poblacion_vulnerable" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($consultaPoblaciones as $poblacion)
                                        <option value="{{ $poblacion }}">
                                            {{ $poblacion }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                            {{-- cargo --}}
                            <x-select wire="cargoAspira_id" label="Cargo" name="cargoAspira_id" id="cargoAspira_id"
                                value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($ConsultaCargos as $cargo)
                                        <option value="{{ $cargo->id }}">
                                            {{ $cargo->nombre }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>


                        </x-input-doble>

                        <x-input-doble>
                            {{-- Servicio publico --}}
                            <x-select wire="servicio_public" label="Esta postulado en servicio público de empleo ?"
                                name="servicio_public" id="servicio_public" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>

                                    <option value="Si">
                                        Si
                                    </option>
                                    <option value="No">
                                        No
                                    </option>

                                </x-slot>
                            </x-select>

                            {{-- nombre contigencia --}}
                            <x-input-with-label wire="nombre_cont_emerg" label="Nombre contacto de emergencia"
                                name="nombre_cont_emerg" id="nombre_cont_emerg" type="text"
                                placeholder="nombre_cont_emerg" maxlength="60" value="" />
                            {{-- numero contingencia --}}
                            <x-input-with-label wire="numero_cont_emerg" label="Numero contacto de emergencia"
                                name="numero_cont_emerg" id="numero_cont_emerg" type="tel"
                                placeholder="numero_cont_emerg" maxlength="10" value="" />


                        </x-input-doble>

                        <div class="py-2 font-semibold text-lg border-b border-gray-200 my-4 bg-gray-50 px-4 ">DATOS DE
                            CONTACTO</div>

                        <x-input-doble>

                            <div class="item-end">
                                <div class="my-1 w-56 relative">
                                    <div class="block text-gray-700 text-sm font-semibold mb-2 ">Municipio de
                                        residencia</div>

                                    <div class="  ">

                                        @if ($ciudadResidencia)
                                            <div>
                                                <div
                                                    class="rounded bg-green-200 text-green-600 my-1 px-2 py-1 text-sm flex align-middle ">
                                                    {{ $ciudadResidencia['municipio'] ?? '' }} -
                                                    {{ $ciudadResidencia['departamento'] ?? '' }}
                                                    <span class="cursor-pointer my-auto capitalize"
                                                        wire:click="deleteResidencia('{{ $ciudadResidencia['_id'] }}')">@svg('heroicon-m-x-mark', 'w-4')</span>
                                                </div>
                                                <div class="text-white">file</div>
                                            </div>
                                        @else
                                            <div x-data="{ verResidencia: false }" @click.away="verResidencia = false">
                                                <x-input-search name="buscar" type="search"
                                                    x-on:click="verResidencia =true" wire="buscarItem" id="buscar"
                                                    placeholder="Buscar ciudad" />
                                                <div x-transition x-cloak x-show="verResidencia"
                                                    class="overflow-y-auto  max-h-8  bg-white  max-w-sm absolute  bottom-0 right-0   drop-shadow-2xl border-lg  border-orange-600 border-2 ">
                                                    <div class="w-full border rounded border-gray-200">

                                                        @foreach ($consultaCiudades as $itemCiudad)
                                                            <div class="text-sm cursor-pointer hover:bg-gray-100 w-full py-1 px-2 border-b border-gray-100 "
                                                                wire:click="selectResidencia({{ $itemCiudad }})"
                                                                x-on:click="verResidencia=false">
                                                                {{ $itemCiudad->municipio }} -
                                                                {{ $itemCiudad->departamento }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="text-white">file</div>
                                            </div>

                                        @endif

                                        <div class="flex justify-between text-sm opacity-80">
                                            <div>
                                                @error($municipioResidencia_id)
                                                    <div class="text-red-500 ">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- barrio --}}
                            <x-input-with-label wire="barrio" label="Barrio" name="barrio" id="barrio"
                                type="text" placeholder="Barrio" maxlength="60" value="" />

                            {{-- telefono --}}
                            <x-input-with-label wire="telefono_contacto" label="Telefono de contacto"
                                name="telefono_contacto" id="telefono_contacto" type="tel"
                                placeholder="telefono_contacto" maxlength="10" value="" />


                        </x-input-doble>
                        <x-input-with-label wire="direccion_residencia" label="Dirección de residencia"
                            name="direccion_residencia" id="direccion_residencia" type="text"
                            placeholder="Dirección" maxlength="100" value="" />
                        <x-input-with-label wire="observaciones" label="Observaciones" name="observaciones"
                            id="observaciones" type="text" placeholder="observaciones" maxlength="100"
                            value="" />


                        {{-- <div class="py-2 font-semibold text-lg border-b border-gray-200 my-4 bg-gray-50 px-4">PERFIL
                            LABORAL</div>

                        <x-textarea-label wire="perfil_laboral" label="Describa su perfil laboral"
                            name="perfil_laboral" id="perfil_laboral" type="text" value=""
                            placeholder="Perfil laboral" maxlength="1000" /> --}}

                        <x-input-doble>
                            {{-- situacion laboral --}}
                            <x-select wire="situacion_laboral" label="Situación laboral actual"
                                name="situacion_laboral" id="situacion_laboral" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($consultaSituacion as $situacion)
                                        <option value="{{ $situacion }}">
                                            {{ $situacion }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                            {{-- medio de transporte --}}
                            <x-select wire="medio_transporte" label="Tiene medio de transporte"
                                name="medio_transporte" id="medio_transporte" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>

                                    <option value="Si">
                                        Si
                                    </option>
                                    <option value="No">
                                        No
                                    </option>

                                </x-slot>
                            </x-select>
                        </x-input-doble>
                        <br>
                        <div class="flex justify-end space-x-2">
                            <x-primary-button wire:click="guardar()">
                                Guardar
                            </x-primary-button>

                            {{-- <x-secondary-button class="flex"
                                x-on:click="informacion = false , certificado= true, nivel= false, experiencia= false, noformal= false ">
                                Siguiente
                                <div class="px-1 my-auto ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>

                                </div>
                            </x-secondary-button> --}}
                            <x-secondary-button class="flex" wire:click="guardarBasico"
                                x-on:click="experiencia= false, noformal= false">
                                Siguiente
                                <div class="px-1 my-auto ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>

                                </div>
                            </x-secondary-button>
                        </div>

                    </div>

                    <div x-cloak x-transition.1000ms x-show="certificado" class="py-4 ">

                        <div class="py-2 font-semibold text-lg border-b border-gray-200 my-4 bg-gray-50 px-4">
                            Certificaciones y/o
                            cursos requeridos para el desempeño del cargo</div>
                        <div class="text-sm my-4">A continuación encontrará una serie de preguntas relacionadas con
                            Certificaciones y/o
                            cursos requeridos para el Desempeño del cargo para el cual se encuentra en proceso. Si
                            alguno de los cursos o certificaciones no Aplica para su cargo, favor abstenerse de
                            responder.</div>

                        {{-- Estado territorio --}}
                        <x-select wire="estado_territorio"
                            label="Indique el estado en el cual se encuentra su Certificado de Territorialidad del Distrito de Barrancabermeja"
                            name="estado_territorio" id="estado_territorio" value="">
                            <x-slot name="option">
                                <option value="">Seleccionar</option>
                                @foreach ($consultaTerritorio as $territorio)
                                    <option value="{{ $territorio }}">
                                        {{ $territorio }}
                                    </option>
                                @endforeach
                            </x-slot>
                        </x-select>

                        <x-input-doble>

                            <x-select wire="curso_alturas" label="Cuenta con curso en alturas" name="curso_alturas"
                                id="curso_alturas" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($consultaCurso as $curso)
                                        <option value="{{ $curso }}">
                                            {{ $curso }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>

                            @if ($curso_alturas == 'Sí')
                                {{-- fecha_vencimiento --}}
                                <x-input-with-label wire="fecha_vencimiento"
                                    label="Fecha vencimiento certificado en alturas" name="fecha_vencimiento"
                                    id="fecha_vencimiento" type="date" placeholder="fecha_vencimiento"
                                    maxlength="15" value="" />

                                <x-input-file wire="certificado_alturas_upload" label="Certificado"
                                    name="Certificado" id="Certificado" type="file" placeholder="Certificado"
                                    maxlength="200" value="" />

                                @if ($certificado_alturas)
                                    <div class="flex justify-between space-x-2 align-middle my-auto items-center">
                                        <a target="_blank" href="{{ asset($this->certificado_alturas) }}">
                                            <x-primary-button>Ver</x-primary-button>
                                        </a>
                                        <div class="">
                                            <x-primary-button class="bg-red-500" wire:click="eliminarCertificado()">
                                                Eliminar
                                            </x-primary-button>
                                        </div>
                                    </div>
                                @endif
                            @else
                                {{-- fecha_vencimiento --}}
                                <x-input-with-label wire="fecha_vencimiento"
                                    label="Fecha vencimiento certificado en alturas" name="fecha_vencimiento"
                                    id="fecha_vencimiento" type="date" placeholder="fecha_vencimiento"
                                    maxlength="15" value="" disabled />

                                <x-input-file wire="certificado_alturas_upload" label="Certificado"
                                    name="Certificado" id="Certificado" type="file" placeholder="Certificado"
                                    maxlength="200" value="" disabled />

                                @if ($certificado_alturas)
                                    <div class="flex justify-between space-x-2 align-middle my-auto items-center">
                                        <a target="_blank" href="{{ asset($certificado_alturas) }}">
                                            <x-primary-button>Ver</x-primary-button>
                                        </a>
                                        <div class="">
                                            <x-primary-button disabled class="bg-red-500"
                                                wire:click="eliminarCertificado()">
                                                Eliminar
                                            </x-primary-button>
                                        </div>
                                    </div>
                                @endif

                            @endif



                        </x-input-doble>

                        <x-input-doble>

                            {{-- espacios_cofinados --}}
                            <x-select wire="curso_espacios_conf" label="Cuenta con curso en Espacios Confinados"
                                name="curso_espacios_conf" id="curso_espacios_conf" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    <option value="Sí">
                                        Sí
                                    </option>
                                    <option value="No">
                                        No
                                    </option>
                                    <option value="No aplica">
                                        No aplica
                                    </option>
                                </x-slot>
                            </x-select>

                            {{-- nivel_curso_confinados --}}
                            @if ($curso_espacios_conf == 'Sí')
                                <x-select wire="nivel_curso_espacios" label="Nivel curso en Espacios Confinados"
                                    name="nivel_curso_espacios" id="nivel_curso_espacios" value="">
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>
                                        @foreach ($consultaEspacios as $espacios)
                                            <option value="{{ $espacios }}">
                                                {{ $espacios }}
                                            </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>
                                <x-input-with-label wire="fecha_vencimiento_confi"
                                    label="Fecha vencimiento espacios confinados" name="fecha_vencimiento"
                                    id="fecha_vencimiento_confi" type="date" placeholder="Fecha vencimiento"
                                    maxlength="15" value="" />

                                <x-input-file wire="certificado_confinados_upload" label="Certificado"
                                    name="Certificado" id="Certificado" type="file" placeholder="Certificado"
                                    maxlength="200" value="" />

                                @if ($certificado_confinados)
                                    <div class="flex justify-between space-x-2 align-middle my-auto items-center">
                                        <a target="_blank" href="{{ asset($certificado_confinados) }}">
                                            <x-primary-button>Ver</x-primary-button>
                                        </a>
                                        <div class="">
                                            <x-primary-button class="bg-red-500"
                                                wire:click="eliminarCertificadoConfi()">
                                                Eliminar
                                            </x-primary-button>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <x-select wire="nivel_curso_espacios" label="Nivel curso en Espacios Confinados"
                                    name="nivel_curso_espacios" id="nivel_curso_espacios" value="" disabled>
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>
                                        @foreach ($consultaEspacios as $espacios)
                                            <option value="{{ $espacios }}">
                                                {{ $espacios }}
                                            </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>
                                <x-input-with-label wire="fecha_vencimiento_confi"
                                    label="Fecha vencimiento espacios confinados" name="fecha_vencimiento"
                                    id="fecha_vencimiento_confi" type="date" placeholder="Fecha vencimiento"
                                    maxlength="15" value="" disabled />

                                <x-input-file wire="certificado_confinados_upload" label="Certificado"
                                    name="Certificado" id="Certificado" type="file" placeholder="Certificado"
                                    maxlength="200" value="" disabled />

                                @if ($certificado_confinados)
                                    <div class="flex justify-between space-x-2 align-middle my-auto items-center">
                                        <a target="_blank" href="{{ asset($certificado_confinados) }}">
                                            <x-primary-button>Ver</x-primary-button>
                                        </a>
                                        <div class="">
                                            <x-primary-button class="bg-red-500"
                                                wire:click="eliminarCertificadoConfi()" disabled>
                                                Eliminar
                                            </x-primary-button>
                                        </div>
                                    </div>
                                @endif
                            @endif


                        </x-input-doble>

                        <x-input-doble>

                            {{-- nccer --}}
                            <x-select wire="certificado_nccer" label="Tiene certificado NCCER"
                                name="certificado_nccer" id="certificado_nccer" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    <option value="Sí">
                                        Si
                                    </option>
                                    <option value="No">
                                        No
                                    </option>
                                </x-slot>
                            </x-select>
                            @if ($certificado_nccer == 'Sí')
                                {{-- especialidad nncer --}}
                                <x-select wire="especialidad_nccer" label="Especialidad NCCER"
                                    name="especialidad_nccer" id="especialidad_nccer" value="">
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>
                                        @foreach ($consultaEspecialidad as $especialidad)
                                            <option value="{{ $especialidad }}">
                                                {{ $especialidad }}
                                            </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>

                                {{-- nivel_nccer --}}
                                <x-select wire="nivel_nccer" label="Nivel NCCER" name="nivel_nccer" id="nivel_nccer"
                                    value="">
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>
                                        @foreach ($NivelCCNER as $nivel)
                                            <option value="{{ $nivel }}">
                                                {{ $nivel }}
                                            </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>
                            @else
                                <x-select wire="especialidad_nccer" label="Especialidad NCCER"
                                    name="especialidad_nccer" id="especialidad_nccer" value="" disabled>
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>
                                        @foreach ($consultaEspecialidad as $especialidad)
                                            <option value="{{ $especialidad }}">
                                                {{ $especialidad }}
                                            </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>

                                {{-- nivel_nccer --}}
                                <x-select wire="nivel_nccer" label="Nivel NCCER" name="nivel_nccer" id="nivel_nccer"
                                    disabled value="">
                                    <x-slot name="option">
                                        <option value="">Seleccionar</option>
                                        @foreach ($NivelCCNER as $nivel)
                                            <option value="{{ $nivel }}">
                                                {{ $nivel }}
                                            </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>

                            @endif

                        </x-input-doble>
                        <x-input-doble>
                            @if ($certificado_nccer == 'Sí')
                                <x-input-with-label wire="fecha_vencimiento_nccer" label="Fecha vencimiento NCCER"
                                    name="fecha_vencimiento" id="fecha_vencimiento_nccer" type="date"
                                    placeholder="Fecha vencimiento" maxlength="15" value="" />

                                <x-input-file wire="certificado_nccer_upload" label="Certificado" name="Certificado"
                                    id="Certificado" type="file" placeholder="Certificado" maxlength="200"
                                    value="" />

                                @if ($certificado_arc_nccer)
                                    <div class="flex justify-between space-x-2 align-middle my-auto items-center">
                                        <a target="_blank" href="{{ asset($certificado_arc_nccer) }}">
                                            <x-primary-button>Ver</x-primary-button>
                                        </a>
                                        <div class="">
                                            <x-primary-button class="bg-red-500"
                                                wire:click="eliminarCertificadoNccer()">
                                                Eliminar
                                            </x-primary-button>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <x-input-with-label wire="fecha_vencimiento_nccer" label="Fecha vencimiento NCCER"
                                    name="fecha_vencimiento" id="fecha_vencimiento_nccer" type="date"
                                    placeholder="Fecha vencimiento" maxlength="15" value="" disabled />

                                <x-input-file wire="certificado_nccer_upload" label="Certificado" name="Certificado"
                                    id="Certificado" type="file" placeholder="Certificado" maxlength="200"
                                    value="" disabled />

                                @if ($certificado_arc_nccer)
                                    <div class="flex justify-between space-x-2 align-middle my-auto items-center">
                                        <a target="_blank" href="{{ asset($certificado_arc_nccer) }}" disabled>
                                            <x-primary-button>Ver</x-primary-button>
                                        </a>
                                        <div class="">
                                            <x-primary-button class="bg-red-500"
                                                wire:click="eliminarCertificadoNccer()" disabled>
                                                Eliminar
                                            </x-primary-button>
                                        </div>
                                    </div>
                                @endif

                            @endif
                        </x-input-doble>

                        <div class="flex justify-between my-2">
                            <x-secondary-button class="flex"
                                x-on:click="informacion_modal = true , certificado= false, nivel_modal= false, experiencia= false, noformal= false ">
                                <div class="px-1 my-auto transform rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>

                                </div>
                                Anterior

                            </x-secondary-button>

                            <div class="flex justify-end space-x-2">
                                <x-primary-button wire:click="guardarCertificados()">
                                    Guardar
                                </x-primary-button>
                                {{-- <x-secondary-button class="flex"
                                    x-on:click="informacion_modal = false , certificado= false, nivel_modal= true, experiencia= false, noformal= false ">
                                    Siguiente
                                    <div class="px-1 my-auto ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>

                                    </div>
                                </x-secondary-button> --}}
                                <x-secondary-button class="flex" wire:click="guardarCertificado"
                                    x-on:click="experiencia= false, noformal= false">
                                    Siguiente
                                    <div class="px-1 my-auto ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>

                                    </div>
                                </x-secondary-button>
                            </div>
                        </div>




                    </div>

                    <div x-cloak x-transition.1000ms x-show="nivel_modal" class="py-4">
                        @foreach ($consultaNivel as $nivelEducativo)
                            <div class="border pb-3 px-3 rounded-lg my-2">
                                <x-input-doble>
                                    <div
                                        class="pt-2 font-semibold text-lg border-b  border-gray-200 my-4 bg-gray-50 px-4">
                                        {{ $nivelEducativo->nivel ?? '' }}</div>
                                    @if (!empty($nivelEducativo->certificado_nivel))
                                        <a class="my-6" target="_blank"
                                            href="{{ asset($nivelEducativo->certificado_nivel ?? '') }}">
                                            <x-primary-button>
                                                Ver certificado
                                            </x-primary-button>
                                        </a>
                                    @endif
                                    <x-primary-button wire:click="eliminarNivel('{{ $nivelEducativo->id }}')"
                                        class="my-6 bg-red-400">
                                        Eliminar
                                    </x-primary-button>
                                </x-input-doble>

                                <x-input-doble>
                                    <div>
                                        <div class="text-sm font-semibold">Nivel educativo: <span
                                                class="font-normal">{{ $nivelEducativo->nivel ?? '' }}</span></div>
                                        <div class="text-sm font-semibold">Ubicación: <span
                                                class="font-normal">{{ $nivelEducativo->ubicacion ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold">Titulo: <span
                                                class="font-normal">{{ $nivelEducativo->titulo ?? '' }}</span></div>
                                        <div class="text-sm font-semibold">Institución: <span
                                                class="font-normal">{{ $nivelEducativo->institucion ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div>

                                        <div class="text-sm font-semibold"> Estado: <span
                                                class="font-normal">{{ $nivelEducativo->estado ?? '' }}</span></div>
                                        @if ($nivelEducativo->estado == 'Graduado')
                                            <div class="text-sm font-semibold">Fecha finalizacion: <span
                                                    class="font-normal">{{ $nivelEducativo->fecha_finalizacion ?? '' }}</span>
                                            </div>
                                        @endif
                                    </div>

                                </x-input-doble>
                                <div class="text-sm font-semibold">Observaciones: <span
                                        class="font-normal">{{ $nivelEducativo->observacionesNivel ?? '' }}</span>
                                </div>
                            </div>
                        @endforeach


                        <div class="py-2 font-semibold text-lg border-b border-gray-200 my-4 bg-gray-50 px-4 ">Agregar
                            Nivel Educativo</div>
                        <x-input-doble>

                            <x-select wire="nivel" label="Nivel educativo" name="nivel" id="nivel"
                                value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($niveles as $nivel)
                                        <option value="{{ $nivel }}">
                                            {{ $nivel }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>



                            <x-input-with-label wire="titulo" label="Titulo" name="titulo" id="titulo"
                                type="text" placeholder="titulo" maxlength="100" value="" />

                            <x-input-with-label wire="institucion" label="Institución" name="institucion"
                                id="institucion" type="text" placeholder="Institucion" maxlength="100"
                                value="" />


                        </x-input-doble>

                        <x-input-doble>

                            <x-select wire="estado" label="Estado" name="estado" id="estado" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($estados as $Iestado)
                                        <option value="{{ $Iestado }}">
                                            {{ $Iestado }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>


                            @if ($estado === 'Graduado')
                                <x-input-with-label wire="fecha_finalizacion" label="Fecha de finalización"
                                    name="fecha_finalizacion" id="fecha_finalizacion" type="date"
                                    placeholder="Fecha finalizacion " maxlength="15" value="" />
                            @else
                                <x-input-with-label wire="fecha_finalizacion" label="Fecha de finalización"
                                    name="fecha_finalizacion" id="fecha_finalizacion" type="date"
                                    placeholder="Fecha finalizacion " maxlength="15" value="" disabled />
                            @endif

                            <x-input-with-label wire="ubicacion" label="Pais" name="Pais" id="ubicacion"
                                type="text" placeholder="ubicacion" maxlength="100" value="" />



                        </x-input-doble>

                        <x-input-doble>
                            <x-input-file wire="certificado_nivel" label="Certificado" name="Certificado"
                                id="Certificado" type="file" placeholder="Certificado" maxlength="200"
                                value="" />
                        </x-input-doble>
                        <x-input-with-label wire="observacionesNivel" label="Observaciones" name="observaciones"
                            id="observaciones" type="text" placeholder="observaciones" maxlength="100"
                            value="" />

                        <div class="flex justify-end space-x-2 my-4">
                            <x-primary-button wire:click="guardarNivel()">
                                Añadir
                            </x-primary-button>

                        </div>
                        <div class="flex justify-between space-x-2">

                            <x-secondary-button class="flex"
                                x-on:click="informacion_modal = false , certificado= true, nivel_modal= false, experiencia= false, noformal= false ">
                                <div class="px-1 my-auto transform rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>

                                </div>
                                Anterior

                            </x-secondary-button>

                            <x-secondary-button class="flex"
                                x-on:click="informacion_modal = false , certificado= false, nivel_modal= false, experiencia= true, noformal= false ">
                                Siguiente
                                <div class="px-1 my-auto ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>

                                </div>
                            </x-secondary-button>
                        </div>


                    </div>

                    <div x-cloak x-transition.1000ms x-show="experiencia" class="py-4">
                        <div class="border pb-3 px-3 rounded-lg my-2 bg-gray-100">

                            <div class="flex flex-col justify-between items-center md:mx-4 ">
                                <div class="border m-3 p-3 w-full rounded-lg shadow bg-white">
                                    <div class="mx-auto my-4">
                                        <a class="my-6" target="_blank" href="{{ asset($formatoExp ?? '') }}">
                                            <div class="flex flex-col justify-center items-center cursor-pointer">
                                                <svg class="w-16" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    xmlns:svgjs="http://svgjs.com/svgjs" x="0"
                                                    y="0" viewBox="0 0 267 267"
                                                    style="enable-background:new 0 0 512 512" xml:space="preserve"
                                                    fill-rule="evenodd">
                                                    <g>
                                                        <path fill="#d8dfe3"
                                                            d="M50 154.167c56.944 9.876 113.889 9.544 170.833 0V75c0-.902-.292-1.779-.833-2.5l-37.5-50a4.168 4.168 0 0 0-3.333-1.667H62.5a12.501 12.501 0 0 0-12.5 12.5v95.834c0 6.188-1.451 11.433-1.451 15.614 0 5.78 1.451 9.386 1.451 9.386z"
                                                            data-original="#d8dfe3" class=""></path>
                                                        <path fill="#1fb35b"
                                                            d="M25 143.365v89.968a12.501 12.501 0 0 0 12.5 12.5h191.667a12.503 12.503 0 0 0 12.5-12.5v-66.666a12.501 12.501 0 0 0-12.5-12.5h-187.5c-5.316 0-16.667-10.802-16.667-10.802z"
                                                            data-original="#1fb35b"></path>
                                                        <path fill="#198043"
                                                            d="M37.5 154.167c-3.804 0-6.581-1.543-8.625-3.443-1.923-1.788-3.875-4.939-3.875-9.057 0-2.643 1.317-6.495 3.661-8.839s5.524-3.661 8.839-3.661H50v25H37.5z"
                                                            data-original="#198043"></path>
                                                        <path fill="#1fb35b"
                                                            d="M129.167 137.5V100H75v33.333a4.166 4.166 0 0 0 4.167 4.167zM129.167 54.167h-50A4.166 4.166 0 0 0 75 58.333v33.334h54.167zM191.667 100H137.5v37.5h50a4.167 4.167 0 0 0 4.167-4.167zM179.167 54.167H137.5v37.5h54.167V75c0-2.3-1.867-4.167-4.167-4.167s-4.167-10.2-4.167-12.5a4.168 4.168 0 0 0-4.166-4.166z"
                                                            data-original="#1fb35b"></path>
                                                        <path fill="#afbdc7"
                                                            d="M179.167 20.833V62.5a12.501 12.501 0 0 0 12.5 12.5h29.166c0-.902-.292-1.779-.833-2.5l-37.5-50a4.168 4.168 0 0 0-3.333-1.667z"
                                                            data-original="#afbdc7"></path>
                                                        <g fill="#d8dfe3">
                                                            <path
                                                                d="M122.396 179.167v41.666a4.166 4.166 0 0 0 4.167 4.167h26.041c2.3 0 4.167-1.867 4.167-4.167a4.169 4.169 0 0 0-4.167-4.166h-21.875v-37.5c0-2.3-1.867-4.167-4.166-4.167a4.169 4.169 0 0 0-4.167 4.167zM80.74 223.577l36.458-41.667a4.167 4.167 0 0 0-6.271-5.487L74.468 218.09a4.169 4.169 0 0 0 .392 5.879 4.17 4.17 0 0 0 5.88-.392z"
                                                                fill="#d8dfe3" data-original="#d8dfe3"
                                                                class=""></path>
                                                            <path
                                                                d="M117.198 218.09 80.74 176.423a4.17 4.17 0 0 0-5.88-.392 4.169 4.169 0 0 0-.392 5.879l36.459 41.667a4.167 4.167 0 0 0 6.271-5.487zM158.855 210.443l-.001-.001v2.066A12.49 12.49 0 0 0 171.346 225h9.391a12.49 12.49 0 0 0 12.492-12.492v-1.658c0-5.111-3.112-9.707-7.857-11.606l-15.151-6.06a4.826 4.826 0 0 1-3.034-4.48V187.5c0-1.105.439-2.165 1.221-2.946a4.164 4.164 0 0 1 2.946-1.221h9.375c1.105 0 2.165.439 2.946 1.221a4.164 4.164 0 0 1 1.221 2.946v2.058c0 1.176.52 2.24 1.042 2.78a4.195 4.195 0 0 0 3.124 1.412c2.029 0 4.167-1.566 4.167-4.192V187.5a12.501 12.501 0 0 0-12.5-12.5h-9.375a12.501 12.501 0 0 0-12.5 12.5v1.204c0 5.38 3.276 10.219 8.272 12.217l15.151 6.061a4.165 4.165 0 0 1 2.619 3.868v1.658a4.16 4.16 0 0 1-4.159 4.159h-9.391a4.16 4.16 0 0 1-4.158-4.158l-.001-2.067c0-2.748-2.239-4.194-4.093-4.194-1.758 0-4.24 1.363-4.24 4.169a.1.1 0 0 0 .001.026z"
                                                                fill="#d8dfe3" data-original="#d8dfe3"
                                                                class=""></path>
                                                        </g>
                                                    </g>
                                                </svg>
                                                <p class="text-green-400 font-semibold">Descargar formato</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-500 px-4 py-3 shadow-md mb-4"
                                        role="alert">
                                        <p>Descargue, diligencie y suba el formato.</p>
                                    </div>
                                    <div class="justify-between flex">
                                        <x-input-file wire="certificado_laboral_file" label="Subir formato"
                                            name="Certificado_laboral" id="Certificado_laboral" type="file"
                                            placeholder="Certificado_laboral" maxlength="" value=""
                                            class="w-full" accept=".xlsx" />
                                        @if (!empty($ultimoLog->certificado_laboral))
                                            <div class="border rounded-lg m-4 p-4 bg-gray-100">
                                                <a class="text-white font-semibold px-2 py-1 rounded-md bg-green-500"
                                                    target="_blank"
                                                    href="{{ asset($ultimoLog->certificado_laboral) }}">
                                                    Descargar ultimo diligenciado.
                                                </a>
                                                <p class="text-xs">
                                                    {{ \Carbon\Carbon::parse($ultimoLog->created_at)->tz('America/Bogota')->format('d/m/Y h:i A') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>


                                    <div class="flex justify-between space-x-2 my-4 ">
                                        <div class="rounded-lg bg-green-200 text-green-600 text-xs p-2">Diligencie el
                                            formato descargado y cárguelo en esta sección.</div>
                                        <x-primary-button
                                            wire:click="guardarLaboral('{{ $ultimoLog->certificacion_laboral ?? '' }}')">
                                            Guardar formato
                                        </x-primary-button>
                                    </div>
                                </div>
                                <div class="border m-3 p-3 w-full rounded-lg shadow bg-white">
                                    <div class="justify-between flex">
                                        <div>
                                            <x-input-file wire="certificacion_laboral" label="Certificados laborales"
                                                name="certificacion_laboral" id="certificacion_laboral"
                                                type="file" placeholder="certificacion_laboral" maxlength=""
                                                value="" class="w-full" accept=".zip, .rar, .pdf" />
                                            <div class="p-2 text-xs bg-orange-100 text-orange-600 rounded-lg">Peso maximo permitido 10MB </div>
                                        </div>

                                        @if (!empty($ultimoLog->certificacion_laboral))
                                            <div class="border rounded-lg m-4 p-4 bg-gray-100">
                                                <a class="text-white font-semibold px-2 py-1 rounded-md bg-green-500"
                                                    target="_blank"
                                                    href="{{ asset($ultimoLog->certificacion_laboral) }}">
                                                    Descargar últimos certificados.
                                                </a>
                                                <p class="text-xs">
                                                    {{ \Carbon\Carbon::parse($ultimoLog->created_at)->tz('America/Bogota')->format('d/m/Y h:i A') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex justify-between space-x-2 my-4">
                                        <div class="rounded-lg bg-green-200 text-green-600 text-xs p-2">Comprima los
                                            certificados laborales, y suba un solo archivo .zip</div>
                                        <x-primary-button
                                            wire:click="guardarCertificadoLaboral('{{ $ultimoLog->certificado_laboral ?? '' }}')">
                                            Guardar certificados
                                        </x-primary-button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if (!empty($muestras))
                                    <x-table>
                                        <x-slot name='head'>

                                        </x-slot>
                                        <x-slot name='bodytable'>
                                            @foreach ($muestras[0] as $muestra)
                                                <x-tr>
                                                    <x-td class="px-2">{{ $muestra[0] ?? '' }}</x-td>
                                                    <x-td class="px-2">{{ $muestra[1] ?? '' }}</x-td>
                                                    <x-td class="px-2">{{ $muestra[2] ?? '' }}</x-td>
                                                    <x-td class="px-2">{{ $muestra[3] ?? '' }}</x-td>
                                                    <x-td class="px-2">{{ $muestra[4] ?? '' }}</x-td>
                                                </x-tr>
                                            @endforeach
                                        </x-slot>
                                        <x-slot name='link'>
                                        </x-slot>
                                    </x-table>
                                @endif
                            </div>



                        </div>




                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <div class="bg-gray-200 px-4 py-2">
                                <h2 class="text-lg font-semibold">Historial</h2>
                            </div>
                            <ul>
                                @foreach ($logs as $log)
                                    <li class="border-t border-gray-200 hover:bg-gray-100">
                                        <div class="px-4 py-3">
                                            <p class="text-gray-800">
                                                @if ($log->c)
                                                    Certificados laborales
                                                @else
                                                    Formato
                                                @endif actualizado el
                                                <span
                                                    class="font-semibold text-gray-600">{{ \Carbon\Carbon::parse($log->created_at)->tz('America/Bogota')->format('d/m/Y h:i A') }}</span>
                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>








                        {{-- @foreach ($consultaLaboral as $laboral)
                            <div class="border pb-3 px-3 rounded-lg my-2">
                                <x-input-doble>
                                    <div
                                        class="pt-2 font-semibold text-lg border-b  border-gray-200 my-4 bg-gray-50 px-4">
                                        {{ $laboral->cargo ?? '' }} @if ($laboral->trabajo_actual)
                                            - Trabajo actual
                                        @endif
                                    </div>
                                    @if (!empty($laboral->certificado_laboral))
                                        <a class="my-6" target="_blank"
                                            href="{{ asset($laboral->certificado_laboral ?? '') }}">
                                            <x-primary-button>
                                                Ver certificado
                                            </x-primary-button>
                                        </a>
                                    @endif
                                    <x-primary-button wire:click="eliminarLaboral('{{ $laboral->id }}')"
                                        class="my-6 bg-red-400">
                                        Eliminar
                                    </x-primary-button>
                                </x-input-doble>

                                <x-input-doble>
                                    <div>
                                        <div class="text-sm font-semibold">Tipo: <span
                                                class="font-normal">{{ $laboral->tipo ?? '' }}</span></div>
                                        <div class="text-sm font-semibold">Empresa: <span
                                                class="font-normal">{{ $laboral->nombre_empresa ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold">Telefono: <span
                                                class="font-normal">{{ $laboral->telefono ?? '' }}</span></div>
                                        <div class="text-sm font-semibold">Ubicación: <span
                                                class="font-normal">{{ $laboral->pais ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold">Fecha ingreso: <span
                                                class="font-normal">{{ $laboral->fecha_ingreso ?? '' }}</span></div>
                                        @if (!$laboral->trabajo_actual)
                                            <div class="text-sm font-semibold">Fecha finalizacion: <span
                                                    class="font-normal">{{ $laboral->fecha_retiro ?? '' }}</span>
                                            </div>
                                        @endif
                                    </div>

                                </x-input-doble>

                                <div class="text-sm font-semibold">Funciones y logros: <span
                                        class="font-normal">{{ $laboral->funciones_logros ?? '' }}</span>
                                </div>
                            </div>
                        @endforeach


                        <div class="py-2 font-semibold text-lg border-b border-gray-200 my-4 bg-gray-50 px-4 ">
                            Agregar Experiencia Laboral</div>
                        <x-input-doble>
                            <x-input-with-label wire="nombre_empresa" label="Nombre empresa" name="nombre_empresa"
                                id="nombre_empresa" type="text" placeholder="nombre_empresa" maxlength="100"
                                value="" />
                            <div class="w-56 my-auto mr-auto text-right">
                                <x-checkbox-with-label type="checkbox" id="tipo" name="tipo" value=""
                                    wire="trabajo_actual" label="Trabajo actual" />
                            </div>
                        </x-input-doble>
                        <x-input-doble>


                            <x-select wire="tipo" label="Tipo" name="tipo" id="tipo" value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($tipoExperiencia as $experiencia)
                                        <option value="{{ $experiencia }}">
                                            {{ $experiencia }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>

                            <x-input-with-label wire="fecha_ingreso" label="Fecha de ingreso" name="fecha_ingreso"
                                id="fecha_ingreso" type="date" placeholder="fecha_ingreso" maxlength="100"
                                value="" />

                            @if (!$trabajo_actual)
                                <x-input-with-label wire="fecha_retiro" label="Fecha de retiro" name="fecha_retiro"
                                    id="fecha_retiro" type="date" placeholder="fecha_retiro" maxlength="100"
                                    value="" />
                            @else
                                <x-input-with-label wire="fecha_retiro" label="Fecha de retiro" name="fecha_retiro"
                                    id="fecha_retiro" type="date" placeholder="fecha_retiro" maxlength="100"
                                    value="" disabled />
                            @endif
                        </x-input-doble>

                        <x-input-doble>

                            <x-input-with-label wire="pais" label="Pais" name="pais" id="pais"
                                type="text" placeholder="pais" maxlength="15" value="" />

                            <x-input-with-label wire="telefono" label="Telefono" name="telefono" id="telefono"
                                type="tel" placeholder="telefono" maxlength="10" value=""
                                class="appearance-none " />

                            <x-input-with-label wire="cargo" label="Cargo" name="cargo" id="cargo"
                                type="text" placeholder="cargo" maxlength="100" value="" />

                        </x-input-doble>
                        <x-input-doble>
                            <x-input-file wire="certificado_laboral" label="Certificado" name="Certificado"
                                id="Certificado" type="file" placeholder="Certificado" maxlength="200"
                                value="" />
                        </x-input-doble>
                        <x-textarea-label wire="funciones_logros" label="Funciones y logros" name="funciones_logros"
                            id="funciones_logros" type="text" value="" placeholder="Funciones y logros"
                            maxlength="1000" />

                        <div class="flex justify-end space-x-2 my-4">
          

                        </div> --}}

                        <div class="flex justify-between space-x-2">
                            <x-secondary-button class="flex"
                                x-on:click="informacion = false , certificado= false, nivel_modal= true, experiencia= false, noformal= false ">
                                <div class="px-1 my-auto transform rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>

                                </div>
                                Anterior

                            </x-secondary-button>
                            <x-secondary-button class="flex"
                                x-on:click="informacion = false , certificado= false, nivel_modal= false, experiencia= false, noformal= true ">
                                Siguiente
                                <div class="px-1 my-auto ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>

                                </div>
                            </x-secondary-button>
                        </div>


                    </div>

                    <div x-cloak x-transition.1000ms x-show="noformal" class="py-4">
                        @foreach ($consultaNoformal as $itemNoformal)
                            <div class="border pb-3 px-3 rounded-lg my-2">
                                <x-input-doble>
                                    <div
                                        class="pt-2 font-semibold text-lg border-b  border-gray-200 my-4 bg-gray-50 px-4">
                                        {{ $itemNoformal->nombre_noformal ?? '' }}
                                    </div>
                                    @if (!empty($itemNoformal->certificado_noformal))
                                        <a class="my-6" target="_blank"
                                            href="{{ asset($itemNoformal->certificado_noformal ?? '') }}">
                                            <x-primary-button>
                                                Ver certificado
                                            </x-primary-button>
                                        </a>
                                    @endif
                                    <x-primary-button wire:click="eliminarNoformal('{{ $itemNoformal->id }}')"
                                        class="my-6 bg-red-400">
                                        Eliminar
                                    </x-primary-button>
                                </x-input-doble>

                                <x-input-doble>
                                    <div>
                                        <div class="text-sm font-semibold">Tipo: <span
                                                class="font-normal">{{ $itemNoformal->tipo_noformal ?? '' }}</span>
                                        </div>
                                        <div class="text-sm font-semibold">Institución: <span
                                                class="font-normal">{{ $itemNoformal->institucion_noformal ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold">Nombre del programa: <span
                                                class="font-normal">{{ $itemNoformal->nombre_noformal ?? '' }}</span>
                                        </div>

                                        <div class="text-sm font-semibold">Ubicación: <span
                                                class="font-normal">{{ $itemNoformal->pais_noformal ?? '' }}</span>
                                        </div>

                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold">Estado: <span
                                                class="font-normal">{{ $itemNoformal->estado_noformal ?? '' }}</span>
                                        </div>
                                        <div class="text-sm font-semibold">Duración: <span
                                                class="font-normal">{{ $itemNoformal->duracion ?? '' }}</span>
                                        </div>
                                    </div>

                                </x-input-doble>

                            </div>
                        @endforeach

                        <div class="py-2 font-semibold text-lg border-b border-gray-200 my-4 bg-gray-50 px-4 ">Agregar
                            Capacitaciones y Certificaciones</div>
                        <x-input-doble>
                            <x-select wire="tipo_noformal" label="Tipo de certificado" name="tipo" id="tipo"
                                value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    @foreach ($tipoCurso as $curso1)
                                        <option value="{{ $curso1 }}">
                                            {{ $curso1 }}
                                        </option>
                                    @endforeach
                                </x-slot>
                            </x-select>

                            <x-input-with-label wire="nombre_noformal" label="Nombre del programa"
                                name="nombre_noformal" id="nombre " type="text" placeholder="Nombre"
                                maxlength="100" value="" />

                            <x-input-with-label wire="pais_noformal" label="Pais" name="pais" id="pais"
                                type="text" placeholder="pais" maxlength="100" value="" />


                        </x-input-doble>

                        <x-input-doble>

                            <x-input-with-label wire="institucion_noformal" label="Institucion" name="institucion"
                                id="institucion_noformal" type="text" placeholder="Institución" maxlength="100"
                                value="" />

                            <x-select wire="estado_noformal" label="Estado" name="estado" id="estado"
                                value="">
                                <x-slot name="option">
                                    <option value="">Seleccionar</option>
                                    <option value="Certificado">Certificado</option>
                                    <option value="No certificado">No certificado</option>
                                </x-slot>
                            </x-select>

                            <x-input-with-label wire="duracion" label="Duracion en horas" name="duracion"
                                id="duracion" type="tel" placeholder="Duración" maxlength="50"
                                value="" />
                        </x-input-doble>
                        <x-input-doble>
                            <x-input-file wire="certificado_noformal" label="Certificado" name="Certificado"
                                id="Certificado" type="file" placeholder="Certificado" maxlength="200"
                                value="" />
                        </x-input-doble>
                        <div class="flex justify-end space-x-2 my-4">
                            <x-primary-button wire:click="guardarNoformal()">
                                Añadir
                            </x-primary-button>
                        </div>
                        <div class="flex justify-between space-x-2">
                            <x-secondary-button class="flex"
                                x-on:click="informacion = false , certificado= false, nivel_modal= false, experiencia= true, noformal= false ">
                                <div class="px-1 my-auto transform rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-4 h-4 mx-1 text-[{{ config('app.colorBoton') }}]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>

                                </div>
                                Anterior

                            </x-secondary-button>

                            <a href="{{ route('cv', ['user_id' => $user_id]) }}">
                                <x-secondary-button class="flex">
                                    Finalizar
                                </x-secondary-button>
                            </a>

                        </div>
                    </div>
                </div>


            </x-slot>
            <x-slot name="boton">
            </x-slot>
        </x-crud-individual>

    </x-contenedor>
</div>
