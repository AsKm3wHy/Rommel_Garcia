$(document).ready(function () {
  $(".owl-carousel").owlCarousel({
    loop: true,
    margin: 0,
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
    },
  });
});
