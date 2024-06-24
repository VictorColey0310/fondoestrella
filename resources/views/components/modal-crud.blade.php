<div x-cloak x-transition:enter="transition duration-350" x-transition:enter-start="opacity-0 scale-100"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition duration-350"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-100" {{ $attributes->merge(['class' => 'fixed backdrop-blur-sm bg-black/20 left-0 bottom-0 top-0 right-0 h-full z-20']) }}>
    <div class="grid h-full place-items-center overflow-auto ">
        <div class="bg-white rounded-lg shadow-md max-w-lg w-full md:w-1/3">
            <div class="border-b border-gray-300 my-2 w-full">
                <h1 class="py-4 px-4 text-xl">{{$titulo}}</h1>
            </div>
            <div class="px-4 my-2 w-full">
                {{$campos}}
            </div>
            <div class="flex justify-end space-x-2 m-4">
                {{$botones}}
            </div>
        </div>
    </div>
</div>
