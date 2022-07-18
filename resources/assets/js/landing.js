
$(document).ready(function() {

    
    
    $(document).on('click', '.fix-close', function (e){
        e.preventDefault();
        $('.fix-info').hide();
    });

    $(document).on('click', '.next-display', function () {
        var win = $(window).height();
        $('body,html').animate({
            scrollTop: win
        }, 800);
        return false;
    });




    var swiper1 = new Swiper(".our-customers-slider", {
        loop: true,

        slidesPerView: 1,
        navigation: {
            nextEl: ".swiper-button-next-1",
            prevEl: ".swiper-button-prev-1",
        },
    });
    var swiper2 = new Swiper(".themes-covered-slider", {
        loop: true,
        slidesPerView: 5,
        centeredSlides: true,
        navigation: {
            nextEl: ".swiper-button-next-2",
            prevEl: ".swiper-button-prev-2",
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            1400: {
                slidesPerView: 5,
                spaceBetween: 10,
            },
        }
    });
});
