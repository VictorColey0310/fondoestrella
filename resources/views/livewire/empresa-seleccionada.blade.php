<div class="" x-data="{ showEmpresas: false }">

    <div class=" shadow-inner rounded-full py-2 px-2 text-[{{config('app.colorLetra')}}] hover:text-[{{config('app.colorLetraHover')}}]  bg-gray-200  w-full h-full shadow-xs transition-shadow duration-300 hover:shadow-sm focus:shadow-lg focus:outline-none bg-opacity-70 
   ">
        <button class="relative flex items-center justify-between w-full font-bold "  @click="showEmpresas = !showEmpresas">
          <span class="pl-2 block truncate flex-grow">{{ $empresaSeleccionada ?? 'Seleccionar' }}</span>
      
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"  class="text-white font-semibold hover:bg-opactity-70 shadow-inner ml-2 w-5 h-5 px-1 rounded-full @if(!empty(config('app.empresa')->color )) @if(config('app.empresa')->exists) bg-[{{config('app.empresa')->color }}] @endif @endif w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
          
        </button>
      </div>      
      
    <ul class=" w-full mt-1 absolute bg-white shadow-xl rounded-lg" x-transition:enter="transition ease-out duration-500" 
        x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90" x-cloak x-show="showEmpresas" >
        @if (config('app.consultaEmpresas'))
            @foreach (config('app.consultaEmpresas') as $empresa)
                <li class="  hover:bg-gray-200 hover:bg-opacity-70  cursor-pointer text-[{{config('app.colorLetra')}}] hover:text-[{{config('app.colorLetraHover')}}] rounded-md px-4 py-2 text-sm font-medium w-full "
                    wire:click="seleccionarEmpresa('{{ $empresa->id }}')" >
                    {{ $empresa->nombre }}
                </li>
            @endforeach
        @endif
    </ul>
</div>
