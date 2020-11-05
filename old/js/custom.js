
// hamburger menu //

$(function() { //run when the DOM is ready
    $(".top-menu-bar").click(function() { //use a class, since your ID gets mangled
        $(this).toggleClass("active"); //add the class to the clicked element
        $('.navigation').toggleClass("open");
    });
});



$(document).ready(function() {
    $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      if (scroll >= 140) {
        // $(".navbar").addClass("sticky");
        $("header").addClass("sticky");
      } else {
        // $(".navbar").removeClass("sticky");
        $("header").removeClass("sticky");
      }
      if (scroll > 50) {
        $(".scroll-to-top").fadeIn();
      } else {
        $(".scroll-to-top").fadeOut();
      }
    });
  });
  


  $(document).ready(function() {
    $('.block-slider').slick({

        // prevArrow: '<button class="slide-arrow prev-arrow"></button>',
        // nextArrow: '<button class="slide-arrow next-arrow"></button>',
        autoplay: true,
        dots: true,
        infinite: true,
        cssEase: 'linear',
        vertical: true,
        // fade: true,
        autoplaySpeed: 7000,
        speed: 800,
        responsive: [
          {
            breakpoint: 600,
            settings: {
                vertical: false
            }
          },
          ]
    });
});


$(document).ready(function() {
  $('.block-two').slick({

      // prevArrow: '<button class="slide-arrow prev-arrow"></button>',
      // nextArrow: '<button class="slide-arrow next-arrow"></button>',
      autoplay: true,
      dots: true,
      infinite: true,
      cssEase: 'linear',
      vertical: true,
      // fade: true,
      autoplaySpeed: 8000,
      speed: 800,
      responsive: [
      {
        breakpoint: 600,
        settings: {
            vertical: false
        }
      },
      ]
  });
});


var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("header").style.top = "0";
  } else {
    document.getElementById("header").style.top = "-100px";
  }
  prevScrollpos = currentScrollPos;
}