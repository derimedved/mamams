'use strict';

var app = {
  init: function init() {
    app.windowResize();
    app.modals();
    app.menu();
    app.custom();
    app.selectric();
    app.sliders();
  },

  windowResize: function windowResize() {
    $(window).on('resize', function () {});
  },

  windowLoad: function windowLoad() {
    $(window).on('load', function () {});
  },

  menu: function menu() {
    var $btnMenu = $('.jsMenu');
    $btnMenu.click(function () {
      $(this).toggleClass('menu-is-active');
      $('._nav').slideToggle();
      $('body').toggleClass('menuopen');
    });

    $('.jsScrollTo').on('click', function (e) {
      e.preventDefault();
      var $id = $(this).attr('href'),
          top = $($id).offset().top;

      if ($id) {
        $('body,html').animate({
          scrollTop: top
        }, 700);
      } else {
        return false;
      }
    });
  },

  custom: function custom() {
	  
	let $customHeight = 0;

    function titleHeight(){
      let $courseName = $('.b_courses .course_name');
      if( $(window).width() >= 992 ){
        $courseName.outerHeight('unset');
        $courseName.each(function(){
          if ( $customHeight < $(this).outerHeight() ) {
            $customHeight = $(this).outerHeight();
          }
        });
        $courseName.outerHeight($customHeight);
      } else {
        $courseName.outerHeight('unset');
      }
    }

    titleHeight();

    $('.b_courses .course_block').each(function(){
      let $this = $(this);
      let $fullDescription = $this.find('.full_description');
      let $fullDescriptionInner = $this.find('.full_description_inner').outerHeight();
      
      if( $fullDescription ){
        $fullDescription.attr('data-maxHeight',$fullDescriptionInner);
        $fullDescription.parent().append('<button type="button" class="jsMore">More</button>')
      }
    });

    $(window).on('load resize', function () {
      $('.b_courses .course_block').each(function(){
        let $this = $(this);
        let $fullDescription = $this.find('.full_description');
        let $fullDescriptionInner = $this.find('.full_description_inner').outerHeight();
        if( $fullDescription ){
          $fullDescription.attr('data-maxHeight',$fullDescriptionInner);
        }
      });
	  titleHeight();
    });

    $(document).on('click', '.jsMore', function(){
      let $this = $(this);
      let $thisData = $this.parents('.course_description').find('.full_description').attr('data-maxHeight');
      $this.closest('.course_description').find('.jsMore').hide();
      $this.closest('.course_description').find('.full_description').css('max-height', $thisData+'px');
    });

    $('.btn_less').on('click', function(){
      let $this = $(this);
      $this.closest('.course_description').find('.jsMore').show();
      $this.closest('.course_description').find('.full_description').css('max-height', 73+'px');
    });
  },

  selectric: function selectric() {
    $('.jsSelectricView').selectric({
      maxHeight: 195,
      disableOnMobile: false,
      nativeOnMobile: false
    });
  },

  sliders: function sliders() {

    let $wrapperSlider = $('.jsCasesSlider'),
		    wrapperSlider = $wrapperSlider[0];

    $(window).on('resize load', function () {

      if($('.jsCasesSlider').length){
        $('.jsCasesSlider').each(function () {
          let $thisCasesSlider = $(this);
  
          if ($(window).width() >= 992) {
            if (!$thisCasesSlider.hasClass('slick-initialized')) {
              $thisCasesSlider.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                touchThreshold: 200,
                dots: false,
                infinite: false,
                // swipe: false
              });
            }
          } else {
            if ($thisCasesSlider.hasClass('slick-initialized')) {
              $thisCasesSlider.slick('unslick');
            }
          }
        });
      }
    });


    if($('.jsCasesSlider').length){
      $('.jsCaseReviews').each(function () {
        let $thisCaseReviews = $(this);
  
        $thisCaseReviews.on('init', function(event, slick, currentSlide, nextSlide){
          let $dots = $thisCaseReviews.find('.slick-dots');
          let arrowPrev = $thisCaseReviews.find('.slick-prev');
          let arrowNext = $thisCaseReviews.find('.slick-next');
          let dotsWrapper;
  
          if( $dots.length ){
            $dots.wrapAll('<div class="dots_wrapper"></div>');
            dotsWrapper = $thisCaseReviews.find('.dots_wrapper');
          }
  
          if( arrowPrev.length ){
            dotsWrapper.prepend(arrowPrev)
          }
  
          if( arrowNext.length ){
            dotsWrapper.append(arrowNext)
          }
        });
  
        $thisCaseReviews.slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          touchThreshold: 200,
          dots: true,
          infinite: false,
        });

        $thisCaseReviews.on('mousedown', function(){
          wrapperSlider.slick.setOption({
            swipe: false
          })
        });

        $thisCaseReviews.on('mouseleave', function(){
          wrapperSlider.slick.setOption({
            swipe: true
          })
        });
      });
  
    }

    $('.jsExpertsList').slick({
      // arrows: false,
      dots: false,
      slidesToShow: 5,
      slidesToScroll: 1,
      touchThreshold: 200,
      autoplay: true,
      autoplaySpeed: 4000,
      pauseOnHover: false
    });

    $('.jsReviewSlider').slick({
      // arrows: false,
      slidesToShow: 2,
      slidesToScroll: 1,
      touchThreshold: 200,
      dots: false,
      responsive: [{
        breakpoint: 768,
        settings: {
          slidesToShow: 1
        }
      }]
    });

    $('.case_slide').each(function () {
      var $this = $(this);
      var $thisBtn = $this.find('.btn_more');
      var $content = $this.find('.case_reviews');

      $thisBtn.on('click', function () {
        if ($(window).width() <= 992) {
          var $contentInner = $this.find('.case_reviews_inner').outerHeight();

          $thisBtn.toggleClass('active');
          if ($thisBtn.hasClass('active')) {
            $content.css('max-height', $contentInner);
          } else {
            $content.css('max-height', '0px');
          }
        }
      });
    });
  },

  modals: function modals() {

    var $mobile = false;
    $(window).on('ready resize load', function () {
      if ($(window).width() <= 768) {
        $mobile = true;
      } else {
        $mobile = false;
      }
    });

    $('.jsCloseModals').on('click', function (e) {
      e.preventDefault();
      var $this = $(this);

      if (!$mobile) {
        $('body').removeClass('modalOpen');
        $this.parents('.expert_content').fadeOut(200);
      } else {
        $('.jsOpenModals').removeClass('active');
        $('.expert_content').slideUp(200);
        $('.experts_list').removeClass('active');
      }
    });

    $('.jsOpenModals').on('click', function (e) {
      e.preventDefault();
      var $this = $(this);

      if (!$mobile) {

        $('body').addClass('modalOpen');
        var $thisHref = $this.attr('data-href');
        $('#' + $thisHref).fadeIn(200);
      } else {

        if ($this.hasClass('active')) {

          $this.removeClass('active');
          var _$thisHref = $this.attr('data-href');
          $('#' + _$thisHref).slideUp(200);
        } else {

          $('.jsOpenModals').removeClass('active');
          $('.expert_content').slideUp(200);
          $this.addClass('active');
          var _$thisHref2 = $this.attr('data-href');
          $('#' + _$thisHref2).slideDown(200);
        }

        if ($('.experts_list .image_block.active').length) {
          $('.experts_list').addClass('active');
        } else {
          $('.experts_list').removeClass('active');
        }
      }
    });

    $(document).on('click touchstart', function (e) {
      if (!$mobile) {
        var $btnPopup = $('.jsOpenModals');
        var $expertContent = $('.expert_block');
        if (!$btnPopup.is(e.target) && $btnPopup.has(e.target).length === 0 && !$expertContent.is(e.target) && $expertContent.has(e.target).length === 0) {
          $('.expert_content').fadeOut(200);
          $('body').removeClass('modalOpen');
        }
      }
    });
  }

};

$(document).ready(app.init());

app.windowLoad();