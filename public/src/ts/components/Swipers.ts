import Swiper from "swiper/bundle";
import "swiper/css/bundle";

const swiperServices = new Swiper(".swiper-services", {
  spaceBetween: 30,

  breakpoints: {
    375: {
      slidesPerView: 1,
    },
    667: {
      slidesPerView: 2,
    },
    940: {
      slidesPerView: 3,
    },
    1024: {
      slidesPerView: 4,
    },
    1440: {
      slidesPerView: 5,
    },
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
});
const swiperProyects = new Swiper(".swiper-proyects", {
  spaceBetween: 30,

  breakpoints: {
    375: {
      slidesPerView: 1,
    },
    667: {
      slidesPerView: 2,
    },
    940: {
      slidesPerView: 3,
    },
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
});
const swiperTestimonials = new Swiper(".swiper-testimonials", {
  spaceBetween: 30,

  breakpoints: {
    375: {
      slidesPerView: 1,
    },
    667: {
      slidesPerView: 2,
    },
    940: {
      slidesPerView: 2.3,
    },
  },
  navigation: {
    nextEl: ".testimonials__arrow--next",
    prevEl: ".testimonials__arrow--prev",
  },
});
const swiperSuppliers = new Swiper(".swiper-suppliers", {
  spaceBetween: 30,
  autoplay: true,
  breakpoints: {
    375: {
      slidesPerView: 2,
    },
    667: {
      slidesPerView: 3,
    },
    940: {
      slidesPerView: 4,
    },
    1024: {
      slidesPerView: 5,
    },
  },
});
const swiperSlide = new Swiper(".swiper-service", {
  spaceBetween: 30,
  autoplay: true,
  breakpoints: {
    375: {
      slidesPerView: 1,
    },
    667: {
      slidesPerView: 2,
    },
  },
});
