// On Document Load
jQuery(window).load(function () {
   //site loader
   jQuery('#wraploader').hide();
});

// On Document Ready
jQuery(document).ready(function ($) {

   // Main Slider
   var config = {
      fx: "fade",
      timeout: 7000,
      prev: "#charitize-prev",
      next: "#charitize-next",
      pager: "#charitize-pager",
      slides: "> div"
   };
   config['pause-on-hover'] = "true";

   $('#cycle-slideshow').cycle(config);

   // Carousel Slider

   config.carouselVisible = '3';
   config.prev = '#charitize-prev2'
   $('#cycle-carousel').cycle(config);

   /*wow jQuery*/
   wow = new WOW({
      boxClass: 'evision-animate'
   }
   )

   wow.init();

   // slick jQuery 
   jQuery('.carousel-group').slick({
      autoplay: true,
      autoplaySpeed: 3000,
      // dots: true,
      slidesToShow: 2,
      slidesToScroll: 1,
      lazyLoad: 'ondemand',
      responsive: [
         {
            breakpoint: 1024,
            settings: {
               slidesToShow: 3,
               slidesToScroll: 3,
               infinite: true,
               dots: true
            }
         },
         {
            breakpoint: 768,
            settings: {
               slidesToShow: 2,
               slidesToScroll: 2
            }
         },
         {
            breakpoint: 481,
            settings: {
               slidesToShow: 1,
               slidesToScroll: 1
            }
         }
         // You can unslick at a given breakpoint now by adding:
         // settings: "unslick"
         // instead of a settings object
      ]
   });

   // back to top animation

   $('#gotop').click(function () {
      $('html,body').animate({ scrollTop: '0px' }, 1000);
   });

   // waypoints
   if ($('html,body').hasClass('home') && $('.wrapper-callback').length > 0) {
      var waypoint = new Waypoint({
         element: $('.wrapper-callback'),
         offset: '0',
         handler: function (direction) {
            $(window).scroll(function () {
               var scrolledY = $(window).scrollTop();
               $('.wrapper-callback').css('background-position', 'left ' + (-(scrolledY)) / 8 + 'px');
            });
         }
      });
   }

   // header fix
   var initialPosition = $(window).scrollTop();
   $(window).scroll(function () {
      var getScrollTop = $('html,body').scrollTop(),
         mastheadHeight = $('#masthead').outerHeight(),
         headerFixed = $('#fixedhead');

      // console.log(mastheadHeight, 'hhhhe');


      if (getScrollTop > initialPosition) {
         $('#fixedhead').css({ 'top': 0 });
      } else {
         $('#fixedhead').css({ 'top': - mastheadHeight });
      }

      if (getScrollTop == 0) {
         $('#fixedhead').css({ 'top': - mastheadHeight });
      }
      initialPosition = getScrollTop;

      // back to top button visible on scroll
      var scrollTopPosition = $('html,body').scrollTop();
      if (scrollTopPosition > 240) {
         $('#gotop').css({ 'bottom': 25 });
      } else {
         $('#gotop').css({ 'bottom': -100 });
      }

      $('header#fixedhead').css('display', 'block');
   });

   $('header#fixedhead').css('display', 'none');

   // margin top social
   var mastheadHeight = $('#masthead').outerHeight(),
      mobileScreen = $(window).width();
   mobileScreenMargin(mobileScreen);

   function mobileScreenMargin(mobileScreen) {
      if (mobileScreen >= 768) {
         $('.evision-social-section').css('margin-top', mastheadHeight);
      } else {
         $('.evision-social-section').css('margin-top', '0px');
      }
   }


   // resize
   $(window).resize(function () {
      var mastheadHeight = $('#masthead').outerHeight(),
         mobileScreen = $(window).width();
      $('#fixedhead').css({ 'width': mobileScreen });
      mobileScreenMargin(mobileScreen);
   });

   const displayError = (message) => {
      $('#f-error').text(message)
      $('html,body').animate({ scrollTop: $('#f-error').offset().top - 300 });
   }

   $('#eac_volunteer_form').on('submit', function (e) {
      e.preventDefault()
      let fname = $('#fname').val()
      let lname = $('#lname').val()
      let gender = $('#genda').val()
      let email = $('#email').val()
      let phone = $('#phone').val()
      if (fname === '' || lname === '') {
         return displayError('First name and Last name are required')
      }
      if (gender === '') {
         return displayError('Gender is required')
      }
      if (email === '') {
         return displayError('Email is required')
      }
      if (phone === '') {
         return displayError('Phone is required')
      }
      if (!/[a-zA-Z0-9\_\.\-]\@\w+\.[a-z]{2,}\.?[a-z]?$/.test(email)) {
         return displayError('Invalid Email')
      }
      if (isNaN(phone) || phone.length > 14) {
         return displayError('Invalid phone number')
      }
      $('.spin').removeClass('d-none');
      $('html,body').animate({ scrollTop: $('.spin').offset().top - 450 });

      const form1 = document.forms['eac_volunteer_form'];
      const addr = 'https://script.google.com/macros/s/AKfycbz1ZHViJlOKt4C-kxDoTFCI4sItkLiDX-g_rf0hANSN4-bmXjbs/exec'
      fetch(addr, { method: 'POST', body: new FormData(form1) })
         .then(response => {
            $('#eac_volunteer_form').html('<h2 class="green-color">Thank you we will contact you soon!</h2>')
            $('html,body').animate({ scrollTop: $('#eac_volunteer_form').offset().top - 50 });
         })
         .catch(error => {
            return displayError('Sorry your request could not be submitted, try again');
         })
   })
});