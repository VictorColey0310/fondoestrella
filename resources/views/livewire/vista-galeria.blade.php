<div>

    <div class="py-20 bg-teal-500 items-center">
        <div class="container mx-auto text-white">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-2 max-w-2xl mx-auto" data-aos="fade-down" data-aos-easing="linear"
                    data-aos-duration="500">GALERIA</h1>
            </div>
        </div>
    </div>
    <div x-data="{ showImage: false, imageUrl: '', largeImageUrl: '', currentIndex: 0, galerias: {{ $galerias->toJson() }} }" class="my-8">
        <div class="grid grid-cols-3 md:grid-cols-5 gap-4 max-w-7xl mx-auto relative">
            @foreach ($galerias as $index => $galeria)
                <a href="#" x-on:click.prevent="showImage = true; largeImageUrl = '{{ asset($galeria->imagen) }}'; currentIndex = {{ $index }};">
                    <img src="{{ asset($galeria->imagen) }}" alt="Imagen {{ $index + 1 }}"
                        class="w-full h-full object-cover cursor-pointer pt-4 rounded-lg shadow-lg hover:shadow-2xl hover:scale-105 transition-transform duration-300">
                </a>
            @endforeach
        </div>
    
        <!-- Vista previa de la imagen -->
        <div x-show="showImage" class="fixed top-0 left-0 flex justify-center items-center w-full h-full bg-black bg-opacity-75 z-50"
            x-on:click="showImage = false">
            <div class="relative">
                <button x-on:click.stop="currentIndex = (currentIndex === 0) ? galerias.length - 1 : currentIndex - 1" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white rounded-full p-2 focus:outline-none">
                    &lt;
                </button>
                <img x-bind:src="largeImageUrl" alt="Imagen vista previa" class="max-w-full max-h-full">
                <button x-on:click.stop="currentIndex = (currentIndex + 1) % galerias.length" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white rounded-full p-2 focus:outline-none">
                    &gt;
                </button>
            </div>
        </div>
    </div>
    
    
    

</div>
