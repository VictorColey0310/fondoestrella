<div x-data="{ showSubMenu: false, }" class="md:flex h-screen hidden">

    <!-- Barra lateral -->
    <div class="w-52 drop-shadow-md @if (!empty(config('app.empresa')->color)) bg-[{{ config('app.colorMenu') }}] @else bg-[{{ config('app.colorMenu') }}] @endif text-white shadow flex flex-col justify-between">
        <div>
            <!-- Encabezado de la barra lateral -->
            <div class="flex items-center justify-start h-16 px-6 py-2">
                <!-- Logo -->
                <div class="rounded-full bg-white  overflow-hidden flex  justify-center h-13 w-13 p-1 shadow">
                    <x-application-logo />
                </div>
                <h1 class="text-xl font-semibold mx-3 text-[{{ config('app.colorLetra') }}]">{{ config('app.nombre') }}</h1>
            </div>
            <div class=" px-4 cursor-pointer my-2">
                @livewire('empresa-seleccionada')
            </div>
        </div>
        <div class="overflow-y-auto h-full">
            <div class="flex-1">
                <!-- Contenido de la barra lateral -->
                <nav class="px-4 py-2">
                    <ul>
                        @if (config('app.modulosActivos'))
                            @foreach (config('app.modulosActivos') as $modulo)
                                @if (!empty($modulo->icono))
                                    <li class="my-1 cursor-pointer " x-data="{ showSubMenu: true }">
                                        <div class="flex items-center hover:bg-opacity-70 px-2 rounded-lg py-1 hover:bg-gray-200 text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}]">
                                            <div class="flex-shrink-0">
                                                @svg($modulo->icono, 'w-7')
                                            </div>

                                            <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] focus:outline-none transition ease-in-out duration-150">{{ $modulo->nombre }}</span>
                                        </div>

                                        @if (!empty($modulo->submodulos))
                                            @foreach ($modulo->submodulos as $submodulo)
                                                <ul class="pl-4 w-full"
                                                    x-transition:enter="transition ease-out duration-500"
                                                    x-transition:enter-start="opacity-0 transform scale-90"
                                                    x-transition:enter-end="opacity-100 transform scale-100"
                                                    x-transition:leave="transition ease-in duration-300"
                                                    x-transition:leave-start="opacity-100 transform scale-100"
                                                    x-transition:leave-end="opacity-0 transform scale-90" x-cloak
                                                    x-show="showSubMenu">
                                                    <li class="">
                                                        <a href="/{{ $submodulo->url }}"
                                                            class="flex items-center text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] w-full">
                                                            <span class="text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}]  hover:bg-opacity-70 hover:bg-gray-200  rounded-md px-3 py-2 text-sm  w-full">
                                                                {{ $submodulo->nombre }}
                                                            </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        @endif
                        @php
                            // Agrupar submódulos por módulo
                            $submodulosAgrupadosPorModulo = config('app.submodulosActivos')->groupBy('modulo_id');
                            
                        @endphp
                        @if (config('app.submodulosActivos'))
                            @foreach ($submodulosAgrupadosPorModulo as $moduloId => $submodulos)
                                @php
                                    // Obtener el módulo asociado a estos submódulos
                                    $modulo = $submodulos->first()->modulo;
                                @endphp
                                @if (!empty($modulo->icono))
                                    <li class="py-2 cursor-pointer" x-data="{ showSubMenu: true }">
                                        <div
                                            class="flex items-center hover:bg-opacity-70 px-2 rounded-lg py-1 hover:bg-gray-200 text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}]">
                                            <div class="flex-shrink-0">
                                                @svg($modulo->icono, 'w-7')
                                            </div>


                                            <span
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] focus:outline-none transition ease-in-out duration-150">{{ $modulo->nombre }}</span>
                                        </div>

                                        <ul class="pl-4 w-full" x-transition:enter="transition ease-out duration-500"
                                            x-transition:enter-start="opacity-0 transform scale-90"
                                            x-transition:enter-end="opacity-100 transform scale-100"
                                            x-transition:leave="transition ease-in duration-300"
                                            x-transition:leave-start="opacity-100 transform scale-100"
                                            x-transition:leave-end="opacity-0 transform scale-90" x-cloak
                                            x-show="showSubMenu">
                                            @foreach ($submodulos as $submodulo)
                                                <li class="">
                                                    <a href="/{{ $submodulo->url }}"
                                                        class="flex items-center text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] w-full">
                                                        <span
                                                            class="text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] text-shadow transition-shadow duration-300  hover:bg-opacity-70
                                                    hover:bg-gray-200
                                                    rounded-md px-3 py-2 text-sm  w-full">
                                                            {{ $submodulo->nombre }}
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        @endif


                    </ul>
                </nav>
            </div>
        </div>
        @if (!empty(config('app.empresa')->nombre))
            <div class="items-center justify-end px-4 py-2 w-full">
                <img src="{{ asset(config('app.empresa')->logo) ?? '' }}" alt="" title="logo" class="my-4">
                <div class="text-[{{ config('app.colorLetra') }}] mx-auto">
                    <div class="mx-auto w-full">
                        <p class="text-xs">Dashboard</p>
                        <div class="flex items-center">
                            <div class="text-center font-medium block  text-xs">{{ config('app.empresa')->nombre }}</div>
                            <div class="animate-ping  @if (config('app.empresa')->exists) bg-[{{ config('app.empresa')->color }}] @endif p-2 rounded-full w-2 h-2 mx-2"></div>
                        </div>
                    </div>
                </div>
                <div class="bg-[{{ config('app.empresa')->color }}] justify-end w-full h-4 rounded-full mt-2 shadow-inner"></div>
            </div>
        @endif
    </div>

</div>
