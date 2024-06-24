<div class="h-full w-full md:my-2">

    <div class="py-2 mx-auto sm:px-6 lg:px-8">
        <div class="p-2">

            @include('components/loading')

            <div class="flex flex-col xl:flex-row items-center xl:items-start justify-center xl:justify-between gap-10">
                <div class="relative shadow-xl w-full md:w-96 rounded-xl bg-white overflow-y-auto overflow-x-hidden xl:h-[calc(100vh-200px)]">

                    <li title="{{ $consulta->estado == 1 ? 'Activo' : 'Inactivo' }}" class="h-3 w-3 absolute right-4 top-5 rounded-full list-none {{ $consulta->estado == 1 ? 'bg-green-500' : 'bg-red-500' }}">
                    </li>

                    <div class="p-4">
                        <div>
                            <img src="https://dxcgedrrxtox6.cloudfront.net/images/perfil_hombre.svg" alt="usuario"
                                class="mx-auto mt-6">
                            <h3 class="text-[#091351] text-lg font-semibold text-center mt-2">
                                {{ $consulta->name ?? '' }}
                            </h3>
                            <p class="uppercase text-sm text-center text-gray-400">
                                {{ $consulta->rol->descripcion ?? '' }}
                            </p>
                        </div>

                        <div class="flex justify-center gap-4 my-3">
                            <a href="" class="border rounded-md border-red-400 text-red-400 p-2 flex justify-center items-center">
                                <x-heroicon-s-trash class="w-5" />
                            </a>
                            <a href="" class="border rounded-md border-[#2f4Daa] bg-[#2f4DAA]  p-2 flex justify-center items-center">
                                <x-heroicon-s-pencil class="text-white w-5" />
                            </a>
                        </div>

                        <div class="flex justify-center mb-4">
                            <a href="" class="flex justify-center gap-2 p-1 px-3 font-semibold items-center border rounded-md text-[#2f4DAA] border-[#2f4Daa]">
                                <x-heroicon-s-pencil class="w-5" />
                                Actualizar Datos
                            </a>
                        </div>

                        <div x-data="{ openMenu: null }" class="">
                            <ul class="[&>li]:border-b [&>li]:mb-2 [&>li]:cursor-pointer [&>li]:text-[#091351] [&>li]:font-semibold [&>li]:text-lg">
                                <li @click="openMenu === 'info-general' ? openMenu = null : openMenu = 'info-general'">
                                    <div class="flex justify-between items-center">
                                        Información General
                                        <x-heroicon-m-chevron-left x-show="openMenu !== 'info-general'"
                                            class="w-4" />
                                        <x-heroicon-m-chevron-down x-cloak x-show="openMenu === 'info-general'"
                                            class="w-4" />
                                    </div>

                                    <div x-cloak x-show="openMenu === 'info-general'"
                                        class="text-base font-normal py-4 text-gray-600">
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                <x-heroicon-s-identification class="w-6" />Identificación
                                            </h3>
                                            <p>{{ $consulta->documento ?? 'Sin información' }} </p>
                                        </div>
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                <x-heroicon-s-envelope class="w-6" />Correo
                                            </h3>
                                            <p>{{ $consulta->email ?? 'Sin información' }} </p>
                                        </div>
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                <x-heroicon-s-phone class="w-6" />Teléfono
                                            </h3>
                                            <p>{{ $consulta->telefono ?? 'Sin información' }} </p>
                                        </div>
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                <x-heroicon-s-users class="w-6" />Sexo
                                            </h3>
                                            <p>{{ $consulta->genero ?? 'Sin información' }} </p>
                                        </div>
                                    </div>
                                </li>
                                <li
                                    @click="openMenu === 'prevision-pago' ? openMenu = null : openMenu = 'prevision-pago'">
                                    <div class="flex justify-between items-center">
                                        Previsión y Pago
                                        <x-heroicon-m-chevron-left x-show="openMenu !== 'prevision-pago'"
                                            class="w-4" />
                                        <x-heroicon-m-chevron-down x-cloak x-show="openMenu === 'prevision-pago'"
                                            class="w-4" />
                                    </div>

                                    <div x-cloak x-show="openMenu === 'prevision-pago'"
                                        class="text-base font-normal py-4 text-gray-600">
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                <x-heroicon-m-heart class="w-6" />Previsión
                                            </h3>
                                            <ul class="font-semibold text-[#79747C]">
                                                <li>
                                                    {{ $consulta->eps ?? 'Sin información' }}
                                                </li>
                                                <li>
                                                    {{ $consulta->proteccion ?? 'Sin información' }}
                                                </li>
                                                <li>
                                                    {{ $consulta->proteccion ?? 'Sin información' }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li
                                    @click="openMenu === 'info-academica' ? openMenu = null : openMenu = 'info-academica'">
                                    <div class="flex justify-between items-center">
                                        Información Académica
                                        <x-heroicon-m-chevron-left x-show="openMenu !== 'info-academica'"
                                            class="w-4" />
                                        <x-heroicon-m-chevron-down x-cloak x-show="openMenu === 'info-academica'"
                                            class="w-4" />
                                    </div>

                                    <div x-cloak x-show="openMenu === 'info-academica'"
                                        class="text-base font-normal py-4 text-gray-600">
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                Título</h3>
                                            <p>{{ $consultaEducacion->titulo ?? 'Sin información' }}</p>

                                        </div>
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                Institución</h3>
                                            <p>{{ $consultaEducacion->institucion ?? 'Sin información' }} </p>
                                        </div>
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                Grado</h3>
                                            <p>{{ $consultaEducacion->nivel ?? 'Sin información' }} </p>
                                        </div>
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                Inicio y Término de Educación</h3>
                                            <p>{{ $consultaEducacion->fecha_finalizacion ?? 'Sin información' }} </p>
                                        </div>
                                    </div>
                                </li>
                                <li
                                    @click="openMenu === 'atributos-personalizados' ? openMenu = null : openMenu = 'atributos-personalizados'">
                                    <div class="flex justify-between items-center">
                                        Atributos Personalizados
                                        <x-heroicon-m-chevron-left x-show="openMenu !== 'atributos-personalizados'"
                                            class="w-4" />
                                        <x-heroicon-m-chevron-down x-cloak
                                            x-show="openMenu === 'atributos-personalizados'" class="w-4" />
                                    </div>

                                    <div x-cloak x-show="openMenu === 'atributos-personalizados'"
                                        class="text-base font-normal py-4 text-gray-600">
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                Título</h3>
                                            <p>{{ $consulta->titulo ?? 'Sin información' }} </p>
                                        </div>
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                Institución</h3>
                                            <p>{{ $consulta->titulo ?? 'Sin información' }} </p>
                                        </div>
                                        <div class="mb-2">
                                            <h3 class="flex justify-start items-center gap-2 font-bold text-[#79747C]">
                                                Hijos</h3>
                                            <p>{{ $consulta->numero_hijos > 0 ? 'Si' : 'No' }} </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div x-data="{ activeTab: 'Resumen' }" class="shadow-xl p-4 w-full rounded-xl bg-white overflow-y-auto overflow-x-hidden xl:h-[calc(100vh-200px)]">
                    <ul class="flex w-96 sm:w-full overflow-x-auto mx-auto">
                        <li @click="activeTab = 'Resumen'"
                            :class="{
                                'bg-[rgba(47,77,170,.08)] border-b-2 border-[#2f4DAA] text-[#2f4daa]': activeTab ===
                                    'Resumen'
                            }"
                            class="px-4 py-3 cursor-pointer hover:text-[#2F4DAA] font-semibold">Resumen</li>
                        <li @click="activeTab = 'Documentos'"
                            :class="{
                                'bg-[rgba(47,77,170,.08)] border-b-2 border-[#2f4DAA] text-[#2f4daa]': activeTab ===
                                    'Documentos'
                            }"
                            class="px-4 py-3 cursor-pointer hover:text-[#2F4DAA] font-semibold">Documentos</li>
                        <li @click="activeTab = 'Historia'"
                            :class="{
                                'bg-[rgba(47,77,170,.08)] border-b-2 border-[#2f4DAA] text-[#2f4daa]': activeTab ===
                                    'Historia'
                            }"
                            class="px-4 py-3 cursor-pointer hover:text-[#2F4DAA] font-semibold">Historia</li>
                        <li @click="activeTab = 'Asistencia'"
                            :class="{
                                'bg-[rgba(47,77,170,.08)] border-b-2 border-[#2f4DAA] text-[#2f4daa]': activeTab ===
                                    'Asistencia'
                            }"
                            class="px-4 py-3 cursor-pointer hover:text-[#2F4DAA] font-semibold">Asistencia</li>
                        <li @click="activeTab = 'Vacaciones'"
                            :class="{
                                'bg-[rgba(47,77,170,.08)] border-b-2 border-[#2f4DAA] text-[#2f4daa]': activeTab ===
                                    'Vacaciones'
                            }"
                            class="px-4 py-3 cursor-pointer hover:text-[#2F4DAA] font-semibold">Vacaciones</li>
                        <li @click="activeTab = 'Talento'"
                            :class="{
                                'bg-[rgba(47,77,170,.08)] border-b-2 border-[#2f4DAA] text-[#2f4daa]': activeTab ===
                                    'Talento'
                            }"
                            class="px-4 py-3 cursor-pointer hover:text-[#2F4DAA] font-semibold">Talento</li>
                    </ul>
                    <div class="p-4">
                        <div x-show="activeTab === 'Resumen'">
                            <div class="flex justify-end items-end gap-2">
                                <button
                                    class="text-red-400 border border-red-400 px-4 py-1 flex items-center gap-2 font-semibold rounded-md">Terminar
                                    trabajo
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button
                                    class="text-white border border-[#2f4daa] px-4 py-1 font-semibold rounded-md bg-[#2f4DAA]">Editar
                                    Trabajo</button>
                            </div>
                            <div class="mt-4 lg:flex lg:flex-wrap">
                                <div class="container mx-auto lg:w-1/2">
                                    <table class="w-full text-sm">
                                        <tbody>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Cargo</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Área</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">División</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Empresa</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Centro de Costos</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Supervisor</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Suplente</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Sueldo Base</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Tipo Contrato</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Jornada Laboral</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Fecha Ingreso Compañia</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                            <tr class="border-y border-gray-100">
                                                <td class="py-2 px-4 font-bold">Saldo Vacaciones</td>
                                                <td class="py-2 px-4"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="lg:w-1/2 px-4 lg:px-10">
                                    <h3 class="font-bold border-t border-gray-100 text-sm">Días no Trabajados</h3>
                                    <h3 class="font-bold border-t border-gray-100 text-sm">Horas Extras</h3>
                                </div>
                            </div>
                        </div>

                        <div x-show="activeTab === 'Documentos'">Contenido Documentos</div>
                        <div x-show="activeTab === 'Historia'">Contenido Historia</div>
                        <div x-show="activeTab === 'Asistencia'">Contenido Asistencia</div>
                        <div x-show="activeTab === 'Vacaciones'">Contenido Vacaciones</div>
                        <div x-show="activeTab === 'Talento'">Contenido Talento</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
