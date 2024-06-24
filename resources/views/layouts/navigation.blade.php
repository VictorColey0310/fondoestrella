<nav x-data="{ open: false }" class="bg-[{{ config('app.colorMenu') }}] border-gray-200 border-b-2 text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}]">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto md:mr-64 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-12">
            <div class="text-center justify-center my-auto font-semibold">
                @if (!empty(config('app.empresa')->nombre))
                    Bienvenido {{ auth()->user()->name?? '' }} - <span
                        class="italic font-normal hidden md:inline">Su Rol
                        actual es </span><span class="italic font-normal">{{ auth()->user()->rol->nombre }}</span> <span class="font-semibold"> - {{ config('app.empresa')->nombre }}</span>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ml-8 2xl:mr-16">


                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <div @click="open = ! open">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0"
                        style="display: none;" @click="open = false">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                            @if (config('app.rol_super'))
                                <x-dropdown-link :href="route('settings')">
                                    {{ __('Configuracion') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('categories')">
                                    {{ __('Categorias') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('enterprises')">
                                    {{ __('Empresas') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('modules')">
                                    {{ __('Modulos') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('submodules')">
                                    {{ __('Submodulos') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('roles')">
                                    {{ __('Roles') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('users')">
                                    {{ __('Usuarios') }}
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Mi perfil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden h-screen overflow-auto">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <ul>
                <li class="text-gray-300 mx-3">
                    @livewire('empresa-seleccionada')
                </li>

                @if (config('app.modulosActivos'))
                    @foreach (config('app.modulosActivos') as $modulo)
                        <li class="py-2 mx-3" x-data="{ showSubMenu: false }"  @click="showSubMenu = !showSubMenu">
                            <div class="flex items-center text-gray-400 hover:text-gray-600">
                                @svg($modulo->icono, 'w-7')
                                <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-400 hover:text-gray-600 focus:outline-none transition ease-in-out duration-150">{{ $modulo->nombre }}</span>
                            </div>

                            @if (!empty($modulo->submodulos))
                                @foreach ($modulo->submodulos as $submodulo)
                                    <ul class="pl-4 w-full" x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 transform scale-90"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-90" x-cloak
                                        x-show="showSubMenu">
                                        <li class="">
                                            <a href="/{{ $submodulo->url }}"
                                                class="flex items-center text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] w-full">
                                                <span
                                                    class="text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}]  hover:bg-opacity-70 hover:bg-gray-200  rounded-md px-3 py-2 text-sm  w-full">
                                                    {{ $submodulo->nombre }}
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                @endforeach
                            @endif
                        </li>
                    @endforeach
                @endif
                @php
                    if (config('app.submodulosActivos')) {
                        // Agrupar submódulos por módulo
                        $submodulosAgrupadosPorModulo = config('app.submodulosActivos')->groupBy('modulo_id');
                    }

                @endphp
                @if (config('app.submodulosActivos'))
                    @foreach ($submodulosAgrupadosPorModulo as $moduloId => $submodulos)
                        @php
                            // Obtener el módulo asociado a estos submódulos
                            $modulo = $submodulos->first()->modulo;
                        @endphp
                        @if (!empty($modulo->icono))
                            <li class="py-2 cursor-pointer" x-data="{ showSubMenu: false }" @click="showSubMenu = !showSubMenu">
                                <div class="flex items-center text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}]">
                                    @svg($modulo->icono, 'w-7')
                                    <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] focus:outline-none transition ease-in-out duration-150">{{ $modulo->nombre }}</span>
                                </div>

                                <ul class="pl-4 w-full" x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="opacity-0 transform scale-90"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-90" x-cloak x-show="showSubMenu">
                                    @foreach ($submodulos as $submodulo)
                                        @if (!empty($submodulo->modulo->icono))
                                            <li class="">
                                                <a href="/{{ $submodulo->url }}"
                                                    class="flex items-center text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] w-full">
                                                    <span class="text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] text-shadow transition-shadow duration-300  hover:bg-opacity-70 hover:bg-gray-200 rounded-md px-3 py-2 text-sm  w-full">
                                                        {{ $submodulo->nombre }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t h-screen border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Mi perfil') }}
                </x-responsive-nav-link>
                @if (config('app.rol_super'))
                    <x-responsive-nav-link :href="route('modules')">
                        {{ __('Modulos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('submodules')">
                        {{ __('Submodulos') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('roles')">
                        {{ __('Roles') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('enterprises')">
                        {{ __('Empresas') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('users')">
                        {{ __('Usuarios') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('settings')">
                        {{ __('configuracion') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('categories')">
                        {{ __('Categorias') }}
                    </x-responsive-nav-link>
                    {{-- <x-responsive-nav-link :href="route('item_base')">
                        {{ __('Modelos Estandar') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('caracterizacion')">
                        {{ __('Modelos Caracterización') }}
                    </x-responsive-nav-link> --}}
                @endif
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
