
@php

$posts_per_page=3;
$post_type='lp_course';


$query = new WP_Query ( array(
	'posts_per_page' => $posts_per_page,
	'post_type' => $post_type,
	 
	'post_status' => 'future',
) );

@endphp
@if ($query->have_posts())
<section class="banner-block-wrap">
	<div class="all-courses__title">
		<h3>{{ $acf_options->coming_soon_title?:'BIENTÔT DISPONIBLE' }}</h3>
	</div>


	<div class="content">
		<div class="wrap">

			@while ($query->have_posts()) @php
				$query->the_post();
			 learn_press_get_template_part( 'content', 'course'  );
			@endphp

			@endwhile
			@php wp_reset_postdata(  ); @endphp

		</div>

	</div>

</section>
@endif