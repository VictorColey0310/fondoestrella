<div>

    <div class="py-20 bg-teal-500 items-center">
        <div class="container mx-auto text-white">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2 max-w-2xl mx-auto" data-aos="fade-down" data-aos-easing="linear"
                    data-aos-duration="500">CONTACTO</h1>
            </div>
        </div>
    </div>

    <div class="bg-white sm:py-0 py-5">
        <div class="container mx-auto">
            <div class="flex flex-wrap items-center shadow-2xl overflow-hidden hover:shadow-lg transition duration-300 ease-in-out rounded-2xl lg:my-20"
              >
              <div class="w-full">
                <img src="{{asset('/img/contacto.png')}}" alt="" class="w-full text-center mx-auto">
              </div>
                <div class="w-full md:w-1/2 px-10 py-12">
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" wire:model="nombre"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-[#3DC1B7]" required
                            x-model="nombre">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-bold mb-2">E-mail:</label>
                        <input type="email" id="email" name="email" wire:model="email"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-[#3DC1B7]" required
                            x-model="email">
                    </div>
                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700 font-bold mb-2">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" wire:model="descripcion"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-[#3DC1B7]" rows="8" required
                            x-model="descripcion"></textarea>
                    </div>
                    <button wire:click="enviarEmail"
                        class="bg-[#3DC1B7] hover:bg-[#3DC1B7] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                       >Enviar</button>
                </div>

                <div class="w-full md:w-1/2 px-10 text-center sm:pb-0 pb-10 text-lg" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="500">
                    <h1 class="text-2xl text-[#3DC1B7] text-left font-bold my-4 uppercase" data-aos="fade-down"
                        data-aos-easing="linear" data-aos-duration="500">Fondo de Empleados Estrella IES</h1>
                    <ul class="list-disc text-left">
                        <li>Junta Directiva: <a href="mailto:juntadirectiva@fondoestrella.com"
                                class="text-[#3DC1B7]">juntadirectiva@fondoestrella.com</a> </li>
                        <li>Comité de Control Social: <a href="mailto:controlsocial@fondoestrella.com"
                                class="text-[#3DC1B7]">controlsocial@fondoestrella.com</a></li>
                        <li>Gerencia: <a href="mailto:gerencia@fondoestrella.com"
                                class="text-[#3DC1B7]">gerencia@fondoestrella.com</a></li>
                        <li>Créditos: <a href="mailto:creditos@fondoestrella.com"
                                class="text-[#3DC1B7]">creditos@fondoestrella.com</a></li>
                        <li>Comité de Vivienda: <a href="mailto:comitedevivienda@fondoestrella.com"
                                class="text-[#3DC1B7]">comitedevivienda@fondoestrella.com</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("myForm").addEventListener("submit", function(event) {
            var formIsValid = true;
            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                if (!inputs[i].checkValidity()) {
                    formIsValid = false;
                    break;
                }
            }
            var textareas = document.getElementsByTagName("textarea");
            for (var i = 0; i < textareas.length; i++) {
                if (!textareas[i].checkValidity()) {
                    formIsValid = false;
                    break;
                }
            }
            if (!formIsValid) {
                event.preventDefault();
                alert("Por favor complete todos los campos correctamente.");
            }
        });
    </script>

</div>
