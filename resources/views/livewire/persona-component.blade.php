
<div class="flex flex-col items-center relative select-none" x-data="{ open: {} }">

    @if ($isLast && $isFirst)
    @elseif ($isLast)
        <div class="bg-black w-1/2 absolute left-0 h-1"></div>
        <div class="bg-black w-1 h-5"></div>
    @elseif($isFirst)
        <div class="bg-black w-1/2 absolute right-0 h-1"></div>
        <div class="bg-black w-1 h-5"></div>
    @else
        <div class="bg-black w-full h-1 absolute"></div>
        <div class="bg-black w-1 h-5"></div>
    @endif

    {{-- CARD --}}
    <div class="mx-0 w-full flex justify-center px-2 relative">
        <div @click="open['root'] = !open['root']" class="cursor-pointer transition duration-300 ease-in-out transform @if (isset($persona['relaciones']) && is_array($persona['relaciones'])) hover:scale-105 @endif shadow-md bg-white w-40 rounded-lg p-2">
            <img src="https://dxcgedrrxtox6.cloudfront.net/images/perfil_hombre.svg" alt="usuario" class="mx-auto py-2">
            <h3 class="text-center">{{ $persona['nombre'] }}</h3>

            @if (isset($persona['relaciones']) && is_array($persona['relaciones']))
                <span x-show="open['root']" class="cursor-pointer absolute right-2 bottom-0">-</span>
                <span x-show="!open['root']" class="cursor-pointer absolute right-2 bottom-0">+</span>
            @endif
        </div>
    </div>

    <div x-show="open['root']" x-transition:enter="transition-all ease-in-out duration-1000"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        class="flex flex-col justify-center items-center">

        @if (isset($persona['relaciones']) && is_array($persona['relaciones']))
            <div class="bg-black w-1 h-5"></div>
        @endif

        <div class="mx-0 px-2 flex">
            @if (isset($persona['relaciones']) && is_array($persona['relaciones']))
                @for ($i = 0; $i < count($persona['relaciones']); $i++)
                    <div class="">

                        @livewire('persona-component', [
                            'persona' => $persona['relaciones'][$i],
                            'isLast' => $i == count($persona['relaciones']) - 1,
                            'isFirst' => $i == 0,
                        ])

                    </div>
                @endfor
            @endif
        </div>
    </div>

</div>
