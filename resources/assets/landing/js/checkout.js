( function( $, settings ) {
	'use strict';

	/**
	 * Checkout
	 *
	 * @param options
	 */
	const Checkout = function( options ) {
		
		const stripe = Stripe(options.publishable_key);

		const $formCheckout = $( '.ajax_checkout_form' ),
		
			$checkoutButton = $('.checkout_button'),

			$formCourses = $formCheckout.find('input[name="course_id"]'),

			$couponField = $formCheckout.find('input[name="coupon"]');
			
		var precent=0;

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
			console.log('price', price)
			console.log('precent', precent)
			if(price&&precent) {
				if(typeof price === 'number') {
					price = price - ((price/100)*precent);
				}
			}

			return price || false;
		}

		const focusCourse = function(e) {
			$formCheckout.addClass('loading');
			var price = $(this).data('price') || '';
			var currency = $(this).data('currency') || '';
			var image = $(this).data('image') || '';
			var description = $(this).data('description') || '';
			var container = $(this).closest('.plan__field');
			if(precent) {
				var newPrice = calcPrecent(Number(precent),price);
				if(newPrice) price = newPrice;
			}
			if(typeof price === 'number') price = currency+price;
			container.find('.plan__field_price').html(price);
			container.find('.plan__field_details-img').html(image);
			container.find('.plan__field_details-description').html(description);
			$formCheckout.removeClass('loading');
		};

		const checkCoupon = function(e) {
			var coupon = $couponField.val(),
				container = $formCheckout; 
			if(coupon) {
				var submitData = {
					action: 'ajax_check_coupon',
					coupon: coupon,
				},
				onSuccess = function(data) {
					console.log('data', data)
					if(data.status) container.find('.status').html(data.status);
					if (data.update == true && data.percent ) {
						precent = data.percent;
					} else {
						precent = 0;
					}

					focusCourse.bind($('input[name="course_id"]:checked'))();
				};
				mamamsAjax(submitData, onSuccess, container, 'POST');
			} else {
				container.find('.status').html('');
				precent = 0;
				focusCourse.bind($('input[name="course_id"]:checked'))();
			}
			
		};

		const createSession = function(e) {
			e.preventDefault();

			var container = $formCheckout;

			var submitData = $formCheckout.serialize(),
            onSuccess = function(data) {
				console.log('data', data)
				if(data.status) container.find('.status').html(data.status);
                if (data.update == true && data.response) {
					if(data.payment_method=='stripe') {
						stripe.redirectToCheckout({
							sessionId: data.response.checkoutSessionId,
						});
					}
					if(data.payment_method=='paypal') {
						if(data.response.links.approve) {
							var redirect = data.response.links.approve;
							window.location.href = redirect;
						}  
					}
                }
            };

            mamamsAjax(submitData, onSuccess, container, 'POST');

		};

		$checkoutButton.on('click',createSession);
		$formCourses.on('change',focusCourse);
		$couponField.on('input',checkCoupon);

		if($formCheckout.find('input[name="course_id"]:checked').length){
			var focusEl = $formCheckout.find('input[name="course_id"]:checked');
			$(focusEl[0]).change();
			focusEl.closest('.plan__field').find('.select__title').text(focusEl.next('label').text());
		}
		
	};

	$( document ).ready( function() {
		if ( typeof stripeCheckout !== 'undefined' ) {
			var checkoutObj = new Checkout( stripeCheckout );
		}
	} );
}( jQuery ) );

