import 'flowbite';
import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import ApexCharts from 'apexcharts';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';

window.AOS = AOS

window.Alpine = Alpine
Alpine.plugin(collapse)
Alpine.start()
window.ApexCharts = ApexCharts

Swiper.use([Navigation, Pagination, Autoplay]);

new Swiper(".category-slider", {
    slidesPerView: "auto",
    spaceBetween: 24,
    modules: [Navigation],
    navigation: {
        nextEl: ".category-slider_next",
        prevEl: ".category-slider_prev",
    },
});
new Swiper(".hero-banner", {
    slidesPerView: 1,
    spaceBetween: 24,
    modules: [Navigation, Pagination],
    navigation: {
        nextEl: ".banner-slider-next",
        prevEl: ".banner-slider-prev",
    },
    pagination : {
        el: ".banner-slider-pagination",
        clickable: true,
    }
});
new Swiper(".testimonial-slider", {
    slidesPerView: 1,
    spaceBetween: 24,
    modules: [Navigation, Pagination],
    navigation: {
        nextEl: ".banner-slider-next",
        prevEl: ".banner-slider-prev",
    },
    pagination: {
        el: '.banner-slider-pagination',
        clickable: true,
    },
    breakpoints: {
    // when window width is >= 320px
    524: {
      slidesPerView: 2,
      spaceBetween: 20
    },
    // when window width is >= 480px
    991: {
      slidesPerView: 3,
      spaceBetween: 30
    },
  }
});
new Swiper(".brand-slider", {
    slidesPerView: "auto",
    loop: true,
    autoplay: {
        delay: 500,
    },
    spaceBetween: 48,
});

var swiper = new Swiper(".galleryList", {
    loop: true,
    spaceBetween: 8,
    slidesPerView: 'auto',
    freeMode: true,
    watchSlidesProgress: true,
});

var swiper2 = new Swiper(".galleryView", {
    spaceBetween: 0,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: {
        swiper: swiper,
    },
});
var swiper2 = new Swiper(".galleryView2", {
    spaceBetween: 0,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

new Swiper(".choose-category-slider", {
    slidesPerView: "auto",
    spaceBetween: 16,
    modules: [Navigation],
    navigation: {
        nextEl: ".choose-category-slider_next",
        prevEl: ".choose-category-slider_prev",
    },
});

new Swiper(".hero-category-slider", {
    slidesPerView: "auto",
    spaceBetween: 24,
    modules: [Navigation],
    navigation: {
        nextEl: ".hero-category-slider_next",
        prevEl: ".hero-category-slider_prev",
    },
});

window.onload = function() {
    setTimeout(function() {
        if(document.querySelector('.preloader')){
            document.querySelector('.preloader').style.display = 'none';
        }

    }, 1000)
};

