(function ($, settings) {

    var invalid, valid ;

    function formIsValid() {
        return $(".ajax_form").valid() && $(".ajax_form").validate().pendingRequest === 0;
    }


    $('.btn-next-1').click(function(e){
        e.preventDefault();
        e.stopPropagation()
        invalid = false;
    
    
        $('.form-wrap-checkout [name]').each(function(){
            var name = $(this).attr('name')
            valid = $(this).valid({async:true});
    
    
            if (valid == false)
                invalid = true
        })
    
    
        setTimeout(function(){
    
            if (!invalid && formIsValid()) {
                $('.checkout-upd .checkout-menu li:nth-child(2)').removeClass('disabled');
                $('.content-item-1').hide();
                $('.content-item-2').show();
                $('.checkout-upd .checkout-menu li:nth-child(2)').addClass('is-active');
                $('.sticky').show()

            }
    
        }, 200)
    })
    
    
    $('.submit-registration').click(function(e) {
        e.preventDefault();
        $("form").validate().settings.ignore = "*";
        $('.ajax_form').submit();
        activeCamp()
    })

   // $('.registration-quiz').validate()


    $('.registration-quiz').validate({



        submitHandler: function(form) {







            $('._form_13 [name="email"]').val($('#email-10').val());
            $("#_form_13_submit").click();
            $('#email-10').val('')



            var email = $('.registration-quiz #email').val()

            console.log(email)


            $('[data-name="email"]').val(email);
            $('[data-name="quiz'+quiz_active_campaign_id+'link"]').val(link);
            $('.datetime_date[data-name="quizstartdate"]').val(startDate);
            $('.datetime_time[data-name="quizstartdate"]').val(startTime);


            $('#_form_15_submit').click();



            dataLayer.push({

                'event' : 'ctaGetQuizResults',
                'event-parameter' : quizName
            });


            
            $('.ajax_form').submit();


            return false;


        }
    });



    $('.ajax_form .form-submit').click(function(e) {

        activeCamp()
    })
    
    function activeCamp() {

        var name = $('[name="first_name"]').val(),
            last_name = $('[name="last_name"]').val(),
            email = $('[name="email"]').val(),
            phone = $('[name="phone"]').val(),
            age = $('[name="age"]').val();


        $('._form_11 [name="firstname"]').val(name);
        $('._form_11 [name="lastname"]').val(last_name);
        $('._form_11 [name="email"]').val(email);
        $('._form_11 [name="phone"]').val(phone);

        $('._form_11 [name="field[3]"]').val(age)


        let radio = $('#agree:checked');

        if (radio.is(':checked'))
            $('._form_11 [name="act"]').prop('checked',true)
        else
            $('._form_11 [name="act"]').prop('checked',false)

        $("#_form_11_submit").click();

    }


    //$('.recommend-form').validate();



    $('.recommend-form').validate({



        submitHandler: function(form) {

            $('._form_13 [name="email"]').val($('#email-10').val());
            $("#_form_13_submit").click();
            $('#email-10').val('')
        }
    });


    
    $('.fake-code').click(function(e){
        e.preventDefault();
        var val = $('#code').val();
        if (val === 'EXCLEDFM_2022') {
            location.href = "/create-account?excl=1"
        } else
            $('.fake-result').html("le code n'est pas valide")
    })

})(jQuery);