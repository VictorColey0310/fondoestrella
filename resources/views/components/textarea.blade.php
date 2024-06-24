<div>

    <div class="mb-2" x-data="{ count: 0 }">
        <label for="{{ $id }}"
            class="block text-gray-700 text-sm font-semibold mb-2" >{{ $label }}</label>
        <textarea value="{{ $value }}" type="{{ $type }}" id="{{ $id }}"
            placeholder="{{ $placeholder }}" name="{{ $name }}" wire:model.lazy="{{ $wire }}"
            maxlength="{{ $maxlength }}" @input="count = $event.target.value.length"
            {{ $attributes->merge(['class' => 'text-sm border border-gray-300 rounded-md md:w-56 appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) }}>
            
        </textarea>    
        <div class="flex justify-between text-sm opacity-80">
            <div>
                @error($wire)
                    <div class="text-red-500 ">{{ 'Requerido*' }}</div>
                @enderror
            </div>
            <div><span x-text="count"></span> / {{ $maxlength }}</div>
        </div>
    </div>
</div>
