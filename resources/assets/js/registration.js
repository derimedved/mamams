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

})(jQuery);