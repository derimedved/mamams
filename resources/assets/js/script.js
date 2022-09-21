const specialistsPopUp = document.getElementsByClassName("specialists-pop-up"),
    blackout = document.querySelector(".blackout"),
    html = document.querySelector("html"),
    popUpClose = document.querySelectorAll(".pop-up__close"),
    btnMobileOpen = document.querySelectorAll(".specialists__mobile-open-btn"),
    blockMobileOpen = document.querySelectorAll(".specialists__item"),
    popUp = document.querySelectorAll(".pop-up"),
    popUpRemind = document.querySelectorAll(".pop-up-remind"),
    openRemind = document.querySelectorAll(".open-remind"),
    accordionDesktop = document.querySelectorAll(".accordion_desktop"),
    accordionDefault = document.querySelectorAll(".accordion_default"),
    accordion = document.querySelectorAll(".accordion"),
    accordionItemSecond = document.querySelectorAll(".accordion__item-second"),
    accordionOPenBtn = document.querySelectorAll(".accordion__open-btn");



jQuery(document).ready(function($){
  $(document).on('click', '.accordion_desktop', function(event){
    event.preventDefault();

    console.log(event)

    if (window.screen.width >= 768) {
      accordionOpenPopUP();
    } else {
      event.stopPropagation();
      event.preventDefault();

      $(this).toggleClass('accordion_open');
      $(this).find('.accordion__item-second').toggleClass('accordion__item-second_open')

    }
  })

/*  $(window).on('load', function (e){
    if($('*').is('.select-abonement')){
      $('.select-abonement label:first-child').addClass('is-active');
      $('.select-abonement label:first-child input').prop('checked',true);
    }
  });*/

  $(document).on('click', '.select-abonement label', function (e){
    let item = $(this).find('input');


    if(!item.hasClass('is-active')){
      $('.select-abonement label').removeClass('is-active');
      $(this).addClass('is-active').find('input').prop('checked',true);

    }


  })
})


// accordion.forEach((element, i) => {
//   if (element.classList[1] === "accordion_desktop") {
//     element.addEventListener("click", (e) => {
//       if (window.screen.width >= 768) {
//         accordionOpenPopUP();
//       } else {
//         openAccordion(element, i);
//         e.stopPropagation();
//       }
//     });
//   } else {
//     element.addEventListener("click", () => {
//       openAccordion(element, i);
//     });
//   }
// });

function openAccordion(element, i) {
  accordionItemSecond[i].classList.toggle("accordion__item-second_open");
  accordionOPenBtn[i].classList.toggle("accordion__open-btn_active");
  element.classList.toggle("accordion_open");
}
function accordionOpenPopUP() {
  specialistsPopUp[0].classList.add("pop-up_active");
  blackout.classList.add("blackout_active");
  html.classList.add("fancybox-enabled");
}

popUpClose.forEach((element, i) => {
  element.addEventListener("click", () => {
    blackout.classList.remove("blackout_active");
    popUp[i].classList.remove("pop-up_active");
    html.classList.remove("fancybox-enabled");
  });
});
openRemind.forEach((element, i) => {
  element.addEventListener("click", () => {
    popUpRemind[0].classList.add("pop-up_active");
    blackout.classList.add("blackout_active");
  });
});

