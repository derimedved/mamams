@php
$specialist = $specialist ?: get_the_ID();
@endphp
<div class="accordion accordion_desktop" data-action="ajax_template_part" data-target="specialists-pop-up" data-template="popup-specialist" data-id="{{ $specialist }}">
    <div class="accordion__item-main">
        <div class="specialists__wrap_photo">
            @if (has_post_thumbnail($specialist))
                <img src="<?= get_the_post_thumbnail_url($specialist,'200x200');?>" alt="specialist">
            @endif
        </div>
        <div class="accordion__item-main-description">
            <h5>{!! get_the_title($specialist) !!}</h5>
            <p>{{ get_field('position',$specialist) }}</p>
        </div>
        <div class="accordion__open-btn"><img src="<?= get_template_directory_uri();?>/assets/img/specialists-open.svg" alt=""></div>
    </div>
    @if ($about = get_field('about',$specialist))
    <div class="accordion__item-second">
        <p>{{ $about['label']?:'About specialist' }}</p>
        {!! $about['text']  !!}
    </div>
    @endif
</div>