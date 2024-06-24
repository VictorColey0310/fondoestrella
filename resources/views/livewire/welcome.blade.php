<div class="overflow-hidden mx-auto">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">


    <div>

        <style>
            .carousel {
                background: #EEE;
            }

            /* cell number */
            .carousel-cell:before {
                display: block;
                text-align: center;
                content: counter(carousel-cell);
                line-height: 200px;
                font-size: 80px;
                color: white;
            }

            /* Media query para dispositivos más pequeños */
            @media (max-width: 640px) {
                .carousel img {
                    max-width: 100%;
                    /* height: 200px; */
                    object-fit: contain;

                }
            }
        </style>

{{-- xl:h-[400px] sm:h-[200px] md:h-[300px] lg:h-[400px] h-[200px]  --}}
        <div class="carousel overflow-hidden w-full"
            data-flickity='{ "freeScroll": true, "wrapAround": true }' data-aos="fade-down" data-aos-easing="linear"
            data-aos-duration="500" id="carousel">
            @foreach ($sliders as $slider)
                <a href="{{ $slider->url }}" target="_blank">
                    <div>
                        <img src="{{ asset($slider->imagen) }}" class="w-full" alt="slider-image">
                    </div>
                </a>
            @endforeach
        </div>



    </div>

        <!-- Sección de beneficios -->
        <section class=" bg-bg-no-repeat bg-cover p-10">

            <div class="flex flex-row flex-wrap justify-center md:space-x-6">

                    <a href="https://servicios3.selsacloud.com/linix/v6/860529417/loginAsociado.php?nit=860529417" target="_blank" >
                        <div class=" mx-2 my-4 bg-white rounded-xl shadow-2xl overflow-hidden hover:shadow-lg transition duration-300 ease-in-out"
                            data-aos="zoom-in-down" data-aos-easing="linear" data-aos-duration="500">
                            <img src="{{ asset('img/estado.webp') }}" class=" w-72 h-48 object-cover" alt="Imagen">
                            <div class="p-4 bg-[#3DC1B7]">
                                <h2 class="text-xl font-bold mb-2 text-white text-center uppercase">ESTADO DE CUENTA
                                </h2>
                            </div>
                        </div>
                    </a>
                    <a href="https://simulador.fondoestrella.com/" target="_blank" >
                        <div class=" mx-2 my-4 bg-white rounded-xl shadow-2xl overflow-hidden hover:shadow-lg transition duration-300 ease-in-out"
                            data-aos="zoom-in-down" data-aos-easing="linear" data-aos-duration="500">
                            <img src="{{ asset('img/simulador.webp') }}" class=" w-72 h-48 object-cover" alt="Imagen">
                            <div class="p-4 bg-[#3DC1B7]">
                                <h2 class="text-xl font-bold mb-2 text-white text-center uppercase">SIMULADOR DE CREDITO
                                </h2>
                            </div>
                        </div>
                    </a>
                    <a href="./descarga-de-documentos" target="_blank" >
                        <div class=" mx-2 my-4 bg-white rounded-xl shadow-2xl overflow-hidden hover:shadow-lg transition duration-300 ease-in-out"
                            data-aos="zoom-in-down" data-aos-easing="linear" data-aos-duration="500">
                            <img src="{{ asset('img/documentos.webp') }}" class=" w-72 h-48 object-cover" alt="Imagen">
                            <div class="p-4 bg-[#3DC1B7]">
                                <h2 class="text-xl font-bold mb-2 text-white text-center uppercase">DESCARGAR FORMATOS
                                </h2>
                            </div>
                        </div>
                    </a>
                    <a href="https://www.banco.scotiabankcolpatria.com/PagosElectronicos/Referencias.aspx?IdConvenio=11961" target="_blank" >
                        <div class=" mx-2 my-4 bg-white rounded-xl shadow-2xl overflow-hidden hover:shadow-lg transition duration-300 ease-in-out"
                            data-aos="zoom-in-down" data-aos-easing="linear" data-aos-duration="500">
                            <img src="{{ asset('img/pse.jpg') }}" class=" w-72 h-48 object-cover" alt="Imagen">
                            <div class="p-4 bg-[#3DC1B7]">
                                <h2 class="text-xl font-bold mb-2 text-white text-center uppercase">PAGAR CON PSE
                                </h2>
                            </div>
                        </div>
                    </a>

            </div>
        </section>

    <!-- Sección de tarjetas -->
    <!--section class="flex flex-wrap justify-center bg-bg-no-repeat bg-cover p-10 max-w-7xl mx-auto lg:my-20">
        @foreach ($tarjetas as $tarjeta)
            <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-4" data-aos="zoom-in" data-aos-easing="linear"
                data-aos-duration="500">
                <div class="rounded-xl shadow-2xl overflow-hidden hover:shadow-lg transition duration-300 ease-in-out">
                    <a href="{{ $tarjeta->url }}" target="_blank" class="flex justify-between">
                        <div class="items-center text-center w-2/3 mx-auto py-4">
                            <div class="flex-shrink-0 mx-auto">
                                @svg($tarjeta->icono, 'w-28 mx-auto text-[#3DC1B7] ')
                            </div>
                            <div class="text-gray-500 text-sm mx-auto">{{ $tarjeta->nombre }}</div>
                        </div>

                        <div class="flex items-center justify-center rounded-r-xl w-1/3 bg-[#3DC1B7] ">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="blue"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="text-white w-8 h-8">
                                <path d="M5 12h14" stroke="white"></path>
                                <path d="M12 5l7 7-7 7" stroke="white"></path>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </section-->

    <!-- Sección de asociaciones -->
    <section class=" items-center text-white w-full">
        @foreach ($asosiaciones as $asosiacion)
            <div class="relative w-full  mx-auto bg-cover py-10 " data-aos="fade-down" data-aos-easing="linear"
                data-aos-duration="500" style="background-image: url('{{ asset($asosiacion->imagen) }}');">
                <div class="flex w-full">
                    <div class="w-full lg:w-2/3 my-auto py-14 px-4">
                        <div class=" transform text-center text-gray-500 my-10">
                            <h1 class="md:text-4xl mb-4 uppercase font-semibold max-w-2xl mx-auto">
                                {{ $asosiacion->descripcion }}</h1>
                            <a href="{{ route('convenio') }}" >
                                <div data-aos="fade-right" data-aos-easing="linear" data-aos-duration="500"
                                    class="btn text-xl rounded-full mx-auto w-56 px-5 text-white py-3 my-10 bg-[#3DC1B7] shadow-2xl hover:opacity-90 hover:shadow-lg transition-all duration-300 font-semibold">
                                    CONSULTALO AQUÍ
                                </div>

                            </a>
                        </div>
                    </div>
                    <div class="lg:w-1/3">
                        <!-- Contenido del div vacío -->
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    <section class="items-center text-white w-full lg:py-20 bg-gray-100">
        <div class="justify-between max-w-7xl rounded-3xl shadow-2xl mx-auto bg-cover my-20"
            style="background-image: url('./img/asociarse.webp');" data-aos="fade-down" data-aos-easing="linear"
            data-aos-duration="500">

            <div class="justify-between flex">
                <div class=" lg:w-1/2">
                    <!-- Contenido del div vacío -->
                </div>
                <div class="w-full lg:w-1/2 my-auto py-14">
                    <div class="transform text-center text-white my-10">
                        <a href="{{route('como-asociarse')}}" >
                            <div data-aos="fade-left" data-aos-easing="linear" data-aos-duration="500"
                                class="btn text-xl rounded-full mx-auto w-56 px-5 py-3 my-10 bg-[#3DC1B7] shadow-2xl hover:opacity-90 hover:shadow-lg transition-all duration-300 font-semibold">
                                ¿COMO ASOCIARSE?
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- Sección de beneficios -->
    <section class=" bg-bg-no-repeat bg-cover p-10">
        <div class="text-center text-gray-500 text-xl my-4 uppercase font-semibold">BENEFICIOS</div>
        <div class="flex flex-row flex-wrap justify-center md:space-x-6">
            @foreach ($beneficios as $beneficio)
                <a href="{{ $beneficio->url ?? '' }}" >
                    <div class=" mx-2 my-4 bg-white rounded-xl shadow-2xl overflow-hidden hover:shadow-lg transition duration-300 ease-in-out"
                        data-aos="zoom-in-down" data-aos-easing="linear" data-aos-duration="500">
                        <img src="{{ asset($beneficio->imagen) }}" class=" w-72 h-48 object-cover" alt="Imagen">
                        <div class="p-4 bg-[#3DC1B7]">
                            <h2 class="text-xl font-bold mb-2 text-white text-center uppercase">{{ $beneficio->titulo }}
                            </h2>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Sección de convenios -->

    <!-- section class="items-center text-white w-full">

        <div class="justify-between mx-auto my-20 ">
            <div class="flex hidden lg:flex">
                <div class="w-1/2 bg-contain bg-no-repeat " style="background-image: url('./img/convenios.webp');"
                    data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500">

                </div>

                <div class="md:w-1/2 my-auto pt-40 lg:py-40 ">
                    <div class=" transform text-center text-white  mt:10 lg:my-10">

                        <a href="{{route('convenio')}}" >
                            <div data-aos="fade-left" data-aos-easing="linear" data-aos-duration="500"
                                class="space-x-2 flex justify-between btn text-xl rounded-full mx-auto w-60  px-5 py-3 my-10 bg-[#3DC1B7] shadow-2xl hover:opacity-90 hover:shadow-lg transition-all duration-300 font-semibold">
                                <div class="my-auto">VER CONVENIOS
                                </div>
                                <div class="rounded-full bg-white p-1 my-auto font-semibold shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-6 h-6 text-[#3DC1B7] ">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>

                                </div>
                            </div>

                        </a>
                    </div>
                </div>

            </div>

            <div class="flex relative lg:hidden">
                <img src="{{ asset('img/convenios.webp') }}" class="w-full lg:w-1/2 absolute " alt="Descripción de la imagen" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500">

                <div class="w-full my-auto pt-40 lg:py-40">
                    <div class="transform text-center text-white   mt:10 lg:my-10">
                        <a href="{{route('convenio')}}" >
                            <div data-aos="fade-left" data-aos-easing="linear" data-aos-duration="500" class="space-x-2 flex justify-between btn text-xl rounded-full mx-auto w-60  px-5 py-3 my-10 bg-[#3DC1B7] shadow-2xl hover:opacity-90 hover:shadow-lg transition-all duration-300 font-semibold">
                                <div class="my-auto">VER CONVENIOS</div>
                                <div class="rounded-full bg-white p-1 my-auto font-semibold shadow-inner">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-[#3DC1B7]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </section-->




    <!-- Sección de galería -->
    <section class="flex items-center justify-center bg-bg-no-repeat bg-cover p-10" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500">
        <a href="{{route('vistagaleria')}}" >
            <div class="bg-white shadow-2xl rounded-xl overflow-hidden relative  hover:shadow-sm transition duration-300 ease-in-out">
                <div class="flex overflow-nonerelative">
                    <!-- Imágenes de la galería -->
                    @foreach ($galerias as $galeria)
                        <img src="{{ asset($galeria->imagen) }}" class="w-auto h-64 object-cover" alt="Imagen">
                    @endforeach
                    <!-- Capa de superposición desvanecida -->
                    <div class="absolute inset-0">
                        <div class="absolute inset-0 bg-gradient-to-l from-teal-500 via-transparent to-transparent">
                        </div>

                    </div>
                </div>
                <!-- Botón -->
                <div class="absolute bottom-1/3 right-6" data-aos="fade-down" data-aos-easing="linear"
                    data-aos-duration="500">
                    <button
                        class="rounded-full  space-x-3 text-white font-bold py-2 px-4 text-3xl flex items-center justify-center w-min h-min">
                        <div class="shadow" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="500"
                            data-aos-anchor-placement="top-bottom">
                            GALERÍA
                        </div>
                        <div class="rounded-full bg-white p-1 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-6 h-6 text-[#3DC1B7]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </button>
                </div>

            </div>
        </a>

    </section>

    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script>
        var flkty = new Flickity('#carousel', {
            "freeScroll": true,
            "wrapAround": true
        });
    
        function nextSlide() {
            flkty.next();
        }
    
        setInterval(nextSlide, 5000); // Cambiar de slide cada 5 segundos
    </script>
</div>

{{-- <div class="flex items-center hover:bg-opacity-70 px-2 rounded-lg py-1 hover:bg-gray-200 text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}]">


    <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[{{ config('app.colorLetra') }}] hover:text-[{{ config('app.colorLetraHover') }}] focus:outline-none transition ease-in-out duration-150">{{ $modulo->nombre }}</span>
</div> --}}