const titleName = $(".advantages__first-item").html();
function owlInitialize() {
  if ($(window).width() < 1300) {
    $(".advantages__first-item").remove();
    $(".advantages__wrap").addClass("owl-carousel owl-carousel-1");
    $(".coming-soon__wrap").addClass("owl-carousel owl-carousel-2");
    $(".profile-coming-soon__wrap").addClass("owl-carousel owl-carousel-3");
    $(".owl-carousel-1").owlCarousel({
      center: true,
      loop: true,
      margin: 10,
      stagePadding: 40,
      dots: true,
      responsive: {
        900: {
          items: 3,
        },
        600: {
          items: 2,
        },
        320: {
          items: 1,
        },
      },
    });
    $(".owl-carousel-2").owlCarousel({
      center: true,
      loop: true,
      margin: 10,
      stagePadding: 40,
      dots: true,
      items: 1,
    });
    $(".owl-carousel-3").owlCarousel({
      //   center: true,
      loop: true,
      margin: 0,
      stagePadding: 40,
      dots: true,
      items: 1,
      autoWidth: true,
    });
  } else {
    $(".owl-carousel").owlCarousel("destroy");
    $(".advantages__wrap").removeClass("owl-carousel");
    $(".coming-soon__wrap").removeClass("owl-carousel");
    $(".profile-coming-soon__wrap").removeClass("owl-carousel");
    if ($(".advantages__first-item").length === 0) {
      $(".advantages__wrap").prepend('<div class="advantages__first-item">' + titleName + "</div>");
    }
  }
  if ($(window).width() < 1024) {
    $(".profile-courses-table").addClass("owl-carousel owl-carousel-4");
    $(".owl-carousel-4").owlCarousel({
      loop: true,
      dots: false,
      nav: true,
      items: 1,
    });
  } else {
    $(".owl-carousel-4").owlCarousel("destroy");
    $(".profile-courses-table").removeClass("owl-carousel");
  }
}
$(document).ready(function (e) {
  owlInitialize();
});
$(window).resize(function () {
  owlInitialize();
});

// select style

let selectSingle = document.querySelectorAll(".select");

selectSingle.forEach((el, index) => {
  let selectSingle_title = el.querySelector(".select__title");
  let selectSingle_labels = el.querySelectorAll(".select__label");

  // Toggle menu
  if (selectSingle_title) {
    selectSingle_title.addEventListener("click", () => {
      selectSingle.forEach((element, i) => {
        if (index !== i) {
          element.setAttribute("data-state", "");
        }
      });

      if (el.getAttribute("data-state") === "active") {
        el.setAttribute("data-state", "");
      } else {
        el.setAttribute("data-state", "active");
      }
    });
  }

  // Close when click to option
  for (let i = 0; i < selectSingle_labels.length; i++) {
    selectSingle_labels[i].addEventListener("click", (evt) => {
      selectSingle_title.textContent = evt.target.textContent;
      el.setAttribute("data-state", "");
    });
  }
  document.body.onclick = function (e) {
    e = e || event;
    target = e.target || e.srcElement;

    if (target.className !== "select__title") {
      if (target.className !== "field__radio") {
        el.setAttribute("data-state", "");
      }
    }
  };
});

const pregnantCheck = document.querySelectorAll('input[name="pregnant"]');
const pregnantShow = document.querySelector(".pregnant-show");
const childrenCheck = document.querySelectorAll('input[name="children"]');
const childrenShow = document.querySelector(".children-show");
const quizField = document.querySelectorAll(".quiz__field");
const quizSubmit = document.querySelector(".quiz__fields_submit");

pregnantCheck.forEach((el) => {
  el.addEventListener("change", () => {
    quizField[1].classList.remove("holded");
    if (el.value === "yes") {
      pregnantShow.classList.add("active");
    } else {
      pregnantShow.classList.remove("active");
    }
  });
});
childrenCheck.forEach((el) => {
  el.addEventListener("change", () => {
    quizSubmit.classList.remove("holded");
    if (el.value === "yes") {
      childrenShow.classList.add("active");
    } else {
      childrenShow.classList.remove("active");
    }
  });
});

const openViewCourse = document.querySelectorAll(".open-view-course");
const quickView = document.querySelector(".quick-view");

openViewCourse.forEach((el) => {
  el.addEventListener("click", () => {
    if (window.innerWidth > 768) {
      quickView.classList.add("pop-up_active");
      blackout.classList.add("blackout_active");
    }
  });
});

