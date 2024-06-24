<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Administración</h1>
        </div>
    </x-slot>
    @if (!empty($ciclo_id) && !empty($estandar_id) && !empty($item_id) && !empty($criterio_id))
        @livewire('show-evidencias', ['ciclo_id' => $ciclo_id, 'estandar_id' => $estandar_id, 'item_id' => $item_id, 'criterio_id' => $criterio_id])
    @elseif(!empty($ciclo_id) && !empty($estandar_id) && !empty($item_id))
        @livewire('show-criterios', ['ciclo_id' => $ciclo_id, 'estandar_id' => $estandar_id, 'item_id' => $item_id])
    @elseif (!empty($ciclo_id) && !empty($estandar_id))
        @livewire('show-items', ['ciclo_id' => $ciclo_id, 'estandar_id' => $estandar_id])
    @elseif(!empty($ciclo_id))
        @livewire('show-estandar', ['ciclo_id' => $ciclo_id])
    @else
        <livewire:show-cycles />
    @endif
</x-app-layout>
