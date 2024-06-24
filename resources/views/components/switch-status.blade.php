<div>
    <div class="mb-2 md:w-56">
        <label for="estado" class="block text-gray-700 text-sm font-semibold mb-2">Estado</label>
        <div x-data="{estado:@entangle('estado')}" class="text-center ">
            <button x-on:click="estado = estado ? 0 : 1 " id="estado"
                :class="{ 'bg-green-500': estado, 'bg-gray-300': !estado }"
                class="w-9 h-5 rounded-full transition-colors duration-200 ">
                <span class="sr-only" x-text="estado ? 'Activo' : 'Inactivo'"></span>
                <div :class="{ 'translate-x-full': estado }"
                    class="w-5 h-5 bg-white rounded-full shadow-gray-400 shadow transform ring-0 transition-transform duration-300 hover:shadow-md hover:shadow-slate-300 ">
                </div>
            </button>
            @error('estado') <div class="text-red-500 text-sm">{{ 'Requerido*' }}</div> @enderror
        </div>
    </div>
</div>