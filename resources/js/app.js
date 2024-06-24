import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();



   import 'swiper/css/bundle';
   import Swiper from 'swiper';

   // Inicializar Swiper
   document.addEventListener('DOMContentLoaded', function () {
    console.log('DOMContentLoaded event has fired.');
       var mySwiper = new Swiper('.swiper-container', {
           // Configuración de Swiper
           slidesPerView: 2,
           spaceBetween: 5,
           loop: true,
           // ... Otras opciones según tus necesidades
       });
});
