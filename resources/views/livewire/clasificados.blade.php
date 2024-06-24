<div>

    <div class="min-h-[200px] bg-teal-500 flex items-center justify-center">
        <div class=" py-20 bg-teal-500  items-center ">
            <div class="container mx-auto text-white">

                <div class=" text-center">
                    <h1 class="text-4xl font-bold mb-2 max-w-2xl mx-auto " data-aos="fade-down" data-aos-easing="linear"
                        data-aos-duration="500">CLASIFICADOS</h1>
                </div>

            </div>
        </div>
        <div class="av-extra-border-element border-extra-arrow-down bg-teal-500"></div>
    </div>

    <div class="bg-white sm:py-0 py-5">
        @foreach ($clasificados as $clasificado)
        <div class="container mx-auto flex flex-wrap items-center shadow-2xl overflow-hidden hover:shadow-lg transition duration-300 ease-in-out rounded-2xl lg:my-20">
            <div class="w-full md:w-1/3 mb-8 md:mb-0 pr-8">
                <img src="{{ asset($clasificado->imagen) }}" alt="Descripción de la imagen" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500" class="w-full h-auto rounded-2xl">
            </div>
            <div class="w-full md:w-2/3 px-4">
                <h1 class="text-3xl text-[#3DC1B7] text-left font-bold my-6 md:my-4 uppercase" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500">{{$clasificado->titulo}}</h1>
                <p class="mb-6 md:mb-4 text-left">{{$clasificado->descripcion}}</p>
            </div>
        </div>
        @endforeach
    </div>

</div>
