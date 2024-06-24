<div>
    <x-contenedor>
        {{-- Carga --}}
        @include('components/loading')
        <x-crud-individual>
            <x-slot name="titulo">
                Apariencia
            </x-slot>
            <x-slot name="subtitulo">
                Descripcion de apariencia
            </x-slot>
            <x-slot name="contenido">
                
                <x-input-file wire="color_boton" label="Color del botón" name="color_boton" id="color_boton"
                    type="color" placeholder="Color del boton" maxlength="0" value="" />

                <x-input-file wire="color_menu" label="Color de menu" name="color_menu" id="color_menu"
                    type="color" placeholder="Color de menu" maxlength="0" value="" />

                    <x-input-file wire="color_letra" label="Color de letra" name="color_letra" id="color_letra"
                    type="color" placeholder="Color de letra" maxlength="0" value="" />
                    <x-input-file wire="color_letra_hover" label="Color de letra hover" name="color_letra_hover" id="color_letra_hover"
                    type="color" placeholder="Color de letra hover" maxlength="0" value="" />
            </x-slot>
            <x-slot name="boton">
                <x-primary-button wire:click="guardar()">
                    Guardar
                </x-primary-button>
            </x-slot>
        </x-crud-individual>
    </x-contenedor>
</div>
