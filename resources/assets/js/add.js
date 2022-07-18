jQuery(document).ready(function($) { 
	document.addEventListener('wpcf7mailsent', function(event ) {

		console.log(event)

		if ('2197' == event.detail.contactFormId) {
			//let select = $('#top_form [name="menu-934"]').find(":selected").text();
			let $selectIndex = $('#top_form [name="menu-934"]').find(":selected").index();
			$('#activecampaign_form [name="field[11]"] option')[$selectIndex].selected = true;
			
			let radio = $('#top_form [name="radio-594"]:checked').val();
			$('#activecampaign_form [name="field[6]"]').each(function(){
				let $this = $(this);
				if( $this.val() == radio ){
					$this.attr('checked',true);
				}
			});

			
			$('#activecampaign_form [name="firstname"]').val($('#top_form [name="text-216"]').val());
			$('#activecampaign_form [name="lastname"]').val($('#top_form [name="text-216"]').val());
			$('#activecampaign_form [name="email"]').val($('#top_form [name="email-991"]').val());
			//let radio = $('#top_form [name="radio-594"]:checked').val();

			$("#_form_7_submit").click();

			location.href = event.detail.apiResponse.data
		}
		if ('2198' == event.detail.contactFormId) {
			let $selectIndex = $('#bottom_form [name="menu-934"]').find(":selected").index();
			$('#activecampaign_form [name="field[11]"] option')[$selectIndex].selected = true;
			
			let radio = $('#bottom_form [name="radio-594"]:checked').val();
			$('#activecampaign_form [name="field[6]"]').each(function(){
				let $this = $(this);
				if( $this.val() == radio ){
					$this.attr('checked',true);
				}
			});

			
			$('#activecampaign_form [name="firstname"]').val($('#bottom_form [name="text-216"]').val());
			$('#activecampaign_form [name="lastname"]').val($('#bottom_form [name="text-216"]').val());
			$('#activecampaign_form [name="email"]').val($('#bottom_form [name="email-991"]').val());

			$("#_form_7_submit").click();

			location.href = event.detail.apiResponse.data
		}


		 
	}, false);
});


