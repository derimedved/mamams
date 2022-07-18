/**
 * File active.js
 * Preloader, back to top scroll, mobile menu navigiation, keyboard navigation.
 */
(function ($) {

    "use strict";

    jQuery(window).load(
        function () {
            jQuery(".preloader-wrapper").fadeOut();
        }
    );

    var amountScrolled = 300;
    $(window).scroll(
        function () {
            if ($(window).scrollTop() > amountScrolled) {
                $('div.back-to-top').fadeIn('slow');
            } else {
                $('div.back-to-top').fadeOut('slow');
            }
        }
    );

    $('div.back-to-top').on(
        'click',
        function () {
            $('html, body').animate(
                {
                    scrollTop: 0
                }, 700
            );
            return false;
        }
    );

    $(document).ready(
        function () {
            var $main_nav = $('.dostart-mainmenu #site-navigation');
            var $toggle = $('.toggle');

            var defaultData = {
                disableAt: 991,
                customToggle: $toggle,
                //  levelOpen: 'expand',
                disableBody: true,
                levelTitles: false,
            };
            // call our plugin
            var Nav = $main_nav.hcOffcanvasNav(defaultData);
            $('.toggle').on(
                'click', function () {
                    totalKeyboardLoop($('.sub-menu'));
                    $('.nav-close').attr('tabindex', '3');
                    $('.nav-close').focus();
                }
            );
        }
    );

    var totalKeyboardLoop = function (elem) {
        var tabbable = elem.find('select, input, textarea, button, a').filter(':visible');

        var firstTabbable = tabbable.first();
        var lastTabbable = tabbable.last();
        /*set focus on first input*/
        firstTabbable.focus();

        /*redirect last tab to first input*/
        lastTabbable.on(
            'keydown', function (e) {
                if ((e.which === 9 && ! e.shiftKey)) {
                    e.preventDefault();
                    firstTabbable.focus();
                }
            }
        );

        /*redirect first shift+tab to last input*/
        firstTabbable.on(
            'keydown', function (e) {
                if ((e.which === 9 && e.shiftKey)) {
                    e.preventDefault();
                    lastTabbable.focus();
                }
            }
        );
    };

})(jQuery);