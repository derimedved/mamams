@php
$_fields = [
    'logo',
	'get_started_btn',
	'log_in_btn',
    'my_courses_btn'
];
if($_fields)
foreach($_fields as $_field) {
    $$_field = get_field($_field,'options');
}
@endphp
@if (!$without_header)
<header data-aos="fade-down">
    <div class="header container">
        @if ($logo)
        <a href="{{ home_url('/') }}" class="header__logo"><img height="50px" width="50px" src="{{ get_field('logo','options')['sizes']['100x100'] }}" alt="{{ $logo['alt'] }}"></a>
        @endif
        <div class="{{ is_user_logged_in()?'':'unauthorized' }}">

            @if (has_nav_menu('primary_navigation'))
            <ul class="menu">
                
                {!! wp_nav_menu([
                    'theme_location' => 'primary_navigation',
                    'menu_id'        => '',
                    'menu_class'      => '',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'items_wrap' => '%3$s',
                ]) !!}

                @if (!is_user_logged_in())
                    @if ($log_in_btn)
                    <li><a href="{{ $log_in_btn['url'] }}" class="header__link">{{ $log_in_btn['title'] }}</a></li>
                    @endif
                    
                    @if ($get_started_btn)
                    @php

                    $class = is_singular('lp_course') ? 'dt-only' : 'stiky-btn';

                    @endphp
                    <div class="{{ $class }}">
                        <button onclick="location.href='{{ $get_started_btn['url'] }}'" type="button" class="unauthorized__get-started red-btn">{{ $get_started_btn['title'] }}</button> 

                    </div>
                    @endif
                @else
                    @if ($my_courses_btn)
                    <li><a href="{{ $my_courses_btn['url'] }}" class="header__link">{{ $my_courses_btn['title'] }}</a></li>
                    @endif
                    <li><a href="{{ wp_logout_url( get_home_url() ) }}" class="header__link">Se déconnecter</a> </li>
                @endif

            </ul>
            @endif
            
        </div>
    </div>
</header>
@endif