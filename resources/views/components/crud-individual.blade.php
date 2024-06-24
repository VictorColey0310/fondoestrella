<div>
    <div class=" m-4">
        <div class="w-full justify-start flex  my-2 items-center  ">
            <div class="mb-8">
                <h1 class="font-semibold text-base text-gray-800 leading-tight ">
                    {{$titulo}}
                </h1>
                <p class="my-1 text-sm">
                    {{$subtitulo}}
                </p>
            </div>
        </div>
        <div class="md:flex md:flex-wrap md:gap-12 md:justify-items-start">
            {{$contenido}} 
        </div>
        

        <div class="flex justify-end">
                {{$boton}}
        </div>
    </div>
</div>