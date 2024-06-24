<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">



<head>
    <meta charset="utf-8">
    <meta name="keywords" content="fondo estrella, inversion, ahorro, empleados, estrella, financiero,Bogota, Colombia" />
    <meta name="description"
        content="Descubre cómo nuestro fondo de empleados ofrece beneficios financieros exclusivos para nuestros miembros. Accede a préstamos, ahorros y servicios personalizados para mejorar tu bienestar financiero." />
    <meta name="author" content="U-site" />
    <meta name="copyright" content="U-site" />
    <link rel="icon" type="image/ico" href="favicon.ico">
    <meta property="og:image" content="/img/logo_fondo.jpg">
    <meta property="og:url" content="https://fondoestrella.com">
    <meta property="og:title" content="Fondo de Empleados Estrella IES">
    <meta property="og:type" content="Web" />
    <meta property="og:description"
        content="Descubre cómo nuestro fondo de empleados ofrece beneficios financieros exclusivos para nuestros miembros. Accede a préstamos, ahorros y servicios personalizados para mejorar tu bienestar financiero." />
    <link rel="canonical" href="https://fondoestrella.com">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fondo Empleados Estrella IES</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css" media="screen" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href=" https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


    @livewireStyles

    <div class="shadow-xl z-40  sm:space-x-10 w-full bg-blue-50 border-b-4 border-[#76c2bc]">

        <nav class=" sm:flex justify-between  sm:px-8 max-w-7xl mx-auto">
            <div class="flex items-center justify-between ml-12 lg:px-4">
                <!-- Logo -->
                <div class="w-36 ">
                    <div class="object-fill cover max-w-xs">
                        <x-application-logo />
                    </div>
                </div>
                <!-- Botón de hamburguesa para dispositivos móviles -->
                <button id="menu-toggle" class="block lg:hidden mr-4">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="lg:pr-16 sm:pr-8 pr-4">
                <div class="text-right  max-w-4xl mx-auto w-full hidden sm:block">
                    <div class="pb-2 px-4">
                        <a href="https://servicios3.selsacloud.com/linix/v6/860529417/loginAsociado.php?nit=860529417" target="_blank"
                            class="bg-[#3DC1B7] hover:bg-[#14B8A6] text-white font-semibold text-sm pt-4 pb-1 mt-0  px-4 rounded-lg transition-colors duration-300 ease-in-out">IR
                            A ESTADO DE CUENTA</a>
                    </div>
                </div>
                <!-- Menú de navegación -->
                <!-- flex space-x-8 hidden lg:flex flex-wrap justify-center lg:justify-end-->
                <ul id="menu"
                    class="hidden lg:flex lg:justify-end  lg:top-0  lg:right-[200px] my-auto uppercase font-semibold text-sm">
                    <li class="text-right py-2 border-x border-[#5fc5be] hover:bg-[#60c2ba] hover:text-white text-gray-800 px-2"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="text-right py-2 border-r border-[#5fc5be] hover:bg-[#3DC1B7] hover:text-white text-gray-800 px-2 relative group">
                        <a class=" cursor-pointer">Nosotros</a>
                        <!-- Submenú de Beneficios -->
                        <ul class="absolute hidden bg-gray-800 text-center rounded-lg mt-2 py-1 w-32 text-white z-10 group-hover:block right-0 lg:right-auto lg:left-0">
                            <li><a href="{{ route('organigramas') }}" class="block px-4 py-2 hover:bg-gray-700">Organigrama</a></li>
                            <li><a href="{{ route('estructura') }}" class="block px-4 py-2 hover:bg-gray-700">Estructura</a></li>
                            <li><a href="{{ route('quienes-somos') }}" class="block px-4 py-2 hover:bg-gray-700">Quiénes somos</a></li>
                        </ul>
                    </li>
                    <li class="text-right py-2 border-r border-[#5fc5be]  hover:bg-[#3DC1B7] hover:text-white text-gray-800 px-2"><a href="{{ route('como-asociarse') }}">Cómo asociarse</a></li>
                    <li class="text-right py-2 border-r border-[#5fc5be] hover:bg-[#3DC1B7] hover:text-white text-gray-800 px-2 relative group">
                        <a class=" cursor-pointer">Beneficios</a>
                        <!-- Submenú de Beneficios -->
                        <ul class="absolute hidden bg-gray-800 text-center rounded-lg mt-2 py-1 w-32 text-white z-10 group-hover:block right-0 lg:right-auto lg:left-0">
                            <li><a href="{{ route('ahorro') }}" class="block px-4 py-2 hover:bg-gray-700">Ahorro</a></li>
                            <li><a href="{{ route('creditos') }}" class="block px-4 py-2 hover:bg-gray-700">Creditos</a></li>
                            <li><a href="{{ route('auxilios') }}" class="block px-4 py-2 hover:bg-gray-700">Auxilios</a></li>
                            <li><a href="{{ route('eventos') }}" class="block px-4 py-2 hover:bg-gray-700">Eventos</a></li>
                        </ul>
                    </li>
                    <li class="text-right py-2  hover:bg-[#3DC1B7] hover:text-white text-gray-800 px-2  border-r border-[#5fc5be]"><a href="{{ route('convenio') }}" class="">Convenios</a></li>
                    <li class="text-right py-2  hover:bg-[#3DC1B7] hover:text-white text-gray-800 px-2 border-r border-[#5fc5be]"><a href="{{ route('normatividad') }}">Normatividad</a></li>
                    <li class="text-right py-2  hover:bg-[#3DC1B7] hover:text-white text-gray-800 px-2  border-r border-[#5fc5be]"><a href="{{ route('contactos') }}" class="">Contacto</a></li>
                    <li class="text-right py-2  hover:bg-[#3DC1B7] hover:text-white text-gray-800 px-2 border-r border-[#5fc5be]"><a href="{{ route('clasificados') }}" class="">Clasificados</a></li>

                    <!-- Puedes agregar más elementos del menú según sea necesario -->
                </ul>
            </div>


        </nav>
    </div>