const openThankYou = document.querySelector(".open-thank-you");
const popupThankYou = document.querySelector(".pop-up-thank-you");
if (openThankYou) {
  openThankYou.addEventListener("click", () => {
    popUpRemind[0].classList.remove("pop-up_active");
    popupThankYou.classList.add("pop-up_active");
    blackout.classList.add("blackout_active");
  });
}
if ($("*").is(".footer")) {
  $(window).scroll(function () {
    let height = $(window).scrollTop();
    if (height > 100 && height < $(".footer").offset().top - 1000) {
      $(".stiky-btn").addClass("stiky-btn__show");
      $(".sticky-bar").addClass("active");
    } else {
      $(".stiky-btn").removeClass("stiky-btn__show");
      $(".sticky-bar").removeClass("active");
    }

    /*було 100*/
    if (height > 0) {
      $("body > header").addClass("fixed");
    } else {
      $("body > header").removeClass("fixed");
    }
  });
}
/*$(window).scroll(function() {
     let height = $(window).scrollTop();
    if(height > 100 && height < ($('.footer').offset().top) - 1000){
        $('.stiky-btn').addClass('stiky-btn__show');
        $('.sticky-bar').addClass('active');
    } else {
        $('.stiky-btn').removeClass('stiky-btn__show');
        $('.sticky-bar').removeClass('active');
    }
    if(height > 100) {
        $('body > header').addClass('fixed');
    } else {
        $('body > header').removeClass('fixed');
    }
});*/

if (typeof AOS !== "undefined")
  AOS.init({
    // Global settings:
    disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
    startEvent: "DOMContentLoaded", // name of the event dispatched on the document, that AOS should initialize on
    initClassName: "aos-init", // class applied after initialization
    animatedClassName: "aos-animate", // class applied on animation
    useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
    disableMutationObserver: false, // disables automatic mutations' detections (advanced)
    debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
    throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)

    // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
    offset: 200, // offset (in px) from the original trigger point
    delay: 200, // values from 0 to 3000, with step 50ms
    duration: 1000, // values from 0 to 3000, with step 50ms
    easing: "ease", // default easing for AOS animations
    once: true, // whether animation should happen only once - while scrolling down
    mirror: false, // whether elements should animate out while scrolling past them
    anchorPlacement: "top-bottom", // defines which position of the element regarding to window should trigger the animation
  });
