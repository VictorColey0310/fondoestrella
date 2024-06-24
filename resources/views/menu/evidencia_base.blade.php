<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Evidencias</h1>
        </div>
    </x-slot>

    @livewire('show-evidenciabase', ['criterio_id' => $criterio_id])
</x-app-layout>
