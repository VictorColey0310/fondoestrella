<div class="m-4">
    <div class="w-full justify-between flex flex-col md:flex-row my-2 items-center space-y-2 md:space-y-0 md:space-x-2">
        <div class="w-full md:w-4/12">
            <h1 class="font-semibold text-base text-gray-800 leading-tight">
                {{ $titulo }}
            </h1>
            <p class="my-1 text-sm">
                {{ $subtitulo }}
            </p>
        </div>

        {{-- Input buscar --}}
        <div class="w-full md:w-3/12 text-center">
            <x-input-search name="buscar" type="search" wire="buscar" id="buscar" placeholder="Buscar" class="mx-auto" />
        </div>
        {{-- Select --}}
        <div class="w-full md:w-3/12 ">
            {{ $filtro }}
        </div>

        <div class="flex space-x-2 md:w-2/12 justify-end ">

            {{-- Boton eliminar --}}
            <x-primary-button x-cloak x-show="eliminar" x-on:click="eliminar=false,exportar=false,download=false"
                wire:click="eliminar('1')" class="bg-red-400 hover:bg-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" x-show="eliminar" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </x-primary-button>

            <x-primary-button x-cloak x-show="download" x-on:click="download=false,eliminar=false,exportar=false"
                wire:click="download('1')" class="bg-green-400 hover:bg-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" x-show="download"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </x-primary-button>

            {{-- Boton nuevo modulo --}}
            <x-primary-button x-on:click="nuevo = true">
                {{ $boton }}
            </x-primary-button>
        </div>

    </div>
    {{ $tabla }}
</div>
