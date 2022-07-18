
@php
$_fields = [
    'experts_title',
	'experts',
];
if($_fields)
foreach($_fields as $_field) {
    $$_field = get_field($_field,'options');
}

$posts_per_page = 4;
$post_type = 'specialists';
$part = "partials.content-$post_type-item";

$args = [
    'post_type'   => $post_type,
    'posts_per_page' => $posts_per_page,
    'paged' => 1
];

if($experts) {
    $args['post__in'] = $experts;

}


 // $args['orderby'] == 'menu_order';

//$args['orderby'] = 'post__in';

$loop = new WP_Query($args);
@endphp
@if ($loop->have_posts())
<section class="specialists section" data-aos="fade-up" id="experts">
    <div class="pos-element pos-element__pos-right">
        <img src="<?= get_template_directory_uri();?>/assets/img/specialists-pos-item.png" alt="">
    </div>
    <div class="container specialists__wrap">
        <h3>{{ $experts_title }}</h3>
        <div class="specialists__wrap-content output_wrap">
            @while ($loop->have_posts()) @php $loop->the_post() @endphp
                @include($part)
            @endwhile
            @php wp_reset_postdata(  ); @endphp
        </div>
        @if ($loop->max_num_pages>1)
            <a href="#" class="underline-btn load_more"  data-post_type="{{ $post_type }}" data-page="2" data-posts_per_page="{{ $posts_per_page }}" data-action="post_handler" data-part="{{ $part }}" data-post__in="{{ $experts ?: '' }}" data-btn_title="Voir tous les experts">{{ __('Voir tous les experts','sage') }}</a>
        @endif
    </div>
</section>
@endif