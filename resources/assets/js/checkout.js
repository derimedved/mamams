var checkoutObj

( function( $, settings ) {
	'use strict';

	/**
	 * Checkout
	 *
	 * @param options
	 */
	 var Checkout = function( options ) {
		
		const stripe = Stripe(options.publishable_key);

		const $formCheckout = $( '.ajax_checkout_form' ),
		
			$checkoutButton = $('.checkout_button'),

			$formCourses = $formCheckout.find('[name="course_id"]'),

			$couponField = $formCheckout.find('input[name="coupon"]'),

			$couponBtn = $formCheckout.find('.apply-coupon'),
			
			$paymentMethod = $formCheckout.find('input[name="payment_method"]'),

			$toLogin = $formCheckout.find('.to-login'),
			
			$paymentFields = $formCheckout.find('input[name="payment"]');
			
		var precent=0,focusCourseValue=null;

		function scrollTo($class) {
			$([document.documentElement, document.body]).animate({
				scrollTop: $($class).offset().top
			}, 700);
		};

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

		const mamamsAjax = function(submitData,onSuccess,container=null,action='GET') {
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

		const calcPrecent = function(precent=null,price=0) {
			if(price&&precent) {
				if(typeof price === 'number') {
					price = price - ((price/100)*precent);
				}
			}

			return price || false;
		}

		const LastState = function() {
			var current_method = getCookie('current_method'),
				course_type = getCookie('course_type'),
				return_to_plan = getCookie('return_to_plan');

			if(current_method&&course_type) {
				//var container = $formCheckout.find('.checkout_button[data-course_type="'+course_type+'"]').closest('.plan__field');
				var container = $formCheckout ;

				var radio = container.find('[name="payment"][value="'+current_method+'"]');
				radio.click();
				radio[0].checked = true;
			} else {
				$paymentFields[0].click();
				$paymentFields[0].checked = true;
			}
			if(return_to_plan) {
				setCookie('return_to_plan','');
			}
		}

		const focusCourse = function(e) {
			$formCheckout.addClass('loading');
			var price = $(this).data('price')  || '';
			var tax = $(this).data('tax') || '';
			var currency = $(this).data('currency') || '';



			var image = $(this).data('image') || '';
			var description = $(this).data('description') || '';
			var container = $formCheckout;
			setCookie('focus_course',$(this).val());
			focusCourseValue=$(this).val();
			
			// calc tax
			if(tax&&price!='Free') {
				var taxPrice = calcPrecent(Number(tax),price),
					texText = container.find('.tax-text').data('tax_text');
				texText = texText ? texText : '*DONT LA TVA DE ';
				taxPrice = price-taxPrice;
				taxPrice = Math.round(taxPrice * 100 / 100) ;



				price += taxPrice;

				if ($('[name="course_type"][value="one_course"]').prop('checked') == true)
					container.find('.cost-wrap  .info').html(texText+' '+tax+'% ('+currency+taxPrice+')');
			} else {
				if ($('[name="course_type"][value="one_course"]').prop('checked') == true)
					container.find('.cost-wrap .info').text('');
			}

			// calc discount
			if(precent&&$couponField&&price!='Free') {
				var newPrice = calcPrecent(Number(precent),price);
			//	container.find('.old-price').html(currency+price);
				var promo = container.find('.coupone-text').data('promo_text');
				container.find('.coupone-text').text(promo+' (-'+precent+'%)');
				if(newPrice) price = newPrice;
			} else {
				//container.find('.old-price').text('');
				container.find('.coupone-text').text('');
			}
			
			if(typeof price === 'number') price = currency+price;

			if ($('[name="course_type"][value="one_course"]').prop('checked') == true)
				container.find('.cost').html(price);
			// container.find('.plan__field_details-img').html(image);
			// container.find('.plan__field_details-description').html(description);
			$formCheckout.removeClass('loading');


		};

		const checkCoupon = function(e) {
			e.preventDefault();
			var coupon = $couponField.val(),
				container = $('.input-wrap-code');

			if(coupon&&!$couponBtn.is(":disabled")) {
				var submitData = {
					action: 'ajax_check_coupon',
					coupon: coupon,
				},
				onSuccess = function(data) {
					console.log('data', data)
					if(data.status) container.find('.status').html(data.status);
					if (data.update == true && data.percent ) {
						precent = data.percent;
						$couponBtn.attr('disabled','true');
						$couponBtn.css('opacity','0.4');
						$couponField.prop('readonly', true);
					} else {
						precent = 0;
						scrollTo('.status');
					}

					//focusCourse.bind($('input[name="course_id"]:checked'))();
					focusCourse.bind($('[name="course_id"] option:selected'))();
				};



				mamamsAjax(submitData, onSuccess, container, 'POST');
			} else {
				container.find('.status').html('');
				precent = 0;
				focusCourse.bind($('[name="course_id"] option:selected'))();
			}
			
		};

		const createSession = function(e) {

			if (!$(this).hasClass('to-login'))
				e.preventDefault();

			console.log('session')

		//	var course_type = $('[name="course_type:checked"]').val(),

			var course_type = $('[name="course_type"]:checked').val(),
				serializeArray = $formCheckout.serializeArray(),
				container = $formCheckout,
				user_id = $formCheckout.find('input[name="user_id"]').val(),
				log_in_url = $formCheckout.find('input[name="log_in_url"]').val();

			var onSuccess = function(data) {
				console.log('data', data)
				if(data.status) container.find('.status').html(data.status);
				if (data.update == true && data.response) {
					if(data.payment_method=='stripe') {
						stripe.redirectToCheckout({
							sessionId: data.response.checkoutSessionId,
						});
					}
					if(data.payment_method=='paypal') {
						if(data.response.link) {
							var redirect = data.response.link;
							window.location.href = redirect;
						}
					}
				}
			};


			if(serializeArray&&course_type) serializeArray.push({
				name: 'course_type',
				value: course_type
			});
				
			if(user_id==='0'&&log_in_url) {
				setCookie('return_to_plan','1',1);
				//window.location.href = log_in_url;
			}

			if($('body').hasClass('logged-in')) {
				var submitData = $formCheckout.serializeArray();
				mamamsAjax(submitData, onSuccess, container, 'POST');
			}

			else {
				if (container) container.addClass("loading");
				create_account(function(){
					var submitData = $formCheckout.serializeArray();
					mamamsAjax(submitData, onSuccess, container, 'POST');
				});


			}
			
		};

		const focusMethod = function(e) {
			e.preventDefault();

			$paymentMethod.val($(this).val());
			setCookie('current_method',$(this).val(),1);
			//
			setCookie('course_type',$('[name="course_type:checked"]').val(),1);
			

		};

		$('[name="course_type"]').on('change',function () {
			var val = $(this).val();
			setCookie('course_type', val, 1);

		})


		$toLogin.on('click',createSession);

		$checkoutButton.on('click',createSession);

		$formCourses.on('change',function(){

			setTimeout(function(){
				focusCourse.bind($('[name="course_id"] option:selected'))();
			}, 100)


		});


		$couponBtn.on('click',checkCoupon);
		$paymentFields.on('change',focusMethod);

		focusCourseValue = getCookie('focus_course');
		
		LastState();
		
		if(focusCourseValue){
			$formCourses.each(function (i,el) {
				if($(el).val()==focusCourseValue){
					$(el).change();
					el.checked = true;
					var lt=$(el).next('label').text();
					if(lt) $(el).closest('.plan__field').find('.select__title').text(lt);
					// $(el).closest('.plan__field').find('.field__radio')[0].checked = true;
					// setCookie('focus_course','');
				} 
			});
		}


		// $('[data-focus_course]').click(function(){
		// 	var val = $(this).attr('data-focus_course');
		// 	setCookie('current_method','one_course',1);
		// 	setCookie('focus_course', val);
		// })
		
	};

	$( document ).ready( function() {
		if ( typeof stripeCheckout !== 'undefined' ) {
			  checkoutObj = new Checkout( stripeCheckout );
		}
	} );

	/**
	 * updated checkout - 12/04/22
	 */



	var image = $('#select-1').find(':selected').attr('data-image');
	$('.select-right .course-image').attr('src', image);


	$('#select-1').change(function(){

		var id = $(this).val();

		var image = $(this).find(':selected').attr('data-image'),
			image_big = $(this).find(':selected').attr('data-image_big'),
			title = $(this).find(':selected').text(),
			cost = $('#course-' + id).find('.price').text(),
			tax = $('#course-' + id).find('.tax-text p').text();

		$('.select-right .course-image').attr('src', image);
		$('.price-courses').hide();
		$('#course-' + id).show();


		if ($('[name="course_type"][value="one_course"]').prop('checked') == true) {
			$('.chosen-item h5').text(title);
			$('.chosen-item .cost').text(cost);
			$('.chosen-item .info').text(tax);
			$('.img-big').attr('src', image_big);
		}


		//$('[name="course_type"]').prop("checked", '');

		//$('[name="course_type"][value="one_course"]').prop('checked', true);

		$('.checkout-wrap-1 .info-wrap').hide()
		$('.info-wrap-' + id).show()
	})


	$('#select-1').trigger('change');



	$('[name="course_type"]').change(function () {
		var val = $('[name="course_type"]:checked').val();
		$('.chosen-item .info2').remove();
		if (val == 'one_course') {
			$('#select-1').trigger('change');
			$('.checkout-wrap-1').addClass('is-selected');
		} else {
			var
				image_big = $('.image-premium').attr('src'),
				title = 'L’ABONNEMENT PREMIUM EN ILLIMITÉ',
				cost = $('.price-premium').text();
			//	bottom_price =  $('.checkout-wrap-2 .bottom_price').html();
			//	tax = $('#course-' + id).find('.tax-text p').text();
			$('.img-big').attr('src', image_big);
			$('.chosen-item h5').text(title);
			$('.chosen-item .cost').text(cost);
			$('.chosen-item .info').remove();

			$('.chosen-item .cost-wrap').append('<p class="info">*FACTURÉS <br>ANNUELLEMENT</p> ')
			$('.chosen-item .cost-wrap').append('<p class="info info2">(soit 180€ pour l`accès à toutes les formations pendant 12 mois)</p> ')


			$('.checkout-wrap-1').removeClass('is-selected')
			$('.checkout-wrap-2').addClass('is-selected')





		}
	});


	setTimeout(function(){
		$('[name="course_type"]:checked').trigger('change');
	}, 100)




	 function create_account(callback = '') {
		var name = $('[name="name"]').val(),
			last_name = $('[name="last_name"]').val(),
			email = $('[name="email"]').val(),
			password = $('[name="password"]').val(),
			password2 = $('[name="password2"]').val(),
			pregnant = $('[name="pregnant"]').val(),
			phone = $('[name="phone"]').val(),
			security = $('[name="security"]').val(),
			container = $('.form-wrap-checkout')

		$.ajax({
			url: window.global.url,
			type:'POST',
			data: {
				name:name,
				last_name:last_name,
				email:email,
				password:password,
				password2:password2,
				pregnant:pregnant,
				phone: phone,
				action:'ajax_registration',
				security: security
			},
			dataType: "json",
			beforeSend: function (response) {
				// Add loader
				if (container) container.addClass("loading");
			},
			complete: function (response, data) {
				//if (container) container.removeClass("loading");

				callback()
			},
			success:  function (data) {
				console.log(data)
				if (data.status) container.find(".status").html(data.status);
				$('[name="user_id"]').val(data.user_id);

				if (data.update) {





					$('li.disabled').removeClass('disabled');
					$('.content-item-2').hide();
					$('.content-item-3').show();
					$('.checkout-upd .checkout-menu li:nth-child(3)').addClass('is-active');


					$('._form_9 [name="firstname"]').val(name);
					$('._form_9 [name="lastname"]').val(last_name);
					$('._form_9 [name="email"]').val(email);

					$('._form_9 [name="field[6]"]').prop('checked',false)
					let radio = $('[name="pregnant"]:checked').val();

					if ('y' === radio)
						$('._form_9 [name="field[6]"][value="Oui"]').prop('checked',true)
					else
						$('._form_9 [name="field[6]"][value="Non"]').prop('checked',true)


					$("#_form_9_submit").click();


				} else {

					$('.content-item-2').show();
					$('.content-item-3').hide();
				}


			},
		})
	}



	var invalid, valid ;



	$(".checkout-menu > li:nth-child(2)").click(function(e){
		invalid = true;

		//if (!formIsValid())
			$(".checkout-menu > li:nth-child(3)").addClass('disabled')
	})


	function formIsValid() {
		return $(".ajax_checkout_form").valid() && $(".ajax_checkout_form").validate().pendingRequest === 0;
	}


	$('.submit_checkout').click(function(e){
		e.preventDefault()
		invalid = false;


		$('.form-wrap-checkout [name]').each(function(){
			var name = $(this).attr('name')
			valid = $(this).valid({async:true});


			if (valid == false)
				invalid = true
		})


		setTimeout(function(){

			if (!invalid && formIsValid()) {
				$('li.disabled').removeClass('disabled');
				$('.content-item-2').hide();
				$('.content-item-3').show();
				$('.checkout-upd .checkout-menu li:nth-child(3)').addClass('is-active');


				dataLayer.push({
					'checkoutStepNumber' : '3',
					'checkoutStepName' : 'payment',
					'event' : 'checkoutContinueStep2',
					'event-parameter' : get_course()
				});
			}

		}, 200)
	})










}( jQuery ) );

