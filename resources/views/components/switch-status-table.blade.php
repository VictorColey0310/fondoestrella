<div x-data="{ estado: {{$estado}}  }">
    <button x-on:click="estado = estado ? 0 : 1" wire:click="cambiarEstado('{{$id}}','{{$estado}}')"
        :class="{ 'bg-green-500': estado, 'bg-gray-300': !estado}"
        class="w-9 h-5 rounded-full transition-colors duration-200 ">
    
        <div :class="{ 'translate-x-full': estado }"
            class="w-5 h-5 bg-white rounded-full shadow-gray-400 shadow transform ring-0 transition-transform duration-300 hover:shadow-md hover:shadow-slate-300 ">
        </div>
    </button>
</div>