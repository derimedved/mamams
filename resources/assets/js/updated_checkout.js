jQuery(document).ready(function ($) {



  
  $('.checkout-upd select').niceSelect();

  $(document).on('click', '.checkout-upd .checkout-wrap .btn-bottom-wrap>a', function (e){

    e.preventDefault();
    let item = $(this).closest('.checkout-wrap');
    if(!item.hasClass('is-selected')){
     $('.checkout-upd .checkout-wrap').removeClass('is-selected');
      item.addClass('is-selected');
      item.find('input').click();

    }
    $('.checkout-upd .checkout-wrap .btn-bottom-wrap a').text('Choisir');
    $('.checkout-upd .checkout-wrap.is-selected .btn-bottom-wrap a').text('Choisi');
  });

  $(document).on('click', '.checkout-upd .checkout-menu li:not(.disabled) a', function (e){

    e.preventDefault();
    let item = $(this).parent('li'),
        itemIndex = item.index() + 1;
    console.log(itemIndex)
    item.addClass('is-active');
    item.next().removeClass('is-active');
    item.prev().addClass('is-active');

    $('.content-item').hide();
    $(".content-item:nth-child(" + itemIndex + ")").show()
  })

  $(document).on('click', '.btn-next-1', function (e){
    e.preventDefault();
    $('.checkout-upd .checkout-menu li:nth-child(2)').addClass('is-active');
    $('.content-item-1').hide();
    $('.content-item-2').show();
  });

  $(document).on('click', '.btn-next-2', function (e){
    e.preventDefault();
    $('.checkout-upd .checkout-menu li:nth-child(3)').addClass('is-active');
    $('.content-item-2').hide();
    $('.content-item-3').show();
  });

  

  $(document).on('click', '.add-more', function (e){
    e.preventDefault();
    $(this).closest('.checkout-wrap').addClass('is-open');
  });

  $(document).on('click', '.hide-more', function (e){
    e.preventDefault();
    $(this).closest('.checkout-wrap').removeClass('is-open');
  });


  function addSlider() {
    let oneSlider = $(".checkout-upd .item-wrap");
    if(window.innerWidth < 768){
      oneSlider.addClass('owl-carousel');
      oneSlider.owlCarousel({
        items: 1,
        nav: false,
        dots: true,
        loop: true,
        smartSpeed: 700,
        margin:10,
        stagePadding: 10,

      });

    }else{
      oneSlider.owlCarousel('destroy');
      oneSlider.removeClass('owl-carousel');
    }
  };

  $( window ).resize(addSlider);
  $( document ).ready(addSlider);

  $(window).on("load", function (e){


    if(window.innerWidth < 576){
      $("header").addClass('is-sticky');

      $(document).scroll(function() {
        var documentScrollTop = $(document).scrollTop();
        if (documentScrollTop > 1) {
          $(".checkout-upd .sticky").addClass('is-sticky');
        }
        else {
          $(".checkout-upd .sticky").removeClass('is-sticky');
        }
      });


      $("header").sticky({
        topSpacing:0
      });
      $(".checkout-upd .sticky").sticky({
        topSpacing:83
      });
    }else{
      $(".checkout-upd .sticky").sticky({
        topSpacing:15
      });
      $("header").removeClass('is-sticky');
    }
  })





})