$(document).ready(function () {
  $(document).mouseup(function (e) {
    // событие клика по веб-документу
    var div = $(".pop-up"); // тут указываем ID элемента
    if (
        !div.is(e.target) && // если клик был не по нашему блоку
        div.has(e.target).length === 0
    ) {
      // и не по его дочерним элементам
      popUp.forEach((el) => {
        el.classList.remove("pop-up_active");
      });
      blackout.classList.remove("blackout_active");
      html.classList.remove("fancybox-enabled");
    }
  });
});
$(document).ready(function () {


  $('.tracking_video').each(function(){
    var val = $(this).attr('href');
    var vimeoRegex = /(?:vimeo)\.com.*(?:videos|video|channels|)\/([\d]+)/i;
    var parsed = val.match(vimeoRegex);

    var href =  "https://vimeo.com/api/oembed.json?url=" + val;

    //$(this).attr('href',href);


  })



  $(".vimeo").fancybox({
    type: "iframe",
    fitToView: false,
  });
  $(".specialists-pop-up .output_pop-up, .quick-view .quick-view__container").niceScroll({
    cursorcolor: "#aeaeae",
    horizrailenabled: true,
  });

  $(document).on("click", ".specialists .accordion_desktop", function (e) {
    $(".specialists-pop-up .output_pop-up").getNiceScroll().resize();
  });

  $(document).on("click", ".double-btn", function (e) {
    $(".quick-view .quick-view__container").getNiceScroll().resize();
  });

  if ($(".plan").length) {
    function addSlider() {
      let mobSlider1 = $(".plan__field_info-check ul"),
          mobSlider2 = $(".plan__field_benefit");
      if (window.innerWidth < 768) {
        mobSlider1.addClass("owl-carousel");
        mobSlider1.owlCarousel({
          items: 2,
          nav: false,
          dots: true,
          loop: true,
          smartSpeed: 700,
          margin: 15,
          responsiveClass: true,
          responsive: {
            0: {
              items: 1,
              dots: true,
              margin: 15,
              stagePadding: 40,
            },
            576: {
              items: 2,
              dots: true,
              margin: 15,
            },
          },
        });

        mobSlider2.addClass("owl-carousel");
        mobSlider2.owlCarousel({
          items: 2,
          nav: false,
          dots: true,
          loop: true,
          smartSpeed: 700,
          margin: 15,
          responsiveClass: true,
          responsive: {
            0: {
              items: 1,
              dots: true,
              margin: 15,
              stagePadding: 40,
            },
            576: {
              items: 2,
              dots: true,
              margin: 15,
            },
          },
        });
      } else {
        //mobSlider1.owlCarousel('destroy');
        // mobSlider1.removeClass('owl-carousel');
        mobSlider2.owlCarousel("destroy");
        mobSlider2.removeClass("owl-carousel");
      }
    }

    $(window).resize(addSlider);
    $(document).ready(addSlider);
  }

  $(".datepicker-input").datepicker({
    autoClose: true,
    language: "fr",
    dateFormat: "dd MM yyyy",
  });


  $(document).on('click', '.cuttr__readmore', function (e){
    console.log(22)
    $(this).siblings('.course-item__description').toggleClass('is-open');
  })

  if(window.innerWidth > 991){
    $(".course-item__description").Cuttr({
      //options here
      truncate: "words",
      length: 30,
      readMore: true,
      readMoreText: "Montrer plus",
      readLessText: "Montrer moins",
      readMoreBtnTag: 'a',
    });

    $(document).ajaxComplete(function (event, request, settings) {
      $(".course-item__description").Cuttr({
        //options here
        truncate: "words",
        length: 30,
        readMore: true,
        readMoreText: "Montrer plus",
        readLessText: "Montrer moins",
        readMoreBtnTag: 'a',

      });
    });
  } else if(window.innerWidth > 767){
    $(".course-item__description").Cuttr({
      //options here
      truncate: "words",
      length: 20,
      readMore: true,
      readMoreText: "Montrer plus",
      readLessText: "Montrer moins",
      readMoreBtnTag: 'a',
    });

    $(document).ajaxComplete(function (event, request, settings) {
      $(".course-item__description").Cuttr({
        //options here
        truncate: "words",
        length: 20,
        readMore: true,
        readMoreText: "Montrer plus",
        readLessText: "Montrer moins",
        readMoreBtnTag: 'a',
      });
    });
  }else if(window.innerWidth > 575) {
    $(".course-item__description").Cuttr({
      //options here
      truncate: "words",
      length: 10,
      readMore: true,
      readMoreText: "Montrer plus",
      readLessText: "Montrer moins",
      readMoreBtnTag: 'a',
    });

    $(document).ajaxComplete(function (event, request, settings) {
      $(".course-item__description").Cuttr({
        //options here
        truncate: "words",
        length: 10,
        readMore: true,
        readMoreText: "Montrer plus",
        readLessText: "Montrer moins",
        readMoreBtnTag: 'a',
      });
    });
  }else {
    $(".course-item__description").Cuttr({
      //options here
      truncate: "words",
      length: 9,
      readMore: true,
      readMoreText: "Montrer plus",
      readLessText: "Montrer moins",
      readMoreBtnTag: 'a',

    });

    $(document).ajaxComplete(function (event, request, settings) {
      $(".course-item__description").Cuttr({
        //options here
        truncate: "words",
        length: 9,
        readMore: true,
        readMoreText: "Montrer plus",
        readLessText: "Montrer moins",
        readMoreBtnTag: 'a',
      });
    });
  }





  $(document).on("click", ".course-item__description + button", function (e) {
    e.preventDefault();
  });

  $(document).on("click", ".quick-view .course .course-item__content button", function (e) {
    e.preventDefault();
  });

  // profile
  $(".profile-form-contact .double-btn").on("click", function () {
    $(this).parent().prev().find("input").removeAttr("disabled").focus();
  });
  $(".datepicker-profile").datepicker({
    autoClose: true,
    language: "fr",
    onSelect: function (formattedDate, date, inst) {
      var day = date.getDate();
      var mnth = date.getMonth() + 1;
      var txt = ("0" + day).slice(-2) + "/" + ("0" + mnth).slice(-2);
      // $(".profile-date-field .date-picked").text(txt);
    },
  });

  $(".profile-dropdown .dropdown-current").on("click", function (e) {
    e.stopPropagation();
    $(this).parent(".profile-dropdown").toggleClass("active");
    $(this).next().slideToggle(200);
  });
  $(".profile-dropdown .dropdown-options .dropdown-item").on("click", function (e) {
    e.stopPropagation();
    var value = $(this).text();
    var drop = $(this).parents(".profile-dropdown");
    drop.find(".dropdown-current").text(value);
    drop.find(".dropdown-value").val(value);
    drop.find(".dropdown-item.active").removeClass("active");
    $(this).addClass("active");
    drop.removeClass("active").find(".dropdown-options").slideUp(200);
  });
  $(document).on("click", function () {
    $(".profile-dropdown").each(function () {
      $(this).removeClass("active").find(".dropdown-options").slideUp(200);
    });
  });
  $(".profile-courses-table .c-id strong, .profile-courses-table .c-summ strong, .profile-courses-table .c-discount strong").on("click", function () {
    $(this).toggleClass("active").next().slideToggle(100);
  });

  $('.profile-form-wrap .field input[type="tel"]').mask("+00 00 00 00 00 00 00 00", { placeholder: "+__ __ __ __ __ __ __ __" });

  // landing
  function chatScroll() {
    var controller = new ScrollMagic.Controller({
      globalSceneOptions: {
        triggerHook: "onLeave",
      },
    });
    scene = new ScrollMagic.Scene({ triggerElement: "#trigger", duration: $(".lp-chat").height() - $(window).height() })
        .on("enter", function (e) {
          $(".lp-chat-header").height($(".lp-chat-header h2").outerHeight());
          $(".lp-chat-header").addClass("fixed");
        })
        .on("leave", function (e) {
          $(".lp-chat-header").removeClass("fixed");
        })
        .addTo(controller);
  }
  chatScroll();

  function landingIntroHide() {
    if ($(window).scrollTop() > $(window).height()) {
      $(".lp-intro").css("opacity", 0);
    } else {
      $(".lp-intro").css("opacity", 1);
    }
  }
  landingIntroHide();
  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 100) {
      $(".lp-fixed-btn").addClass("show");
    } else {
      $(".lp-fixed-btn").removeClass("show");
    }
    landingIntroHide();
  });

  if ($(".lp-wrapper").length > 0) {
    $("body").addClass("lp-page");
    if ($(".lp-wrapper").hasClass("lp-wrapper-01")) {
      $("body").addClass("lp-page-01");
    }
  }

  /*-------------NEWS-28.04.22------------*/
