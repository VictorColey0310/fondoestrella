<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css" media="screen" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="keywords"
    content="Fondo empleados, Estrella ies, Fondo estrella, Bogota, Fondo inversion, credito,Colombia" />
<meta name="description"
    content="Nuestra misión es brindar soluciones financieras y sociales que contribuyan al crecimiento personal y profesional de nuestros asociados, promoviendo la solidaridad, la transparencia y la equidad" />
<meta name="author" content="U-site" />
<meta name="copyright" content="U-site" />
<meta property="og:image" content="/img/logo_fondo.jpg">
<meta property="og:url" content="fondoestrella.com">
<meta property="og:title" content="Fondo de empleados Estrella IES">
<meta property="og:type" content="Web" />
<meta property="og:description"
    content="Nuestra misión es brindar soluciones financieras y sociales que contribuyan al crecimiento personal y profesional de nuestros asociados, promoviendo la solidaridad, la transparencia y la equidad" />
<link rel="canonical" href="https://fondoestrella.com">



@livewireStyles

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <div class="flex md:h-screen">
            <!-- Barra lateral -->
            <div class="bg-gray-800">

                @include('layouts.lateral')
            </div>
            <div class="flex flex-col flex-1 bg-gray-100 w-full">
                <div class="fixed top-0 w-full z-10">
                    @include('layouts.navigation')
                </div>
                <div class="overflow-y-auto">
                    <div class="py-12">
                        <!-- Page Heading -->
                        @if (isset($header))
                            <header class="bg-white shadow">
                                <div class="mx-auto max-w-8xl px-4 py-3 sm:px-6 lg:px-8">
                                    {{ $header }}
                                </div>
                            </header>
                        @endif
                        <!-- Page Content -->
                        <main class="mx-auto max-w-full	 py-6">
                            <!-- Contenido principal -->
                            {{ $slot }}
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />
</body>

</html>
