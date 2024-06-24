<div>
    <div>
        <x-contenedor>
            {{-- Carga --}}
            @include('components/loading')
            <x-crud-individual>
                <x-slot name="titulo">
                    Información
                </x-slot>
                <x-slot name="subtitulo">
                    Descripción de información
                </x-slot>
                <x-slot name="contenido">

                    <div>
                        <x-input-file wire="file_logo" label="logo" name="logo" id="logo" type="file" placeholder="logo"
                            maxlength="200" value="" />
                        @if ($file_logo)
                            <img src="{{ $file_logo->temporaryUrl() }}" alt="Logo"
                                class="md:w-24 object-contain rounded">
                        @elseif($logo)
                            <img src="{{ asset($logo) }}" alt="Logo" class="md:w-24 object-contain rounded">
                        @else
                            <div class="w-24 aspect-square bg-gray-300  rounded"></div>
                        @endif
                    </div>
                    <x-input-with-label wire="nombre" label="Nombre App" name="nombre" id="nombre" type="text"
                        placeholder="Nombre App" maxlength="20" value="" />
                    <x-input-with-label wire="whatsapp" label="Whatsapp" name="Whatsapp" id="whatsapp" type="text"
                        placeholder="Whatsapp" maxlength="20" value="" />
                    <x-input-with-label wire="terminos_condiciones" label="Términos y condiciones"
                        name="terminos_condiciones" id="terminos_condiciones" type="text"
                        placeholder="Terminos y condiciones" maxlength="300" value="" />
                    <x-input-with-label wire="politicas_privacidad" label="Políticas de privacidad"
                        name="politicas_privacidad" id="politicas_privacidad" type="text"
                        placeholder="Políticas de privacidad" maxlength="300" value="" />
                    <div class="flex justify-start items-center gap-8">
                        <x-input-file wire="upload_modelo" label="Modelo" name="modelo" id="modelo" type="file"
                            placeholder="Modelo" maxlength="200" value="" />
                        <x-input-file wire="upload_instructivo" label="Instructivo" name="instructivo" id="instructivo" type="file"
                            placeholder="Instructivo" maxlength="200" value="" />
                    </div>


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
