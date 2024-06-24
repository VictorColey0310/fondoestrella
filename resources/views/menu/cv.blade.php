<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Hoja de vida</h1>
        </div>
    </x-slot>

    @livewire('show-cv', ['user_id' => $user_id])
</x-app-layout>
