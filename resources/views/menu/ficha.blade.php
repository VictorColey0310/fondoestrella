<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Mi Ficha</h1>
        </div>
    </x-slot>

    @livewire('show-ficha', ['user_id' => $user_id])
</x-app-layout>