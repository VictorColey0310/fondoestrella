<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" type="text/css" href="/css/app.css" media="screen"/>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
        
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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />
        <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script> 
        <x-livewire-alert::flash />
    </body>
</html>
