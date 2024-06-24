<div>

    <div class="mb-2" x-data="{ count: 0 }">
        <label for="{{ $id }}"
            class="block text-gray-700 text-sm font-semibold mb-2" >{{ $label }}</label>
        <input value="{{ $value }}" type="{{ $type }}" id="{{ $id }}"
            placeholder="{{ $placeholder }}" name="{{ $name }}" wire:model="{{ $wire }}"
            
            {{ $attributes->merge(['class' => 'text-sm h-10 rounded-md md:w-56 appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) }}>
        <div class="flex justify-between text-sm opacity-80">
            <div>
                @error($wire)
                    <div class="text-red-500 ">{{ 'Requerido*' }}</div>
                @enderror
            </div>
            <div class="text-white">
                file
            </div>
        </div>
    </div>
</div>