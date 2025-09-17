$(document).ready(function () {
  // Initialize Owl Carousel
  $(".owl-carousel").owlCarousel({
    loop: true,
    margin: 5,
    dots: true,
    autoplay: true,
    autoplayTimeout: 3000,
    autoHeight: true,
    responsive: {
      0x0: { items: 0x1 },
      0x258: { items: 0x2 },
      0x3e8: { items: 0x3 },
      0x4b0: { items: 0x4 },
      0x514: { items: 0x5, nav: ![] },
      0x578: { items: 0x6, nav: ![] },
      // 0x5dc: { items: 0x7, nav: ![] },
      // 0x640: { items: 0x8, nav: ![] },
      // 0x6a4: { items: 0x9, nav: ![] },
      // 0x708: { items: 0xa, nav: ![] },
      // 0x76c: { items: 0xb, nav: ![] },
      // 0x7d0: { items: 0xc, nav: ![] },
      // 0x834: { items: 0xd, nav: ![] },
    },
  });
});
