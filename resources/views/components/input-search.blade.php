<div class="w-full">
    <input
        type="{{ $type }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        name="{{ $name }}"
        wire:model.debounce.500ms="{{$wire}}"
        {{ $attributes->merge(['class' => 'mx-auto text-sm border border-gray-300 rounded-md w-full  appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) }}
    >
</div>