//TABS


  (function($){
    jQuery.fn.lightTabs = function(options){

      var createTabs = function(){
        tabs = this;
        i = 0;

        showPage = function(i){
          $(tabs).find(".tab-content").children("div").hide();
          $(tabs).find(".tab-content").children("div").eq(i).show();
          $(tabs).find(".tabs-menu").children("li").removeClass("is-active");
          $(tabs).find(".tabs-menu").children("li").eq(i).addClass("is-active");
        }

        var p = 0
        if (typeof tabPage !== 'undefined') {
          p = tabPage
        }
        showPage(0);

        $(tabs).find(".tabs-menu").children("li").each(function(index, element){
          $(element).attr("data-page", i);
          i++;
        });

        $(tabs).find(".tabs-menu").children("li").click(function(){
          showPage(parseInt($(this).attr("data-page")));
        });
      };
      return this.each(createTabs);
    };
  })(jQuery);
  $(".tabs-courses").lightTabs();


  function owlSliderAdd() {
    let testimonialsSlider = $('.testimonials-slider').owlCarousel({
      loop:true,
      margin:0,
      items:1,
      nav:true,
      dots: false,
    });

    let testimonialsSliderHome = $('.home-testimonials-slider').owlCarousel({
      loop:true,
      margin:0,
      items:1,
      nav:true,
      dots: false,
      navContainer: '#customNav',
    });

    let expertSlider = $('.expert-slider').owlCarousel({
      loop:true,
      margin:10,
      responsiveClass:true,
      /*center:true,*/
      responsive:{
        0:{
          items:1,
          nav:false,
          dots: true,
          stagePadding: 45,
          margin:20,
        },
        576:{
          items:2,
          nav:true,
        },
        991:{
          items:3,
          nav:true,
        },
        1281:{
          items:4,
          nav:true,
          loop:false,
          margin:15,
        }
      }
    });

    $('.bonus-slider').owlCarousel({
      stagePadding: 50,
      margin:35,
      nav:true,
      autoWidth:true,
      responsiveClass:true,
      responsive:{
        0:{
          margin:20,
          autoWidth:false,
          items:1,
          stagePadding: 30,
        },
        576:{
          margin:35,
          autoWidth:true,
          stagePadding: 50,
        },
        768:{
          margin:35,
          stagePadding: 50,
        }
      }
    })

    if(window.innerWidth < 992){
      let slider1 =  $('.faq-block .banner-block-wrap .content .wrap');
      slider1.addClass('owl-carousel');
      slider1.owlCarousel({
        stagePadding: 35,
        margin:15,
        nav:false,
        autoWidth:true,
        dots:true,

      })
    }else{
      let slider1 =  $('.faq-block .banner-block-wrap .content .wrap');
      slider1.owlCarousel('destroy');
      slider1.removeClass('owl-carousel');
    }

    if(window.innerWidth < 768){
      $('.home-wrap .banner-block-wrap .content .wrap').addClass('owl-carousel');
      let testimonialsSliderHome = $('.home-wrap .banner-block-wrap .content .wrap').owlCarousel({
        loop:true,
        margin:20,
        autoWidth:false,
        items:1,
        stagePadding: 30,
        items:1,
        nav:false,
        dots: true,
        responsiveClass:true,
        responsive: {
          0: {
            margin: 15,
            autoWidth: false,
            items: 1,
            stagePadding: 30,
          },
          576: {
            margin: 35,
            autoWidth: true,
            stagePadding: 50,
          },
        }
      });


      $('.logo-block .content .wrap').addClass('owl-carousel');
      let logoHomeSlider = $('.logo-block .content .wrap').owlCarousel({
        loop:true,
        margin:20,
        autoWidth:false,
        items:1,
        stagePadding: 30,
        items:1,
        nav:false,
        dots: true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        responsiveClass:true,
        responsive: {
          0: {
            margin: 15,
            autoWidth: false,
            items: 2,
            stagePadding: 0,
          },
          576: {
            margin: 15,
            autoWidth: false,
            items: 2,
            stagePadding: 0,
          },
        }
      });


    }else {
      $('.home-wrap .banner-block-wrap .content .wrap').removeClass('owl-carousel').owlCarousel("destroy");
      $('.logo-block .content .wrap').removeClass('owl-carousel').owlCarousel("destroy");
    }

  }


  $(document).ready(function (e) {
    owlSliderAdd();
  });
  $(window).resize(function () {
    owlSliderAdd();
  });



  $(function() {
    $(".accordion > .accordion-item.is-active").children(".accordion-panel").slideDown();
    $(".accordion > .accordion-item .accordion-thumb").click(function() {
      $(this).parent('.accordion-item').siblings(".accordion-item").removeClass("is-active").children(".accordion-panel").slideUp();
      $(this).parent('.accordion-item').toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
    });
  });


  /*-----------PAGE-COURSE-13-05-22----------------*/
  $(".video-wrap").on('click', function (e){
    $('.hover-block').hide();
    var iframe = $('.video-wrap iframe')[0];
    var myPlayer = new Vimeo.Player(iframe);

    myPlayer.play();
  });

  $(".popup").fancybox({
    touch:false,
    autoFocus:false,
    iframe : {
      scrolling : 'auto',
      preload   : false
    },
  });



  $(window).on('load', function (e){
    if($('.course-page-new').length){
      $(window).on('scroll', function (e){

        let itemHeight1 = $('.info-block').height(),
            itemHeight2 = $('.course-block').height(),
            itemHeight3 = $('.instructeurs-block').height(),
            itemHeight4 = $('.faq-block').height(),
            itemTop1 = $('.info-block').offset().top,
            itemTop2 = $('.course-block').offset().top,
            itemTop3 = $('.instructeurs-block').offset().top,
            itemTop4 = $('.faq-block').offset().top,
            blockItem1 = itemHeight1 + itemHeight2,
            blockItem2 = itemHeight1 + itemHeight2 + itemHeight3,
            blockItem3 = itemHeight1 + itemHeight2 + itemHeight3 + itemHeight4,
            topWindow = $(window).scrollTop();



        if(topWindow < itemHeight1){

          $('.mob-fix-menu ul li').removeClass('current');
          $('.mob-fix-menu ul li:first-child').addClass('current');
        }else if(topWindow > itemHeight1 && topWindow < blockItem1 ){

          $('.mob-fix-menu ul li').removeClass('current');
          $('.mob-fix-menu ul li:nth-child(2)').addClass('current');
        }else if(topWindow > blockItem1  && topWindow < blockItem2 ){

          $('.mob-fix-menu ul li').removeClass('current');
          $('.mob-fix-menu ul li:nth-child(3)').addClass('current');
        }else{
          $('.mob-fix-menu ul li').removeClass('current');
          $('.mob-fix-menu ul li:nth-child(4)').addClass('current');
        }
      })
    }else{

    }

  });


  function myfun() {
    if ($(".mob-fix-menu").length) {
    $(".mob-fix-menu").sticky({
      topSpacing: 68
    });
    }
  };




  $(window).resize(myfun);
  $(document).ready(myfun);


  $(".fancybox-video").fancybox({
    touch:false,
    autoFocus:false,
    afterShow : function(e){
      setTimeout(function() {
        $('#video-file').trigger('pause');
      }, 10);
    },
  });

  $(document).on('click', '.popup-video .main-wrap .btn-wrap a', function (e){
    $('.popup-video').addClass('is-play');
    $('#video-file').trigger('play');
  });

  $(window).on('load', function (e){
    $('#video-bg-1').trigger('play');
    $('#video-bg-2').trigger('play');
  });

  $(document).on('click', '.video-bg-block .btn-wrap a', function (e){
    e.preventDefault();
    if($('.video-bg-block').hasClass('is-pause')){
      $(this).closest('.video-bg-block').removeClass('is-pause').find('video').trigger('play');
    }else{
      $(this).closest('.video-bg-block').addClass('is-pause').find('video').trigger('pause');
    }

  })

/*  $(".item-3n-bg .item .text-wrap p.text").Cuttr({
    //options here
    truncate: "words",
    length: 20,

  });*/

    $(document).on('click', '.input-wrap-radio-1', function (e){
      if($(this).find('input').prop('checked')){
        $('.form-wrap-content').addClass('is-sel-1');

      }
    });

$(document).on('click', '.input-wrap-radio-2', function (e){
  if($(this).find('input').prop('checked')){
  $('.form-wrap-content').addClass('is-sel-2');
}
});

  $(document).on('click', '.select__content', function (e){
    $('.select__title').addClass('is-active')
  });


  $('.tel-mask').mask('+00 (0) 00 00 00 00');


  $('.sign-up-new .wrap-img-form .right .input-wrap-select select').niceSelect();

  $(document).on('click', '.sign-up-new .wrap-img-form .right .input-wrap-check .wrap input', function (e){
    if($(this).prop("checked")){
      $('.sign-up-new .wrap-img-form .right .input-wrap-hide').slideDown();
    }else{
      $('.sign-up-new .wrap-img-form .right .input-wrap-hide').slideUp();
    }
  });
});
