<div>


    <div class="min-h-[200px] bg-teal-500 flex items-center justify-center">
        <div class=" py-20 bg-teal-500  items-center ">
            <div class="container mx-auto text-white">

                <div class=" text-center">
                    <h1 class="text-4xl font-bold mb-2 max-w-2xl mx-auto " data-aos="fade-down" data-aos-easing="linear"
                        data-aos-duration="500">CREDITOS</h1>
                </div>

            </div>
        </div>
        <div class="av-extra-border-element border-extra-arrow-down bg-teal-500"></div>
    </div>

    <div class="flex justify-center items-center">
        <!-- Contenido dentro del nuevo contenedor -->
        <div class="container mx-auto text-white text-center shadow-lg rounded-lg overflow-hidden max-w-5xl">
            <!-- Imagen centrada desde los assets de Laravel -->
            <img src="{{ asset('img/creditos.webp') }}" alt="Imagen" class="mx-auto max-w-full max-h-full object-contain p-4">
        </div>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 p-4">
        @foreach ($creditos as $credito)
            <div class="relative">
                <img class="rounded-xl mb-4 shadow-lg object-cover w-full h-80"  data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500" src="{{ asset($credito->imagen) }}">


                <h4 class="text-xl text-[#3DC1B7] text-center font-bold my-4 uppercase" data-aos="fade-down"
                    data-aos-easing="linear" data-aos-duration="500">{{ $credito->titulo }}</h4>
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full text-left py-2 px-4 rounded-md text-gray-500 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:bg-gray-200"
                        data-aos="fade-left" data-aos-easing="linear" data-aos-duration="500">
                        Ver más
                        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                        </svg>
                    </button>
                    <div x-show="open"  @click.away="open = false" class="bg-white shadow-lg py-2 px-4 mt-2 rounded-lg mb-1 text-gray-700 text-justify">
                        <p><strong>Monto:</strong></p>
                        <p>{!! nl2br($credito->monto)!!}</p>
                        <p><strong>Plazo Máximo:</strong></p>
                        <p>{!! nl2br ($credito->plazo_maximo)!!}</p>
                        <p><strong>Tasa de interés:</strong></p>
                        <p>{!! nl2br ($credito->tasa_interes) !!}</p>
                        <p><strong>Tasa Preferencial:</strong></p>
                        <p>{!! nl2br ($credito->tasa_preferencial)!!}</p>
                        <p><strong>Novación:</strong></p>
                        <p>{!! nl2br ($credito->novacion)!!}</p>
                        <p><strong>Requisitos:</strong></p>
                        <p>{!! nl2br ($credito->requisitos)!!}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>



</div>
