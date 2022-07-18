
@php
$_fields = [
    'benefits_title',
	'benefits',
	'benefits_link',
];
if($_fields)
foreach($_fields as $_field) {
    $$_field = get_field($_field,'options');
}
@endphp
<section class="advantages section" data-aos="fade-up">
    <p class="advantages__mobile-title">{{ $benefits_title }}</p>
    <div class="container advantages__wrap">
        <div class="advantages__first-item">{{ $benefits_title }}</div>
        @if ($benefits)
        @foreach ($benefits as $benefit)
        <div class="advantages-item">
            <div class="advantages-item__img">
            @if ($benefit['icon'])
                <img src="{{ $benefit['icon']['sizes']['300x300'] }}" alt="{{ $benefit['alt'] }}">
            @endif
            </div>
            <p class="advantages-item__title">{{ $benefit['title'] }}</p>
            <p class="advantages-item__description">{{ $benefit['description'] }}</p>
        </div>
        @endforeach
        @endif
    </div>
    @if ($benefits_link)
        <a href="{{ $benefits_link['url'] }}" class="underline-btn">{{ $benefits_link['title'] }}</a>
    @endif
</section>