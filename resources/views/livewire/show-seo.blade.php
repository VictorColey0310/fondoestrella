<div>
    <div>
        <x-contenedor>
            {{-- Carga --}}
            @include('components/loading')
            <x-crud-individual>
                <x-slot name="titulo">
                    SEO
                </x-slot>
                <x-slot name="subtitulo">
                    Descripcion de SEO
                </x-slot>
                <x-slot name="contenido">
                    <div>
                        <x-input-file wire="file_favicon" label="Favicon" name="favicon" id="favicon" type="file"
                            placeholder="Favicon" maxlength="200" value="" />
                        @if ($file_favicon)
                        <img src="{{ $file_favicon->temporaryUrl() }}" alt="Favicon"
                            class="md:w-12 object-contain rounded">
                        @elseif($favicon)
                        <img src="{{asset($favicon)}}" alt="Imagen seo" class="md:w-12 object-contain rounded">
                        @else
                        <div class="w-12 aspect-square bg-gray-300  rounded"></div>
                        @endif
                    </div>
                    <div>
                        <x-input-file wire="file_imagen_seo" label="Imagen de SEO" name="imagen_seo" id="imagen_seo"
                            type="file" placeholder="Imagen de SEO" maxlength="200" value="" />
                        @if ($file_imagen_seo)
                        <img src="{{ $file_imagen_seo->temporaryUrl() }}" alt="Imagen seo"
                            class="md:w-56 object-contain  rounded">
                        @elseif($imagen_seo)
                        <img src="{{asset($imagen_seo)}}" alt="Imagen seo" class="md:w-56 object-contain  rounded">
                        @else
                        <div class="w-56 h-32 aspect-square bg-gray-300  rounded"></div>
                        @endif
                    </div>
                    <x-input-with-label wire="titulo" label="Titulo" name="titulo" id="titulo" type="text"
                        placeholder="Titulo" maxlength="20" value="" />
                    <x-input-with-label wire="descripcion" label="Descripción" name="descripcion" id="descripcion"
                        type="text" placeholder="Descripción" maxlength="60" value="" />
                    <x-input-with-label wire="keyword" label="Keyword" name="keyword" id="keyword" type="text"
                        placeholder="Keyword" maxlength="20" value="" />

                </x-slot>
                <x-slot name="boton">
                    <x-primary-button wire:click="guardar()">
                        Guardar
                    </x-primary-button>
                </x-slot>
            </x-crud-individual>

        </x-contenedor>
    </div>
</div>