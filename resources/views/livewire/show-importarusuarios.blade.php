<div>
    @if ($rolTrabajador)
        <div x-data="{
            nuevo: @entangle('nuevo'),
            editar: @entangle('editar'),
            ver: @entangle('ver'),
            modalImportacion: @entangle('modalImportacion'),
            eliminar: false,
            closeModal() {
                if (this.nuevo) {
                    this.nuevo = false;
                }
                if (this.editar) {
                    this.editar = false;
                }
                if (this.ver) {
                    this.ver = false;
                }
            }
        }" @keydown.escape="closeModal" tabindex="0" class="h-full w-full md:my-2">
            <x-contenedor>
                {{-- Carga --}}
                @include('components/loading')

                <div>
                    <div class="text-center">
                        <div class="my-4 text-gray-700 font-semibold">
                            Añadir usuarios por volumen
                        </div>
                        <form wire:submit.prevent="import" class="my-3 border py-6 rounded-lg relative">
                            <div class="flex flex-col justify-center items-center  md:absolute top-1 right-3">
                                <p class="text-green-400 font-semibold">Formato modelo</p>
                                <svg class="w-16" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:svgjs="http://svgjs.com/svgjs" x="0" y="0"
                                        viewBox="0 0 267 267" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve" fill-rule="evenodd">
                                        <g>
                                            <path fill="#d8dfe3"
                                                d="M50 154.167c56.944 9.876 113.889 9.544 170.833 0V75c0-.902-.292-1.779-.833-2.5l-37.5-50a4.168 4.168 0 0 0-3.333-1.667H62.5a12.501 12.501 0 0 0-12.5 12.5v95.834c0 6.188-1.451 11.433-1.451 15.614 0 5.78 1.451 9.386 1.451 9.386z"
                                                data-original="#d8dfe3" class=""></path>
                                            <path fill="#1fb35b"
                                                d="M25 143.365v89.968a12.501 12.501 0 0 0 12.5 12.5h191.667a12.503 12.503 0 0 0 12.5-12.5v-66.666a12.501 12.501 0 0 0-12.5-12.5h-187.5c-5.316 0-16.667-10.802-16.667-10.802z"
                                                data-original="#1fb35b"></path>
                                            <path fill="#198043"
                                                d="M37.5 154.167c-3.804 0-6.581-1.543-8.625-3.443-1.923-1.788-3.875-4.939-3.875-9.057 0-2.643 1.317-6.495 3.661-8.839s5.524-3.661 8.839-3.661H50v25H37.5z"
                                                data-original="#198043"></path>
                                            <path fill="#1fb35b"
                                                d="M129.167 137.5V100H75v33.333a4.166 4.166 0 0 0 4.167 4.167zM129.167 54.167h-50A4.166 4.166 0 0 0 75 58.333v33.334h54.167zM191.667 100H137.5v37.5h50a4.167 4.167 0 0 0 4.167-4.167zM179.167 54.167H137.5v37.5h54.167V75c0-2.3-1.867-4.167-4.167-4.167s-4.167-10.2-4.167-12.5a4.168 4.168 0 0 0-4.166-4.166z"
                                                data-original="#1fb35b"></path>
                                            <path fill="#afbdc7"
                                                d="M179.167 20.833V62.5a12.501 12.501 0 0 0 12.5 12.5h29.166c0-.902-.292-1.779-.833-2.5l-37.5-50a4.168 4.168 0 0 0-3.333-1.667z"
                                                data-original="#afbdc7"></path>
                                            <g fill="#d8dfe3">
                                                <path
                                                    d="M122.396 179.167v41.666a4.166 4.166 0 0 0 4.167 4.167h26.041c2.3 0 4.167-1.867 4.167-4.167a4.169 4.169 0 0 0-4.167-4.166h-21.875v-37.5c0-2.3-1.867-4.167-4.166-4.167a4.169 4.169 0 0 0-4.167 4.167zM80.74 223.577l36.458-41.667a4.167 4.167 0 0 0-6.271-5.487L74.468 218.09a4.169 4.169 0 0 0 .392 5.879 4.17 4.17 0 0 0 5.88-.392z"
                                                    fill="#d8dfe3" data-original="#d8dfe3" class=""></path>
                                                <path
                                                    d="M117.198 218.09 80.74 176.423a4.17 4.17 0 0 0-5.88-.392 4.169 4.169 0 0 0-.392 5.879l36.459 41.667a4.167 4.167 0 0 0 6.271-5.487zM158.855 210.443l-.001-.001v2.066A12.49 12.49 0 0 0 171.346 225h9.391a12.49 12.49 0 0 0 12.492-12.492v-1.658c0-5.111-3.112-9.707-7.857-11.606l-15.151-6.06a4.826 4.826 0 0 1-3.034-4.48V187.5c0-1.105.439-2.165 1.221-2.946a4.164 4.164 0 0 1 2.946-1.221h9.375c1.105 0 2.165.439 2.946 1.221a4.164 4.164 0 0 1 1.221 2.946v2.058c0 1.176.52 2.24 1.042 2.78a4.195 4.195 0 0 0 3.124 1.412c2.029 0 4.167-1.566 4.167-4.192V187.5a12.501 12.501 0 0 0-12.5-12.5h-9.375a12.501 12.501 0 0 0-12.5 12.5v1.204c0 5.38 3.276 10.219 8.272 12.217l15.151 6.061a4.165 4.165 0 0 1 2.619 3.868v1.658a4.16 4.16 0 0 1-4.159 4.159h-9.391a4.16 4.16 0 0 1-4.158-4.158l-.001-2.067c0-2.748-2.239-4.194-4.093-4.194-1.758 0-4.24 1.363-4.24 4.169a.1.1 0 0 0 .001.026z"
                                                    fill="#d8dfe3" data-original="#d8dfe3" class=""></path>
                                            </g>
                                        </g>
                                    </svg>
                                    <a class="bg-green-400 rounded-md text-white font-semibold px-3 hover:bg-green-500 cursor-pointer" target="_blank" href="{{ asset($modelo ?? '') }}">
                                        Descargar
                                    </a>
                                </div>

                            <label for="archivo">Selecciona un archivo XLS:</label> <br>
                            <input type="file" id="archivo" name="archivo" accept=".xlsx" wire:model="file">
                            <br>
                            <br>

                            @error('file')
                                <span class="error">{{ $message }}</span>
                            @enderror

                            @if ($file)
                                <img src="/img/xls.png" class="w-24 mx-auto">
                                <p class="text-green-500 my-3">Archivo cargado, si esta de acuerdo de click en importar
                                    datos.</p>
                                <x-primary-button type="submit">Importar
                                    datos</x-primary-button>
                            @endif

                            @if ($importado == 'true')
                                <div class="text-green-600 fonto-semibold my-4">Usuarios importados correctamente!!
                                </div>
                            @endif
                        </form>

                        @if (!empty($muestras))
                            <div class="my-2 bg-gray-200">Vista previa </div>
                            <div class="w-auto  mx-auto border">
                                <x-table>
                                    <x-slot name='head'>
                                        <x-tr class="font-semibold">
                                            <th class="px-2 ">Codigo</th>
                                            <th class="px-2 ">Nombre</th>
                                            <th class="px-2 ">Documento</th>
                                            <th class=" px-2">Email</th>
                                            <th class=" px-2">Cargo</th>
                                            <th class=" px-2">Plan</th>

                                        </x-tr>
                                    </x-slot>
                                    <x-slot name='bodytable'>

                                        @foreach ($muestras[0] as $muestra)
                                            <x-tr>
                                                <x-td class="px-2">{{ $muestra[0] ?? '' }}</x-td>
                                                <x-td class="px-2">{{ $muestra[2] ?? '' }} {{ $muestra[3] ?? '' }}
                                                    {{ $muestra[4] ?? '' }} {{ $muestra[5] ?? '' }}</x-td>
                                                <x-td class="px-2">{{ $muestra[1] ?? '' }}</x-td>
                                                <x-td class="px-2">{{ $muestra[7] ?? '' }}</x-td>
                                                <x-td class="px-2">{{ $muestra[6] ?? '' }}</x-td>
                                                <x-td class="px-2">{{ $muestra[8] ?? '' }}</x-td>
                                            </x-tr>
                                        @endforeach
                                    </x-slot>
                                    <x-slot name='link'>
                                    </x-slot>
                                </x-table>
                            </div>
                        @endif
                    </div>

                </div>


                {{-- Modal Exportar --}}
                <x-modal-crud x-show="modalImportacion">
                    <x-slot name="titulo">Importación de usuarios.</x-slot>

                    <x-slot name="campos">
                        <div class="text-sm "> <span class="font-semibold">{{ $importados }}</span> Usuarios
                            importados.
                        </div>
                        <div class="text-sm "><span class="font-semibold">{{ $noimportados }}</span> Usuarios no
                            importados.</div>
                    </x-slot>

                    <x-slot name="botones">
                        <x-secondary-button x-on:click="modalImportacion=false">
                            Cerrar
                        </x-secondary-button>

                    </x-slot>

                </x-modal-crud>


            </x-contenedor>
        </div>
    @else
        <div class="bg-red-200 max-w-xs p-8 rounded-lg shadow mx-auto text-center">
            <div class=" text-red-600 text-lg text-center font-semibold my-4 ">No tiene Rol de
                Trabajador</div>
                <div class="text-sm text-red-500 my-4">Antes de continuar debe crear un Rol con nombre "Trabajador", ya que los usuarios importados inicialmente quedaran con este rol.</div>
                    <a href="{{ url()->previous() }}">
                        <x-secondary-button class="mx-auto">
                            Atrás
                        </x-secondary-button>
                    </a>
                
                <a href="{{ route('subroles') }}">
                <x-primary-button class="mx-auto ">
                    Crear Rol
                </x-primary-button>
            </a>
        </div>
    @endif
</div>
