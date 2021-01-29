/*!
 * Start Bootstrap - Creative v5.1.8 (https://startbootstrap.com/template-overviews/creative)
 * Copyright (c) 2013-2019 Blackrock Digital LLC
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-creative/blob/master/LICENSE)
 */

(function($) {
  "use strict"; // Start of use strict

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 72)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 75
  });

  // Collapse Navbar
  var navbarCollapse = function() {
    if ($("#mainNav").offset().top > 100) {
      $("#mainNav").addClass("navbar-scrolled");
    } else {
      $("#mainNav").removeClass("navbar-scrolled");
    }
  };
  // Collapse now if page is not at top
  navbarCollapse();
  // Collapse the navbar when page is scrolled
  $(window).scroll(navbarCollapse);

  // Magnific popup calls
  $('.video_grid').magnificPopup({
    delegate: 'a.video_grid-box',
    type: 'iframe',
    tLoading: 'Loading video #%curr%...',
    mainClass: 'mfp-img-mobile',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: false
    },
    image: {
      tError: '<a href="%url%">The video #%curr%</a> could not be loaded.'
    }
  });

})(jQuery); // End of use strict

/* ---- END Start Bootstrap - Creative v5.1.8 ---- */

// Load video if #header_video is visible
$(
  function() {
    var bgv = $('#header_video');

    if (bgv.is(':visible')) {
      $('source', bgv).each(
        function() {
          var el = $(this);
          el.attr('src', el.data('src'));
        }
      );
      bgv[0].load();
    }
  }
)

$('a[href="' + this.location.pathname + '"]').addClass('active');
$('a[href="' + this.location.pathname + '"]').parent().parent().children('a').addClass('active');