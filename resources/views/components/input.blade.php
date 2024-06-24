<div>
    <label for="{{ $id }}" class="block text-gray-700 text-sm font-semibold mb-2 capitalize">{{ $slot }}</label>
    <input 
        type="{{ $type }}" 
        id="{{ $id }}" 
        placeholder="{{ $placeholder }}" 
        name="{{ $name }}" 
        {{ $attributes->merge(['class' => 'text-sm border border-gray-300 rounded-md md:w-56 appearance-none focus:border-neutral-300 focus:ring-0 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']) }}
    >
</div>