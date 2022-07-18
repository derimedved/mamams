jQuery(document).ready(function(){

    $('[data-focus_course]').click(function(){
        var courseName = $(this).attr('data-name')
        dataLayer.push({
            'event' : 'courseAddToCart',
            'event-parameter' : courseName
        });
    })


    $('.sticky-bar__btn-wrap a').click(function(){

        dataLayer.push({
            'event' : 'abonnementAddToCartSticky',
        });
    })


    $(document).on('click', '.btn-next-1', function (e){
        e.preventDefault();
        var step = $(this).attr('data-step')

        dataLayer.push({
            'checkoutStepNumber' : step,
            'checkoutStepName' : 'connexion',
            'event' : 'checkoutContinueStep1',
            'event-parameter' : get_course()
        });

    });

    // $(document).on('click', '.submit_checkout', function (e){
    //     e.preventDefault();
    //
    //
    //
    // });

    $(document).on('click', '.submit_checkout_payment', function (e){
        e.preventDefault();

        dataLayer.push({
            // 'checkoutStepNumber' : '3',
            // 'checkoutStepName' : 'payment',
            'event' : 'checkoutProceedPayment',
            'event-parameter' : get_course()
        });

    });



    $(document).on('click', '.to-login', function (e){
        e.preventDefault();

        dataLayer.push({

            'event' : 'checkoutConnexionStep2',
            'event-parameter' : get_course()
        });

    });



    if ($('.lp-form-main').length) {
        $(document).on('submit', '._form', function (e){
            e.preventDefault();

            var title = $('main').attr('data-lptitle')
            dataLayer.push({

                'event' : 'ctaGetFreeDocument',
                'event-parameter' : title
            });

        });
    }




     








})



function get_course() {
    var parameter;
    var course_type =  $('[name="course_type"]:checked').val();
    var course = $('[name="course_id"] option:selected').text();

    if ('one_course' === course_type)
        parameter = course
    else
        parameter = 'premium'

    return parameter;
}