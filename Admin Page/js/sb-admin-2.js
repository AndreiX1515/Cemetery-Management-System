(function($) {
  "use strict"; // Start of use strict

  // Sidebar toggle function
  t("#sidebarToggle, #sidebarToggleTop").on("click", function(o) { 
  t("body").toggleClass("sidebar-toggled");
  t(".sidebar").toggleClass("toggled");

  // Collapse the sidebar if toggled
  if (t(".sidebar").hasClass("toggled")) {
    // Change icon to "X"
    t("#menuIcon").removeClass("fa-bars").addClass("fa-times");
    
    // Collapse all open dropdowns
    t(".sidebar .collapse").collapse("hide");
  } else {
    // Change icon back to hamburger
    t("#menuIcon").removeClass("fa-times").addClass("fa-bars");
    
    // Optionally, you can expand a specific dropdown if needed
    // t(".sidebar .collapse").collapse("show"); // Uncomment if you want to show a specific dropdown
  }
});


  // Close any open menu accordions when window is resized below 768px
  $(window).resize(function() {
    if ($(window).width() < 768) {
      $('.sidebar .collapse').collapse('hide');
    };
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
    if ($(window).width() > 768) {
      var e0 = e.originalEvent,
        delta = e0.wheelDelta || -e0.detail;
      this.scrollTop += (delta < 0 ? 1 : -1) * 30;
      e.preventDefault();
    }
  });

  // Scroll to top button appear
  $(document).on('scroll', function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });

})(jQuery); // End of use strict
