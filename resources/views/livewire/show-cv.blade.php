<div x-data="{ modalDatos: @entangle('modalDatos') }">
    <x-contenedor>
        {{-- Carga --}}
        @include('components/loading')
        <x-crud-individual>
            <x-slot name="titulo">
                INFORMACIÓN BASICA
            </x-slot>
            <x-slot name="subtitulo">
            </x-slot>
            <x-slot name="contenido" class="">
                <div class="max-w-2xl">
                    <div>
                        <div class="text-2xl font-semibold capitalize align-middle ">
                            {{ $consulta->name ?? '' }} {{ $consulta->segundo_name ?? '' }}
                            {{ $consulta->primer_apellido ?? '' }} {{ $consulta->segundo_apellido ?? '' }}
                        </div>
                        <div class="text-sm text-justify mt-2">
                            {{ $consulta->perfil_laboral ?? '' }}
                        </div>
                    </div>


                    <div class=" flex space-x-2 text-sm align-middle my-3">
                        <div class="flex align-middle pr-2">
                            <span class="align-middle p-2 rounded-full"><svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            </span>
                            <div class="my-auto">
                                {{ $consulta->telefono ?? '' }}
                            </div>
                        </div>
                        <div class="flex align-middle pr-2"> <span class="align-middle p-2 rounded-full"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </span>
                            <div class="my-auto">{{ $consulta->email ?? '' }}
                            </div>
                        </div>


                    </div>
                </div>
                <div>
                    @if (!empty($consulta->foto_perfil))
                        <img src="{{ asset($consulta->foto_perfil) ?? '' }}" alt="foto perfil"
                            class="w-32 h-32 mx-8  rounded-lg object-cover border-spacing-1 border-orange-200 border-2">
                    @endif
                </div>

            </x-slot>
            <x-slot name="boton">
                <a href="{{ route('editarcv', ['user_id' => $user_id]) }}" class="mt-2">
                    <x-primary-button>
                        Editar
                    </x-primary-button>
                </a>
            </x-slot>
        </x-crud-individual>

    </x-contenedor>
    <x-contenedor>

        <x-crud-individual>
            <x-slot name="titulo">
                DATOS PERSONALES
            </x-slot>
            <x-slot name="subtitulo">
            </x-slot>
            <x-slot name="contenido" class="max-w-lg">
                <div class="md:flex md:space-x-6 justify-start w-full ">
                    <div class="max-w-xs ">
                        <div class="text-sm font-semibold">Edad: <span class="font-normal">
                                @if ($consulta->fecha_nacimiento)
                                    {{ Carbon\Carbon::parse($consulta->fecha_nacimiento)->age }} Años
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                        <div class="text-sm font-semibold">Codigo: <span
                                class="font-normal">{{ $consulta->codigo_interno ?? 'N/A' }}</span>
                        </div>
                        <div class="text-sm font-semibold">Documento: <span
                                class="font-normal">{{ $consulta->documento ?? 'N/A' }}</span>
                        </div>

                        <div class="text-sm font-semibold">Municipio expedición del documento: <span
                                class="font-normal">
                                @if (!empty($consulta->municipioExp->municipio))
                                    <div id="Municipio">{{ $consulta->municipioExp->municipio ?? 'N/A' }} -
                                        {{ $consulta->municipioExp->departamento ?? 'N/A' }} </div>
                                @endif
                            </span>
                        </div>
                        <div class="text-sm font-semibold">Genero: <span
                                class="font-normal">{{ $consulta->genero ?? 'N/A' }}</span>
                        </div>
                        <div class="text-sm font-semibold">Grupo Sanguíneo: <span
                                class="font-normal">{{ $consulta->grupo_sanguineo ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="max-w-xs ">

                        <div class="text-sm font-semibold">Contacto de emergencia: <span
                                class="font-normal">{{ $consulta->nombre_cont_emerg ?? 'N/A' }} -
                                {{ $consulta->numero_cont_emerg ?? 'N/A' }}</span>
                        </div>
                        <div class="text-sm font-semibold">Nacionalidad: <span
                                class="font-normal">{{ $consulta->Nacionalidad ?? 'N/A' }}</span>
                        </div>
                        <div class="text-sm font-semibold">Municipio de Nacimiento: <span
                                class="font-normal">{{ $consulta->municipioNac->municipio ?? 'N/A' }} -
                                {{ $consulta->municipioNac->departamento ?? 'N/A' }}</span>
                        </div>
                        <div class="text-sm font-semibold">Municipio de Residencia: <span
                                class="font-normal">{{ $consulta->municipioRes->municipio ?? 'N/A' }} -
                                {{ $consulta->municipioRes->departamento ?? 'N/A' }}</span>
                        </div>
                        <div class="text-sm font-semibold">Barrio: <span
                                class="font-normal">{{ $consulta->barrio ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="max-w-xs ">

                        <div class="text-sm font-semibold">Telefono de contacto: <span
                                class="font-normal">{{ $consulta->telefono_contacto ?? 'N/A' }}</span>
                        </div>
                        <div class="text-sm font-semibold">Numero de hijos: <span
                                class="font-normal">{{ $consulta->numero_hijos ?? 'N/A' }}</span>
                        </div>
                        @if ($consulta->numero_hijos != '0')
                            <div class="text-sm font-semibold">Cabeza de familia: <span
                                    class="font-normal">{{ $consulta->cabeza_familia ?? 'N/A' }}</span>
                            </div>
                        @endif
                        <div class="text-sm font-semibold">Población vulnerable: <span
                                class="font-normal">{{ $consulta->poblacion_vulnerable ?? 'N/A' }}</span>
                        </div>
                        <div class="text-sm font-semibold">Cargo: <span
                                class="font-normal">{{ $consulta->cargo->nombre ?? 'N/A' }}</span>
                        </div>
                    </div>

                </div>

            </x-slot>
            <x-slot name="boton">
                <a href="{{ route('editarcv', ['user_id' => $user_id]) }}" class="mt-2">
                    <x-primary-button>
                        Editar
                    </x-primary-button>
                </a>
            </x-slot>
        </x-crud-individual>

    </x-contenedor>
    <x-contenedor>

        <x-crud-individual>
            <x-slot name="titulo">
                CERTIFICADOS
            </x-slot>
            <x-slot name="subtitulo">
            </x-slot>
            <x-slot name="contenido" class="">
                <div class="md:flex md:space-x-6 justify-start w-full">
                    <div class="border max-w-xs  rounded-lg mb-2">
                        <div class=" font-semibold text-lg border-b  border-gray-200 my-2 bg-gray-50 px-4">
                            Certificado territorialidad
                        </div>
                        <div class="p-4">
                            <div class="max-w-xs">
                                <div class="text-sm font-semibold">Territorialidad: <span
                                        class="font-normal">{{ $consultaCertificados->estado_territorio ?? 'N/A' }}</span>
                                </div>
                                <div class="text-sm font-semibold">Curso en alturas: <span
                                        class="font-normal">{{ $consultaCertificados->curso_alturas ?? 'N/A' }}</span>
                                </div>
                                <div class="text-sm font-semibold">Fecha de vencimiento: <span
                                        class="font-normal">{{ $consultaCertificados->fecha_vencimiento ?? 'N/A' }}</span>
                                </div>

                                @if (!empty($consultaCertificados->certificado_alturas))
                                    <a class="my-6" target="_blank"
                                        href="{{ asset($consultaCertificados->certificado_alturas ?? '') }}">
                                        <x-primary-button>
                                            Ver certificado
                                        </x-primary-button>
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="border max-w-xs  rounded-lg mb-2">
                        <div class=" font-semibold text-lg border-b  border-gray-200 my-2 bg-gray-50 px-4">
                            Certificado espacios confinados
                        </div>
                        <div class="p-4">
                            <div class="max-w-xs">
                                <div class="text-sm font-semibold">Curso de espacios confinados: <span
                                        class="font-normal">{{ $consultaCertificados->curso_espacios_conf ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Curso de espacios confinados: <span
                                        class="font-normal">{{ $consultaCertificados->curso_espacios_conf ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Nivel de curso espacios confinados: <span
                                        class="font-normal">{{ $consultaCertificados->curso_espacios_conf ?? 'N/A' }}</span>
                                </div>
                                @if (!empty($consultaCertificados->certificado_confinados))
                                    <a class="my-6" target="_blank"
                                        href="{{ asset($consultaCertificados->certificado_confinados ?? '') }}">
                                        <x-primary-button>
                                            Ver certificado
                                        </x-primary-button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="border max-w-xs  rounded-lg mb-2">
                        <div class=" font-semibold text-lg border-b  border-gray-200 my-2 bg-gray-50 px-4">
                            Certificados NCCER
                        </div>
                        <div class="p-4">
                            <div class="max-w-xs">
                                <div class="text-sm font-semibold">Nivel NCCER: <span
                                        class="font-normal">{{ $consultaCertificados->nivel_nccer ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Especialidad NCCER: <span
                                        class="font-normal">{{ $consultaCertificados->especialidad_nccer ?? 'N/A' }}
                                    </span>
                                </div>

                                <div class="text-sm font-semibold">Certificado NCCER: <span
                                        class="font-normal">{{ $consultaCertificados->certificado_nccer ?? 'N/A' }}
                                    </span>
                                </div>
                                @if (!empty($itemEducacion->certificado_arc_nccer))
                                    <a class="my-6" target="_blank"
                                        href="{{ asset($itemEducacion->certificado_arc_nccer ?? '') }}">
                                        <x-primary-button>
                                            Ver certificado
                                        </x-primary-button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="boton">
                <a href="{{ route('editarcv', ['user_id' => $user_id]) }}" class="mt-2">
                    <x-primary-button>
                        Editar
                    </x-primary-button>
                </a>
            </x-slot>
        </x-crud-individual>

    </x-contenedor>

    <x-contenedor>

        <x-crud-individual>
            <x-slot name="titulo">
                NIVEL EDUCATIVO
            </x-slot>
            <x-slot name="subtitulo">
            </x-slot>
            <x-slot name="contenido" class="">
                <div class="md:flex md:space-x-2 justify-start w-full">
                    @foreach ($consultaEducacion as $itemEducacion)
                        <div class="border max-w-xs  rounded-lg mb-2">
                            <div class=" font-semibold text-lg border-b  border-gray-200 my-2 bg-gray-50 px-4">
                                {{ $itemEducacion->nivel ?? '' }}
                            </div>
                            <div class="p-4">
                                <div class="text-sm font-semibold">Nivel: <span
                                        class="font-normal">{{ $itemEducacion->nivel ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Titulo: <span
                                        class="font-normal">{{ $itemEducacion->titulo ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Institucion: <span
                                        class="font-normal">{{ $itemEducacion->institucion ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Fecha de finalización: <span
                                        class="font-normal">{{ $itemEducacion->fecha_finalizacion ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Estado: <span
                                        class="font-normal">{{ $itemEducacion->nivel_curso_espacios ?? 'N/A' }}</span>
                                </div>
                                @if (!empty($itemEducacion->certificado_nivel))
                                    <a class="my-6" target="_blank"
                                        href="{{ asset($itemEducacion->certificado_nivel ?? '') }}">
                                        <x-primary-button>
                                            Ver certificado
                                        </x-primary-button>
                                    </a>
                                @endif

                            </div>

                        </div>
                    @endforeach
                </div>

            </x-slot>
            <x-slot name="boton">
                <a href="{{ route('editarcv', ['user_id' => $user_id]) }}" class="mt-2">
                    <x-primary-button>
                        Editar
                    </x-primary-button>
                </a>
            </x-slot>
        </x-crud-individual>

    </x-contenedor>

    <x-contenedor>

        <x-crud-individual>
            <x-slot name="titulo">
                EXPERIENCIA LABORAL
            </x-slot>
            <x-slot name="subtitulo">
            </x-slot>
            <x-slot name="contenido" class="">
                <div class="md:flex md:space-x-2 justify-start w-full">
                    <div class="border max-w-xs rounded-lg mb-2">
                        @if (!empty($consultaLaboral->certificado_laboral))
                            <a class="my-6" target="_blank"
                                href="{{ asset($consultaLaboral->certificado_laboral ?? '') }}">
                                <x-primary-button>
                                    Descargar formato Excel
                                </x-primary-button>
                            </a>
                        @endif
                    </div>
                </div>
                @if (!empty($consultaCertificacionLaboral->certificacion_laboral))
                    <div>
                        <h2 class="font-semibold text-base text-gray-800 leading-tight uppercase mb-2">
                            Certificaciones laborales
                        </h2>
                        <div class="flex flex-wrap space-x-2">
                            <a class="my-6" target="_blank"
                                href="{{ asset($consultaCertificacionLaboral->certificacion_laboral ?? '') }}">
                                <x-primary-button>
                                    Descargar experiencia laboral
                                </x-primary-button>
                            </a>
                        </div>
                    </div>
                @endif
            </x-slot>
            <x-slot name="boton">
                <a href="{{ route('editarcv', ['user_id' => $user_id]) }}" class="mt-2">
                    <x-primary-button>
                        Editar
                    </x-primary-button>
                </a>
            </x-slot>
        </x-crud-individual>

    </x-contenedor>

    <x-contenedor>

        <x-crud-individual>
            <x-slot name="titulo">
                EDUCACIÓN NOFORMAL
            </x-slot>
            <x-slot name="subtitulo">
            </x-slot>
            <x-slot name="contenido" class="">
                <div class="md:flex md:space-x-2 justify-start w-full">
                    @foreach ($consultaNoformal as $itemNoformal)
                        <div class="border max-w-xs  rounded-lg mb-2 ">
                            <div class=" font-semibold text-lg border-b  border-gray-200 my-2 bg-gray-50 px-4">
                                {{ $itemNoformal->nombre_noformal ?? '' }}
                            </div>
                            <div class="p-4">
                                <div class="text-sm font-semibold">Tipo: <span
                                        class="font-normal">{{ $itemNoformal->tipo_noformal ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Institución: <span
                                        class="font-normal">{{ $itemNoformal->institucion_noformal ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Estado: <span
                                        class="font-normal">{{ $itemNoformal->estado_noformal ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Nombre: <span
                                        class="font-normal">{{ $itemNoformal->nombre_noformal ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Duración: <span
                                        class="font-normal">{{ $itemNoformal->duracion ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Pais: <span
                                        class="font-normal">{{ $itemNoformal->pais_noformal ?? 'N/A' }}</span>
                                </div>

                                <div class="text-sm font-semibold">Archivo: <span
                                        class="font-normal">{{ $itemNoformal->archivo_noformal ?? 'N/A' }}</span>
                                </div>
                                @if (!empty($itemNoformal->certificado_noformal))
                                    <a class="my-6" target="_blank"
                                        href="{{ asset($itemNoformal->certificado_noformal ?? '') }}">
                                        <x-primary-button>
                                            Ver certificado
                                        </x-primary-button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            </x-slot>
            <x-slot name="boton">
                <a href="{{ route('editarcv', ['user_id' => $user_id]) }}" class="mt-2">
                    <x-primary-button>
                        Editar
                    </x-primary-button>
                </a>
            </x-slot>
        </x-crud-individual>

    </x-contenedor>


    {{-- Modal Exportar --}}
    <x-modal-crud x-show="modalDatos">
        <x-slot name="titulo">{{ $politicasDatos->nombre ?? '' }}</x-slot>

        <x-slot name="campos">

            <div class="text-justify text-sm my-4">
                {{ $politicasDatos->descripcion ?? '' }}
            </div>

            <a href="{{ asset($politicasDatos->url ?? '') }}" target="_blank" class="mt-2">
                <x-primary-button>
                    Descargar
                </x-primary-button>
            </a>

        </x-slot>

        <x-slot name="botones">
            <x-secondary-button x-on:click="modalDatos=false" wire:click="logout">
                Cerrar
            </x-secondary-button>
            <x-primary-button x-on:click="modalDatos=false" wire:click="aceptar">
                Aceptar
            </x-primary-button>


        </x-slot>

    </x-modal-crud>
</div>
