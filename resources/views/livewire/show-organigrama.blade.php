<div x-data="{
    nuevo: @entangle('nuevo'),
    editar: @entangle('editar'),
    ver: @entangle('ver'),
    eliminar: false,
    download: false,
    closeModal() {
        if (this.nuevo) {
            this.nuevo = false;
        }
        if (this.editar) {
            this.editar = false;
        }
        if (this.ver) {
            this.ver = false;
        }
    }
}" @keydown.escape="closeModal" tabindex="0" class="h-full w-full md:my-2">
    <x-contenedor>
        {{-- Carga --}}
        @include('components/loading')

        <x-slot name="titulo"> {{ $nombreCrud }} </x-slot>
        <x-slot name="subtitulo"> Gestion de {{ $nombreCrud }} </x-slot>

        @livewire('persona-component', ['persona' => $persona, 'isLast' => true, 'isFirst' => true])
    </x-contenedor>
</div>
