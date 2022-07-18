jQuery(document).ready(function ($) {


    // cookies
    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }


    // focus checkout courses
    $(document).on('click','[data-focus_course]',function(e){
        e.preventDefault();
        var course_id = $(this).data('focus_course');
        if(course_id) {
            setCookie('focus_course',course_id,1);
        }
        window.location.href = $(this).attr('href');
    });
    

    // quiz logic
    var quizFields = $('.quiz__field');
    if(quizFields.length) {
        var quizBtn = $('.quiz__fields_submit.holded');
        quizFields.each(function (index,el) {
            var fr = $(this).find('.field__radio'),
                quizOptionsWrap = $(el).find('.quiz__field_show'),
                nextIndex = ++index;
            fr.on('change',function (params) {
                if($(this).val()=='yes') {
                    quizOptionsWrap.addClass('active');
                } else {
                    quizOptionsWrap.removeClass('active');
                }
                if(quizFields[nextIndex]) {
                    $(quizFields[nextIndex]).removeClass('holded');
                } else {
                    quizBtn.removeClass('holded');
                }
            });
        });
    }

    // ty popup after submit
    function openPopup(popupClass=null) {
        if(popupClass) {
            $('.pop-up.pop-up_active').removeClass('pop-up_active');
            $('.blackout').addClass('blackout_active');
            $(popupClass).addClass('pop-up_active');
        }
    }
    document.addEventListener( 'wpcf7submit', function( event ) {
        // console.log('event', event)
        
        if ( event.detail.status == 'mail_sent' ) {
            $.fancybox.close();
            openPopup('.pop-up-remind.pop-up-thank-you');
        }

        // var style = $(event.target).find('.wpcf7-response-output').css('display');
        
        if($(event.target).find('.wpcf7-response-output').css('display')=='none')
        $(event.target).find('.wpcf7-response-output').fadeIn(300);

        if($(event.target).find('.wpcf7-response-output').css('display')=='block')
        setTimeout(function () {
            $(event.target).find('.wpcf7-response-output').fadeOut(300);
        }, 6000);
        
        // // setTimeout(function () {
        //     $.fancybox.close();
        //     // $(event.target).find('.wpcf7-response-output').slideToggle(700);
        //     openPopup('.pop-up-remind:not(.pop-up-thank-you)');
        // // }, 3000);
        
    }, false );

    // upd popup form
    $(document).on('click','[data-remind_course]',function(){
        var course = $(this).data('remind_course');
        if($('.pop-up-remind input[name="course"]').length) $('.pop-up-remind input[name="course"]').val(course);
        openPopup('.pop-up-remind:not(.pop-up-thank-you)');
    });
    
    // standard ajax process
    function mamamsAjax(submitData,onSuccess,container=null,action='GET') {
        $.ajax({
            type: action,
            url: window.global.url,
            data: submitData,
            dataType: 'json',
            beforeSend: function (response) {
                // Add loader
                if(container) container.addClass('loading');
            },
            complete: function(response) {
                if(container) container.removeClass('loading');
            },
            success: onSuccess
        });
    }

    $(document).on('click','.quiz__fields_submit',function(e){
        e.preventDefault();
        $(this).closest('form').submit();
    });
    
    // ajax load more
    $(document).on('click','.load_more',function(e){
        e.preventDefault();
        var datas=$(this).data();

        if(datas) {
            var container = $(this).prev('.output_wrap'),
                btnMore = $(this);
                console.log('container', container)
            var submitData = datas,
            onSuccess = function(data) {
                console.log('data', data)
                    if(btnMore.length) btnMore.remove();
                    if (data.update == true) {
                        if(data.output_html) container.append(data.output_html)
                        if(data.btn_html) container.after(data.btn_html);
                    }
                };
                mamamsAjax(submitData, onSuccess, container,);
        }
        
    });

    // ajax submit forms
    $(document).on('submit', '.ajax_form', function(e) {
        e.preventDefault();
        var data = $(this).serializeArray(),
            container = $(this);
        

        var submitData = data,
            onSuccess = function(data) {
                if(data.status) container.find('.status').html(data.status);
                if (data.update == false) {
                }
                if (data.update == true) {
                    if(data.redirect) window.location.href = data.redirect;
                    if(data.remove&&$(data.remove).length) $(data.remove).slideToggle(300);
                    if(data.show&&$(data.show).length) $(data.show).slideToggle(300);
                }
            };
            mamamsAjax(submitData, onSuccess, container, 'POST');
    });

    function initAccordionEvents(container=null) {
        if(!container) return;
        var accordions = container.find('.accordion');
        if(accordions.length)
        accordions.on('click',function(e){
            e.preventDefault();
            var el = $(this),
                descr = el.find('.accordion__item-second'),
                btn = el.find('.accordion__open-btn');
            el.toggleClass('accordion_open');
            descr.toggleClass('accordion__item-second_open');
            btn.toggleClass('accordion__open-btn_active');
        });
    }

    // ajax load part
    $(document).on('click','[data-action="ajax_template_part"]',function(e){
        e.preventDefault();

        if(window.innerWidth<=768) {
            var course_url = $(this).data('course_url');
            window.location.href = course_url ? course_url : '';
        }
        else {
            var datas = $(this).data(),
            
            container = datas.target ? $('.'+datas.target) : null;
        }

        
        if(datas&&container[0].dataset.id!=datas.id) {
            container[0].dataset.id=datas.id;

            var submitData = datas,
            onSuccess = function(data) {
                if (data.update == true) {
                    if(data.output_html&&container) {
                        container.find('.output_pop-up').html(data.output_html);
                        initAccordionEvents(container);
                        if($('.quick-view__container .tracking_video iframe, .quick-view__container .demo_video iframe').length){
                            $iframes=$('.quick-view__container .tracking_video iframe, .quick-view__container .demo_video iframe');
                            addIframeTrackingEvent($iframes);
                        }
                    } 
                }
            };
            mamamsAjax(submitData, onSuccess, container, 'POST');
        }

    });


    // choose plan
    var choosePlanForm = $('#choose-plan');
    if(choosePlanForm.length){
        choosePlanForm.on('change','input[name="course_id"]',function(e){
            var price = $(this).data('price'),
            
                currency = $(this).data('currency');
                console.log('price', price)
                $(this).closest('.plan__field').find('.plan__field_price').text(currency+price);
        });
    }

    
    // tracking course video

    function nextVideoProcessed($thisItem=null) {
        console.log('$thisItem', $thisItem)
        if($thisItem) {
            var nextItem = $thisItem.next('.course-item');
            console.log('nextItem', nextItem)
            if(nextItem.length) {
                $.fancybox.open('<div class="dynamic_button"><button class="main-btn red-btn">Next</button></div>',{
                    toolbar  : false,
                    smallBtn : false,
                });
                $('.dynamic_button button').on('click',function (e) {
                    e.preventDefault();
                    $.fancybox.close();
                    $.fancybox.close();
                    nextItem.find('.tracking_video').click();
                    console.log('nextItem', nextItem.find('.tracking_video'))
                });
                
            }
            
        }
        
    }
    function updProgress($item=null) {
        if($item===null) return;
        
        var serializeArray = $item.serializeArray();

        if(!serializeArray) return;

        serializeArray.push({
            name: 'action',
            value: 'upd_course_progress',
        });
        var submitData = serializeArray,
            onSuccess = function(data) {
                if (data.update == true) {
                }
            };
        mamamsAjax(submitData, onSuccess, null, 'POST');
    }

    function addIframeTrackingEvent($iframes=null) {

        if($iframes)
        $iframes.each(function(index, el) {
            var item = $(el).closest('form'),
            progressbar = item.find('.progress-block__progress-result'),
            progresscount = item.find('.progress-block__result-title span'),
            progressinput = item.find('input[name="progress"]'),
            progressinputcount = progressinput ? Number(progressinput.val()) : 0,
            tracking = item.hasClass('tracking_video'),
            iframe = el;

            if(tracking) {
                var player = new Vimeo.Player(iframe),
                    progresscountHasClass = item.find('.progress-block__result-title').hasClass('progress-block__result-title_green');

                player.on('timeupdate', function(data) {
    
                    console.log('data', data)
                    cent = Math.round((data.percent * 100) * 100) / 100; 
    
                    if(progressinputcount<cent) {
                        progressbar.css('width',cent+'%');
                        progresscount.text(cent+'%');
                        item.find('input[name="progress"]').val(cent);
                        progressinputcount=cent;
                        updProgress(item);
                        if(!progresscountHasClass) item.find('.progress-block__result-title').addClass('progress-block__result-title_green');
                    }
    
                    if(data.percent===1) updProgress(item);
    
                });

                player.on('pause', function(data) {
    
                    updProgress(item);
    
                });

                player.on('ended', function(data) {
    
                    updProgress(item);
    
                });

                

                
            }
            
            
        });
    
            
    }
    

    $('.course__wrap').on('click','.course-item .tracking_video, .course-item .demo_video',function(e){
        e.preventDefault();

        var item = $(this).closest('form'),
            progressbar = item.find('.progress-block__progress-result'),
            progresscount = item.find('.progress-block__result-title span'),
            progressinput = item.find('input[name="progress"]'),
            progressinputcount = progressinput ? Number(progressinput.val()) : 0,
            tracking=$(this).hasClass('tracking_video');
            
        $.fancybox.open({
            src  : $(this).attr('href'),
            type : 'iframe',
            opts : {
                afterShow : function( instance, current ) {
                    if(tracking) {
                        
                        var iframe = current.$iframe[0]
                        var player = new Vimeo.Player(iframe);
                        progresscountHasClass = item.find('.progress-block__result-title').hasClass('progress-block__result-title_green');

                        player.on('timeupdate', function(data) {

                            console.log('data', data)
                            cent = Math.round((data.percent * 100) * 100) / 100; 

                            if(progressinputcount<cent) {
                                progressbar.css('width',cent+'%');
                                progresscount.text(cent+'%');
                                item.find('input[name="progress"]').val(cent);
                                progressinputcount=cent;
                                if(!progresscountHasClass) item.find('.progress-block__result-title').addClass('progress-block__result-title_green');
                            }

                            if(data.percent===1) {
                                updProgress(item);
                            } 

                        });

                        player.on('ended', function(data) {
    
                            nextVideoProcessed(item);
            
                        });
                    }
                },
                afterClose : function( instance, current, e ) {
                    updProgress(item);
                }
            }
        });
    });

    
});



