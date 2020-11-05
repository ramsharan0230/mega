
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




var main = function() {
    $('#filter_trigger').click(function() {
        $("body").addClass("overlay");

        $('.filter_wrapper').animate({ right: '0px' }, 300);
        $('body').animate({ right: '250px' }, 300);
    });
    $('.close-btn').click(function() {
        $("body").removeClass("overlay");

        $('.filter_wrapper').animate({ right: '-350px' }, 300);
        $('body').animate({ right: '0px' }, 300);

    });
};

$(document).ready(main);


  
  
$('.gold-exhibitor-list').slick({
      slidesToShow: 5,
     slidesToScroll: 1,
     autoplay:true,
     infinite: true,
     speed: 500,
     autoplaySpeed: 1500,
    responsive: [{
      
                breakpoint: 992,
                settings: {
                    
                    slidesToShow: 5,
                },
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }

        ]
});




  
$('.stall_slider').slick({
      slidesToShow: 4,
     slidesToScroll: 1,
     rows: 2,
     autoplay:true,
     infinite: true,
     speed: 500,
     autoplaySpeed: 2000,
    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
    nextArrow: '<button class="slide-arrow next-arrow"></button>',
     responsive: [{
      
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }

        ]

});

$('.platinum-exhibitor').slick({
      slidesToShow: 4,
     slidesToScroll: 1,
     rows: 2,
     autoplay:true,
     infinite: true,
     speed: 500,
     autoplaySpeed: 2000,
    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
    nextArrow: '<button class="slide-arrow next-arrow"></button>',
     responsive: [{
      
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }

        ]

});

$('.in-association-with').slick({
      slidesToShow: 3,
     slidesToScroll: 1,
     autoplay:true,
     infinite: true,
     speed: 500,
     autoplaySpeed: 2000,
    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
    nextArrow: '<button class="slide-arrow next-arrow"></button>',
     responsive: [{
      
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }

        ]


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