</head>

<body class="font-sans antialiased">
    {{ $slot }}



    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />
</body>



<footer>
    <section>
    <div class="bg-gray-800 h-full w-full">
        <div class="container mx-auto flex flex-col text-white max-w-7xl my-10 text-sm pt-16">
            <div class="text-lg flex flex-wrap justify-center md:justify-between mb-6 flex-col md:flex-row">
                <!-- Primer listado -->
                <div class="w-full md:w-1/4 mb-6 md:mb-0 flex justify-center">
                    <ul>
                        <li>
                            <h3 class="text-xl font-bold text-[#3DC1B7]  mb-2">Navegación</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <a href="/" class="text-white  hover:text-[#39aea7]">Inicio</a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <a href="./quienessomos" class="text-white hover:text-[#39aea7]">Quiénes somos</a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <a href="./como-asociarse" class="text-white hover:text-[#39aea7]">Cómo asociarse</a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <a href="./ahorro" class="text-white hover:text-[#39aea7]">Beneficios</a>
                        </li>
                    </ul>
                </div>
                <!-- Segundo listado -->
                <div class="w-full md:w-1/4 mb-6 md:mb-0 ml-[-13px] flex justify-center pb-12">
                    <ul>
                        <li>
                            <h3 class="text-xl font-bold text-[#3DC1B7] mb-2">Recursos</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <a href="/convenio" class="text-white hover:text-[#39aea7]">Convenios</a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <a href="./vista-galeria" class="text-white hover:text-[#39aea7]">Galeria</a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <a href="./descarga-de-documentos" class="text-white hover:text-[#39aea7]">Documentos</a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            <a href="./contactos" class="text-white hover:text-[#39aea7]">Contacto</a>
                        </li>
                    </ul>
                </div>
                <!-- Información de contacto -->
                <div class="w-full md:w-1/4 mb-4 md:mb-0 md:pl-8 text-center md:text-left">
                    <h3 class="text-xl font-bold text-[#3DC1B7] mb-2">Información de contacto</h3>
                    <div class="flex flex-col md:flex-row items-center mb-2">
                        <svg viewBox="0 0 24 24" fill="#3DC1B7" width="26" height="26" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        <p class="md:pl-2">Ubicación: Bogotá, Colombia</p>
                    </div>
                    <div class="flex flex-col md:flex-row items-center">
                        <svg viewBox="0 0 24 24" fill="#3DC1B7" width="24" height="24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M14.05 6C15.0268 6.19057 15.9244 6.66826 16.6281 7.37194C17.3318 8.07561 17.8095 8.97326 18 9.95M14.05 2C16.0793 2.22544 17.9716 3.13417 19.4163 4.57701C20.8609 6.01984 21.7721 7.91101 22 9.94M18.5 21C9.93959 21 3 14.0604 3 5.5C3 5.11378 3.01413 4.73086 3.04189 4.35173C3.07375 3.91662 3.08968 3.69907 3.2037 3.50103C3.29814 3.33701 3.4655 3.18146 3.63598 3.09925C3.84181 3 4.08188 3 4.56201 3H7.37932C7.78308 3 7.98496 3 8.15802 3.06645C8.31089 3.12515 8.44701 3.22049 8.55442 3.3441C8.67601 3.48403 8.745 3.67376 8.88299 4.05321L10.0491 7.26005C10.2096 7.70153 10.2899 7.92227 10.2763 8.1317C10.2643 8.31637 10.2012 8.49408 10.0942 8.64506C9.97286 8.81628 9.77145 8.93713 9.36863 9.17882L8 10C9.2019 12.6489 11.3501 14.7999 14 16L14.8212 14.6314C15.0629 14.2285 15.1837 14.0271 15.3549 13.9058C15.5059 13.7988 15.6836 13.7357 15.8683 13.7237C16.0777 13.7101 16.2985 13.7904 16.74 13.9509L19.9468 15.117C20.3262 15.255 20.516 15.324 20.6559 15.4456C20.7795 15.553 20.8749 15.6891 20.9335 15.842C21 16.015 21 16.2169 21 16.6207V19.438C21 19.9181 21 20.1582 20.9007 20.364C20.8185 20.5345 20.663 20.7019 20.499 20.7963C20.3009 20.9103 20.0834 20.9262 19.6483 20.9581C19.2691 20.9859 18.8862 21 18.5 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        <p class="md:pl-2">Tel: +57 3124510939</p>
                    </div>

                    <div class="flex items-center">
                        <div class="flex justify-center my-2">
                            <a href="https://www.facebook.com/fondoestrella/" target="_blank" class="mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0,0,256,256" width="45px" height="45px">
                                    <g fill="#3DC1B7" fill-rule="nonzero" stroke="none" stroke-width="2"
                                        stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10"
                                        stroke-dasharray="" stroke-dashoffset="0" font-family="none"
                                        font-weight="none" font-size="none" text-anchor="none"
                                        style="mix-blend-mode: normal">
                                        <g transform="scale(8,8)">
                                            <path
                                                d="M16,4c-6.61557,0 -12,5.38443 -12,12c0,6.61557 5.38443,12 12,12c6.61557,0 12,-5.38443 12,-12c0,-6.61557 -5.38443,-12 -12,-12zM16,6c5.53469,0 10,4.46531 10,10c0,5.02739 -3.68832,9.16128 -8.51172,9.87891v-6.96289h2.84766l0.44727,-2.89258h-3.29492v-1.58008c0,-1.201 0.39458,-2.26758 1.51758,-2.26758h1.80469v-2.52344c-0.317,-0.043 -0.98786,-0.13672 -2.25586,-0.13672c-2.648,0 -4.19922,1.39798 -4.19922,4.58398v1.92383h-2.72266v2.89258h2.72266v6.9375c-4.74661,-0.78287 -8.35547,-4.88047 -8.35547,-9.85352c0,-5.53469 4.46531,-10 10,-10z">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </a>

                            <a href="https://www.instagram.com/fondo_estrella/" target="_blank" class="mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0,0,256,256" width="45px" height="45px">
                                    <g fill="#3DC1B7" fill-rule="nonzero" stroke="none" stroke-width="1"
                                        stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10"
                                        stroke-dasharray="" stroke-dashoffset="0" font-family="none"
                                        font-weight="none" font-size="none" text-anchor="none"
                                        style="mix-blend-mode: normal">
                                        <g transform="scale(8,8)">
                                            <path
                                                d="M11.46875,5c-3.55078,0 -6.46875,2.91406 -6.46875,6.46875v9.0625c0,3.55078 2.91406,6.46875 6.46875,6.46875h9.0625c3.55078,0 6.46875,-2.91406 6.46875,-6.46875v-9.0625c0,-3.55078 -2.91406,-6.46875 -6.46875,-6.46875zM11.46875,7h9.0625c2.47266,0 4.46875,1.99609 4.46875,4.46875v9.0625c0,2.47266 -1.99609,4.46875 -4.46875,4.46875h-9.0625c-2.47266,0 -4.46875,-1.99609 -4.46875,-4.46875v-9.0625c0,-2.47266 1.99609,-4.46875 4.46875,-4.46875zM21.90625,9.1875c-0.50391,0 -0.90625,0.40234 -0.90625,0.90625c0,0.50391 0.40234,0.90625 0.90625,0.90625c0.50391,0 0.90625,-0.40234 0.90625,-0.90625c0,-0.50391 -0.40234,-0.90625 -0.90625,-0.90625zM16,10c-3.30078,0 -6,2.69922 -6,6c0,3.30078 2.69922,6 6,6c3.30078,0 6,-2.69922 6,-6c0,-3.30078 -2.69922,-6 -6,-6zM16,12c2.22266,0 4,1.77734 4,4c0,2.22266 -1.77734,4 -4,4c-2.22266,0 -4,-1.77734 -4,-4c0,-2.22266 1.77734,-4 4,-4z">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="md:col-span-3 border-t-1 border-[#3DC1B7]">
        <div class="bg-[#28313d] h-full w-full">
        <div class="container mx-auto md:px-40 flex justify-between items-center py-2">
            <div class="my-6 text-md text-white md:pl-12">
                Desarrollado con 💚 por <a href="https:u-site.app" target="_blank">U-site</a> &copy; 2024
                | All rights reserved
            </div>
        </div>
</div>
    </section>
</footer>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>

</html>
