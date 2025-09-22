(function($) {

  "use strict";

  var initPreloader = function() {
    $(document).ready(function($) {
    var Body = $('body');
        Body.addClass('preloader-site');
    });
    $(window).load(function() {
        $('.preloader-wrapper').fadeOut();
        $('body').removeClass('preloader-site');
    });
  }

  // init Chocolat light box
	var initChocolat = function() {
		Chocolat(document.querySelectorAll('.image-link'), {
		  imageSize: 'contain',
		  loop: true,
		})
	}

  var initSwiper = function() {
    
    // swiper slider home 2
    $('.slideshow').each(function(){
      var space = $(this).attr('data-space') ? $(this).attr('data-space') : 0 ;
      var col = $(this).attr('data-col');
      if ( typeof col == "undefined" || !col) {
        col = 1;
      }

      var swiper = new Swiper(".slideshow", {
        slidesPerView: col,
        spaceBetween: space,
        speed: 1000,
        loop: true,
        pagination: {
          el: ".slideshow-swiper-pagination",
          clickable: true,
        },
      });
    });

    var testimonialSwiper = new Swiper(".testimonial-swiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: ".testimonial-button-next",
        prevEl: ".testimonial-button-prev",
      },
    });

    var brand_swiper = new Swiper(".brand-carousel", {
      slidesPerView: 4,
      spaceBetween: 30,
      speed: 500,
      navigation: {
        nextEl: ".brand-carousel-next",
        prevEl: ".brand-carousel-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 2,
        },
        991: {
          slidesPerView: 3,
        },
        1500: {
          slidesPerView: 4,
        },
      }
    });

    var productSwiper = new Swiper(".product-swiper", {
      spaceBetween: 20,
      pagination: {
        el: ".product-swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        660: {
          slidesPerView: 3,
        },
        980: {
          slidesPerView: 4,
        },
        1500: {
          slidesPerView: 5,
        }
      },
    });

    var products_swiper = new Swiper(".products-carousel", {
      slidesPerView: 5,
      spaceBetween: 30,
      speed: 500,
      navigation: {
        nextEl: ".products-carousel-next",
        prevEl: ".products-carousel-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 3,
        },
        991: {
          slidesPerView: 4,
        },
        1500: {
          slidesPerView: 5,
        },
      }
    });

    // product single page
    var thumb_slider = new Swiper(".product-thumbnail-slider", {
      slidesPerView: 5,
      spaceBetween: 20,
      // autoplay: true,
      direction: "vertical",
      breakpoints: {
        0: {
          direction: "horizontal"
        },
        992: {
          direction: "vertical"
        },
      },
    });

    var large_slider = new Swiper(".product-large-slider", {
      slidesPerView: 1,
      // autoplay: true,
      spaceBetween: 0,
      effect: 'fade',
      thumbs: {
        swiper: thumb_slider,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  }

  // Animate Texts
  var initTextFx = function () {
    $('.txt-fx').each(function () {
      var newstr = '';
      var count = 0;
      var delay = 100;
      var stagger = 10;
      var words = this.textContent.split(/\s/);
      var arrWords = new Array();
      
      $.each( words, function( key, value ) {
        newstr = '<span class="word">';

        for ( var i = 0, l = value.length; i < l; i++ ) {
          newstr += "<span class='letter' style='transition-delay:"+ ( delay + stagger * count ) +"ms;'>"+ value[ i ] +"</span>";
          count++;
        }
        newstr += '</span>';

        arrWords.push(newstr);
        count++;
      });

      this.innerHTML = arrWords.join("<span class='letter' style='transition-delay:"+ delay +"ms;'>&nbsp;</span>");
    });
  }

  // input spinner
  var initProductQty = function(){

    $('.product-qty').each(function(){
      var $el_product = $(this);
      var quantity = 0;
      $el_product.find('.quantity-right-plus').click(function(e){
        e.preventDefault();
        var quantity = parseInt($el_product.find('.quantity').val());
        $el_product.find('.quantity').val(quantity + 1);
      });

      $el_product.find('.quantity-left-minus').click(function(e){
          e.preventDefault();
          var quantity = parseInt($el_product.find('.quantity').val());
          if(quantity>0){
            $el_product.find('.quantity').val(quantity - 1);
          }
      });

    });

  }

  // init jarallax parallax
  var initJarallax = function() {
    jarallax(document.querySelectorAll(".jarallax"));

    jarallax(document.querySelectorAll(".jarallax-keep-img"), {
      keepImg: true,
    });
  }

  // document ready
  $(document).ready(function() {
    
    initPreloader();
    initTextFx();
    initSwiper();
    initProductQty();
    initJarallax();
    initChocolat();

  }); // End of a document

})(jQuery);