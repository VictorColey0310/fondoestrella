<div>

    <div class="py-20 bg-teal-500 items-center">
        <div class="container mx-auto text-white">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2 max-w-2xl mx-auto" data-aos="fade-down" data-aos-easing="linear"
                    data-aos-duration="500">NORMATIVIDAD</h1>
            </div>
        </div>
    </div>


    <div class="bg-white sm:py-0 py-5">
        <div class="container mx-auto">
            <div class="flex flex-wrap items-center shadow-2xl overflow-hidden hover:shadow-lg transition duration-300 ease-in-out rounded-2xl lg:my-20"
                data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500">
                <div class="w-full md:w-1/2 mb-4 md:mb-0">
                    <img src="./img/normatividad.webp" alt="Imagen" class="rounded-2xl w-full object-cover">
                </div>

                <div class="w-full md:w-1/2 px-10 text-left sm:pb-0 pb-10 text-gray-700 text-lg">
                    <a href="./documentos/CODIGO-BUEN-GOBIERNO-FE-ESTRELLA.pdf" target="_blank" class="block text-lg mb-4 uppercase">
                        <div class="flex max-w-xs space-x-2 ">
                            <div class="my-auto">
                                CÓDIGO DE BUEN GOBIERNO FONDO ESTRELLA
                            </div>
                            <div class="my-auto rdounded-lg bg-teal-500 p-1 rounded-full text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.9" stroke="currentColor" class="w-4 h-4 my-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                </svg>
                            </div>
                        </div>
                    </a>


                    <a href="./documentos/POLITICA-TRATAMIENTO-INFORMACION-PERSONAL.pdf" target="_blank" class="block text-lg mb-4 uppercase">
                        <div class="flex max-w-xs space-x-2 ">
                            <div class="my-auto">
                                POLÍTICA DE TRATAMIENTO DE INFORMACIÓN PERSONAL
                            </div>
                            <div class="my-auto rdounded-lg bg-teal-500 p-1 rounded-full text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.9" stroke="currentColor" class="w-4 h-4 my-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                </svg>
                            </div>
                        </div>
                    </a>

                    @foreach ($comoasociarse as $como_asociarse)
                    <a href="{{ asset($como_asociarse->url1) }}" target="_blank" class="block text-lg mb-4 uppercase">
                        <div class="flex max-w-xs space-x-2 ">
                            <div class="my-auto">
                                 ESTATUTOS
                            </div>
                            <div class="my-auto rdounded-lg bg-teal-500 p-1 rounded-full text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.9" stroke="currentColor" class="w-4 h-4 my-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    @endforeach


                    <a href="./documentos/Manual-SARLAFT.pdf" target="_blank"
                        class="block text-lg mb-4 uppercase">
                        <div class="flex max-w-xs space-x-2 ">
                            <div class="my-auto">
                                MANUAL DE SARLAFT
                            </div>
                            <div class="my-auto rdounded-lg bg-teal-500 p-1 rounded-full text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.9" stroke="currentColor" class="w-4 h-4 my-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                </svg>
                            </div>
                        </div>
                    </a>

                    <a href="./documentos/REGLAMENTO-DE-CREDITO.pdf" target="_blank"
                        class="block text-lg mb-4 uppercase">
                        <div class="flex max-w-xs space-x-2 ">
                            <div class="my-auto">
                                REGLAMENTO DE CRÉDITO
                            </div>
                            <div class="my-auto rdounded-lg bg-teal-500 p-1 rounded-full text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.9" stroke="currentColor" class="w-4 h-4 my-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                </svg>
                            </div>
                        </div>
                    </a>

                    <a href="./documentos/REGLAMENTO-AHORROS.pdf" target="_blank"
                        class="block text-lg mb-4 uppercase">
                        <div class="flex max-w-xs space-x-2 ">
                            <div class="my-auto">
                                REGLAMENTO DE AHORROS
                            </div>
                            <div class="my-auto rdounded-lg bg-teal-500 p-1 rounded-full text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.9" stroke="currentColor" class="w-4 h-4 my-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                </svg>
                            </div>
                        </div>
                    </a>

                    <a href="./documentos/REGLAMENTO-FONDO-SOLIDARIO-Y-BIENESTAR-SOCIAL.pdf" target="_blank"
                        class="block text-lg mb-4 uppercase">
                        <div class="flex max-w-xs space-x-2 ">
                            <div class="my-auto">
                                REGLAMENTO FONDO SOLIDARIO Y BIENESTAR SOCIAL
                            </div>
                            <div class="my-auto rdounded-lg bg-teal-500 p-1 rounded-full text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.9" stroke="currentColor" class="w-4 h-4 my-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                </svg>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>



</div>
