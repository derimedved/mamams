var quizSlider

jQuery(document).ready(function($) {



	$('.quiz_result').on('click', function(e){
		e.preventDefault();

		$('.lds-ellipsis').show()
		var quiz_id = $(this).attr('data-quiz_id')
		var quiz_title = $(this).attr('data-quiz_title')
		var quiz_rezult = $(this).attr('data-quiz_rezult')

		let radioboxes = $('.questions-wrap input[type="radio"]:checked');
		let result = 0;
		if (radioboxes) {
			for (let i = 0; i < radioboxes.length; i++) {
				result += parseInt(radioboxes[i].value);
			}
		}


		var answers = {}
		$('.form-quiz input').each(function(){
			var id = $(this).attr('id')
			answers[id] = $(this).prop('checked')
		})


		//$('#customNav').hide()



		let data = {
			'action': 'my_quiz_result',
			'result': result,
			'quiz_id' : quiz_id,
			'quiz_title' : quiz_title,
			'quiz_rezult' : quiz_rezult,
			'data' : answers
		}

		$.ajax({
			url: '/wp-admin/admin-ajax.php',
			data: data,
			type: 'POST',
			success:function(data){
				if (data) {
					console.log(data)

					

					window.location.href = data;
				}
			}
		});
	});

	$('#questions_30').on('click', function(e){

		let data = {
			'action': 'questions_30',
			'current_post_url': document.URL
		}

		$.ajax({
			url: '/wp-admin/admin-ajax.php',
			data: data,
			type: 'POST',
			success:function(data){
				if (data) {
					
				}
			}
		});

	});

	$('#analyze .btn-wrap a').on('click', function(e){

		let data = {
			'action': 'we_analyze',
			'analyze_button_text': $(this).text(),
			'quiz_result_url': $(this).attr('href')
		}

		$.ajax({
			url: '/wp-admin/admin-ajax.php',
			data: data,
			type: 'POST',
			success:function(data){
				if (data) {
					
				}
			}
		});

	});



	/*----------QUIZ-PAGE-------------*/

	$(document).on('click', '.quiz-steps .info .title', function (e){
		e.preventDefault();
		$('.quiz-steps .info').toggleClass('is-open');
		if($('.quiz-steps .info').hasClass('is-open')){
			$('.quiz-steps .info .text').slideDown();
		}else{
			$('.quiz-steps .info .text').slideUp();
		}
		setTimeout(function() {
			$('.quiz-step-slider').trigger('refresh.owl.carousel');
		}, 500);
	});
	$(document).on('click', '.quiz-steps .default-item input', function (e){
		$(this).closest('.owl-item').addClass('is-select').find('.info').slideDown();



		setTimeout(function() {
			$('.quiz-step-slider').trigger('refresh.owl.carousel');
			$('.quiz-steps').addClass('is-done');
		}, 500);
	});



	quizSlider = $('.quiz-step-slider').owlCarousel({
		items:1,
		nav:true,
		navContainer: '#customNav',
		dotsContainer: '#customDots',
		touchDrag  : false,
		mouseDrag  : false,
		autoHeight:true,
	});


	quizSlider.on('changed.owl.carousel', function(e) {
		$('.quiz-steps').removeClass('is-done');
		$('.quiz-steps .owl-dots .active').prevAll().addClass('is-click');
		//$('.quiz-steps .info').slideUp();
		$('.quiz-steps .owl-dots .active').addClass('is-click');
		setTimeout(function() {
			if($('.quiz-steps .owl-item.active').hasClass('is-select')){
				$('.quiz-steps').addClass('is-done');
			}
		}, 500);

		var current = e.item.index + 1;
		var total = e.item.count;
		if(current === total){
			$('.quiz-wrap').addClass('is-send');
		}else{
			$('.quiz-wrap').removeClass('is-send');
		}
		$('.quiz-steps .bg').removeClass('girl-1 girl-2 girl-3 girl-4 girl-5 girl-6 girl-7 girl-8 girl-9 girl-10 girl-11 girl-12 girl-13 girl-14 girl-15');
		$('.quiz-steps .bg').addClass("girl-"+current);
	});

	$(document).on('click', '.last-info .info .btn-wrap a', function (e){
		//e.preventDefault();
		$('.quiz-wrap').addClass('is-next');
		setTimeout(function() {
			var el = $('.tab-menu li:first-child');
			//location.href = "/quiz-3/";
		}, 2000);
	});

	$(document).on('click', '#show-analyze', function (e){
		$('.login-form').hide();
		$('#analyze').show();
	});

	$(document).on('click', '.scroll-block', function (e) {
		e.preventDefault();
		var id  = $(this).attr('href'),
			top = $(id).offset().top;
		$('body,html').animate({scrollTop: top}, 1000);
	});

	$(".fancybox1").fancybox({
		touch:false,
		autoFocus:false,

	});
	/*---------END-QUIZ-PAGE-------------*/



	if ($('.quiz-default-form').length)
		$('.quiz-default-form #tel').mask("+00 00 00 00 00 00 00 00", {});


	if ($('.form-quiz').length) {

		$.cookie.json = true;
		var answersCookie = $.cookie('an') ?? {}

		if (!$('.form-quiz').hasClass('passed'))

			if (Object.keys(answersCookie).length !== 0 )  {
			var pages = []
			$.each(answersCookie, function(id, value){
				$('#' + id).prop('checked', true)
				$('#' + id).closest('.owl-item').addClass('is-select').find('.info').slideDown();
				setTimeout(function() {
					$('.quiz-step-slider').trigger('refresh.owl.carousel');
					$('.quiz-steps').addClass('is-done');
				}, 500);



				pages.push(parseInt(id.slice(1)));


			})



			var page = Math.max(...pages)

			console.log(page)

			p = page.toString()

			console.log(p)

			if (page > 99) {

				page = p.slice(0,2)
			} else {

				page = p.charAt(0)
			}

			//page = parseInt(page.charAt(1))


			quizSlider.trigger("to.owl.carousel", [page - 1, 1])
		}


		$('.form-quiz input').change(function(){
			var id = $(this).attr('id')
			answersCookie[id] = $(this).prop('checked')

			$.cookie('an', answersCookie);

		})


		console.log(answersCookie)

	}


});
