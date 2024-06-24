<div class="overflow-hidden">

    <div class="min-h-[200px] bg-teal-500 flex items-center justify-center">
        <div class=" py-20 bg-teal-500  items-center ">
            <div class="container mx-auto text-white">

                <div class=" text-center">
                    <h1 class="text-4xl font-bold mb-2 max-w-2xl mx-auto " data-aos="fade-down" data-aos-easing="linear"
                        data-aos-duration="500">CONVENIOS</h1>
                </div>

            </div>
        </div>
        <div class="av-extra-border-element border-extra-arrow-down bg-teal-500"></div>
    </div>


    @foreach ($grupo_convenios as $grupo_convenio)
        <div class=" mx-auto w-full justify-between px-4 lg:px-20">
            <h4 class="text-xl text-[#3DC1B7] text-center font-bold my-4 uppercase" data-aos="fade-down"
                data-aos-easing="linear" data-aos-duration="500">{{ $grupo_convenio->titulo }}</h4>
            <div class=" mx-auto lg:my-12 flex justify-end">
                <!-- Aquí agregué 'justify-end' para alinear a la derecha -->
                <div class=" mx-auto sm:justify-between sm:flex sm:space-x-4  space-y-4 sm:space-y-0">
                    @foreach ($grupo_convenio->convenios as $convenio)
                        <div class=" border rounded-lg overflow-hidden max-w-lg ">
                            <div class="p-4">
                                <h4 class="text-xl text-[#3DC1B7] font-bold uppercase mb-2">{{ $convenio->nombre }}</h4>
                                <div class="max-w-xs mx-auto my-2">
                                    <img src="{{ asset($convenio->imagen) }}" class="w-full h-48 object-contain mx-auto" alt="Imagen 1"  data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500">

                                </div>
                                <p class="text-gray-700">{{ $convenio->descripcion }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach


    <div class=" mx-auto w-full justify-between px-4 lg:px-20">
        <h4 class="text-xl text-[#3DC1B7] text-center font-bold my-4 uppercase" data-aos="fade-down"
            data-aos-easing="linear" data-aos-duration="500">FUNERARIOS</h4>
        <div class="w-full flex justify-center  space-x-4">

            <div class="border rounded-lg overflow-hidden">
                    <img src="{{ asset('img/mascotas.webp') }}" class="w-full sm:h-48 object-cover" alt="Imagen 1">
                    <div class="p-4">
                        <h4 class="text-xl text-[#3DC1B7] font-bold uppercase mb-2">PLAN MASCOTAS</h4>
                        <div x-data="{ open: false }">
                            <h4 class="text-xl text-[#3DC1B7] font-bold uppercase mb-2"></h4>
                            <button @click="open = !open" class="flex items-center justify-between w-full text-left py-2 px-4 rounded-md text-gray-500 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:bg-gray-200" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="500">
                                <span>Ver beneficios</span>
                                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                            </button>
                            <div x-show="open" class="bg-white shadow-lg py-2 px-4 mt-2 rounded-lg mb-1">
                                <ul class=" pl-6" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="500">
                                    <li class="text-lg text-gray-700 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                        Retiro de la mascota en lugar de fallecimiento
                                    </li>
                                    <li class="text-lg text-gray-700 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                        Cofre fúnebre
                                    </li>
                                    <li class="text-lg text-gray-700 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                            Recordatorio
                                    </li>
                                    <li class="text-lg text-gray-700 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                            Cremación colectiva
                                    </li>
                                    <li class="text-lg text-gray-700 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 inline-block mr-2 text-[#3DC1B7]">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                            Sala de acompañamiento hasta por 3 horas
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border rounded-lg overflow-hidden">
                    <img src="{{ asset('img/abuelos.webp') }}" class="w-full sm:h-48 object-cover" alt="Imagen 1">
                    <div class="p-4">
                        <h4 class="text-xl text-[#3DC1B7] font-bold uppercase mb-2">PLAN ABUELOS</h4>
                        <p class="text-lg text-gray-700 mb-2">
                            Protégete y protegelos es la mejor muestra de amor
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
