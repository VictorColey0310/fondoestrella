
    <div class="mb-2 w-full" >
        <label for="{{ $id }}" class="block text-gray-700 text-sm font-semibold mb-2 ">{{ $label}}</label>
        <select
            value="{{ $value }}"
            id="{{ $id }}"
            name="{{ $name }}"
            wire:model.lazy="{{$wire}}"
            {{ $attributes->merge(['class' => 'text-sm border border-gray-300 rounded-md   w-full appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) }}
        >
        {{$option}}
        </select>
        <div class="flex justify-between text-sm opacity-80 select-none">
                <div>@error($wire) <div class="text-red-500 ">{{ 'Requerido*' }}</div> @enderror </div>  <div class="text-white"><span >Select</span> </div>
        </div>
    </div>
