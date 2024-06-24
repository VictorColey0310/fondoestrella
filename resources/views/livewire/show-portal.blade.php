<div x-data="{
    nuevo: @entangle('nuevo'),
    editar: @entangle('editar'),
    ver: @entangle('ver'),
    download: false,
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

    <div class="py-2 mx-auto sm:px-6 lg:px-8">
        <div class="p-2">

            @include('components/loading')

            <div class="relative w-full grid grid-cols-1 justify-center">
                <div class="shadow-xl w-80 rounded-xl bg-white mx-auto md:mx-0">
                    <div class="rounded-t-xl w-full h-40 bg-no-repeat bg-cover bg-[url('https://dxcgedrrxtox6.cloudfront.net/packs/media/images/portal/Banner-Portal-6081c07bf660d8ec87f61dfdd9776346.svg')]"></div>
                    <div class="p-4">
                        <div>
                            <h2 class="text-[#091351] text-lg font-semibold">{{ Auth::user()->name }}</h2>
                            <p class="">{{ Auth::user()->rol->descripcion }}</p>
                        </div>
                        <ul class="m-0 flex flex-col gap-2 mt-4">
                            <a class="text-[#091351] border border-[#bac6ec] p-2 rounded-md" href="">
                                <li class="flex gap-2 items-center justify-start">
                                    <img alt="Solicitar Vacaciones" width="35" height="35" src="https://dxcgedrrxtox6.cloudfront.net/images/portal/Vacaciones.svg">
                                    <span class="">Solicitar Vacaciones</span>
                                </li>
                            </a>
                            <a class="text-[#091351] border border-[#bac6ec] p-2 rounded-md" href="">
                                <li class="flex gap-2 items-center justify-start">
                                    <img alt="Ver Liquidaciones" width="35" height="35" src="https://dxcgedrrxtox6.cloudfront.net/images/portal/liquidaciones.svg">
                                    <span class="">Ver Comprobantes</span>
                                </li>
                            </a>
                            <a class="text-[#091351] border border-[#bac6ec] p-2 rounded-md" href="">
                                <li class="flex gap-2 items-center justify-start">
                                    <img alt="Solicitar Permisos" width="35" height="35" src="https://dxcgedrrxtox6.cloudfront.net/images/portal/Permisos.svg">
                                    <span class="">Solicitar Permiso</span>
                                </li>
                            </a>
                            <a class="text-[#091351] border border-[#bac6ec] p-2 rounded-md" href="">
                                <li class="flex gap-2 items-center justify-start">
                                    <img alt="Ver Documentos" width="35" height="35" src="https://dxcgedrrxtox6.cloudfront.net/images/portal/Documentos.svg">
                                    <span class="">Ver Documentos</span>
                                </li>
                            </a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
