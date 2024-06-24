<input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" value="{{$value}}" wire:model.lazy="{{$wire}}" {{ $attributes->merge(['class'
=> ' border-gray-100 shadow shadow-gray-400 rounded-sm form-checkbox h-4 w-4 text-indigo-600 transition duration-150
ease-in-out']) }}
>
<label for="{{ $id }}" class="text-gray-700 text-sm capitalize">{{ $label}}</label>