@extends('layouts.app')
@section('content')

    <main>

        <section class="main-banner section" data-aos="fade-up" {!! has_post_thumbnail() ? sprintf('style="background-image: url(%s);"', get_the_post_thumbnail_url( get_the_ID(), '1920x1024')) : '' !!}>
            <div class="container main-banner__wrap">
                <div class="main-banner-content">
                    <h1 data-aos-delay="2000" data-aos="fade-up">{!! $top_title ?: App::title() !!}</h1>
                    <p data-aos-delay="2600" data-aos="fade-up">{!! get_the_content() !!}</p>
                    @if ($link)
                    <a data-aos-delay="1000" data-aos="fade-up" class="main-btn red-btn" href="{{ $link->url }}">{{ $link->title }}</a>
                    @endif
                    
                </div>
                @if ($image_left)
                <div data-aos-delay="1000" data-aos-anchor-placement="top-top" data-aos-offset="0" data-aos="fade-up" class="pos-element pos-element__pos-left"><img
                        src="{{ $image_left->sizes->{'600x600'} }}" alt="{{ $image_left->alt }}"></div>
                @else
                <div data-aos-delay="1000" data-aos-anchor-placement="top-top" data-aos-offset="0" data-aos="fade-up" class="pos-element pos-element__pos-left"><img
                        src="{{ get_template_directory_uri() }}/assets/img/main_banner_maman1.png" alt=""></div>
                @endif
                @if ($image_right)
                <div data-aos-delay="1500" data-aos-anchor-placement="top-top" data-aos-offset="0" data-aos="fade-up" class="pos-element pos-element__pos-right dt-only"><img
                        src="{{ $image_right->sizes->{'600x600'} }}" alt="{{ $image_right->alt }}"></div>
                @else
                <div data-aos-delay="1500" data-aos-anchor-placement="top-top" data-aos-offset="0" data-aos="fade-up" class="pos-element pos-element__pos-right"><img
                        src="{{ get_template_directory_uri() }}/assets/img/main_banner_maman2.png" alt=""></div>
                @endif

                @if ($image_right_mob)
                <div data-aos-delay="1500" data-aos-anchor-placement="top-top" data-aos-offset="0" data-aos="fade-up" class="pos-element pos-element__pos-right mob-only"><img
                        src="{{ $image_right_mob->sizes->{'600x600'} }}" alt="{{ $image_right_mob->alt }}"></div>
                @endif
                
                
            </div>
        </section>

        @if ($title||$text||$link_1)
        <section class="description section" data-aos="fade-up">
            <div class="container">
                <div class="description__content">
                    <p class="description__title">{{ $title }}</p>
                    @php
                    $s=['<p>','<hr />','<hr/>','<hr>'];
                    $r=['<p class="description__text">','<span></span>','<span></span>','<span></span>'];
                    @endphp
                    {!! str_replace($s, $r, $text) !!}
                    @if ($link_1)
                        <a href="{{ $link_1->url }}" target="{{ $link_1->target }}" class="underline-btn">{{ $link_1->title }}</a>
                    @endif
                </div>
            </div>
            <div class="pos-element pos-element__pos-left"><img
                    src="{{ get_template_directory_uri() }}/assets/img/main-description-left.png" alt=""></div>
            <div class="pos-element pos-element__pos-right"><img
                    src="{{ get_template_directory_uri() }}/assets/img/main-description-right.png" alt=""></div>
        </section>
        @endif

        <section class="banner-block section" id="main-courses" data-aos="fade-up">
            @if ($course_video||$course_1||$course_img_1)
            <div class="container banner-block__bg banner-block__first-banner" data-aos="fade-up">
                <div class="banner-block__img">
                    @if ($course_1_type=='video'&&$course_video)
                        <video src="{{ $course_video->url }}" autoplay loop
                        muted></video>
                    @endif
                    @if ($course_1_type=='image'&&$course_img_1)
                        <img src="{{ $course_img_1->sizes->{'1600x700'} }}" alt="{{ $course_img_1->alt }}"> 
                    @endif
                </div>
                <div class="banner-block__content">
                    <h2><a href="{{ get_the_permalink($course_1) }}">{!! get_the_title($course_1) !!}</a></h2>
                    <p>{!! get_the_excerpt($course_1) !!}</p>
                    <div class="banner-block__wrap-btn">
                        <button class="double-btn double-btn_white open-view-course" data-course_url="{{ get_the_permalink($course_1) }}" data-action="ajax_template_part" data-target="quick-view" data-template="popup-course-preview" data-id="{{ $course_1 }}">DÈCOUVRIR</button>
                        @if ($acf_options->choose_plan_page)
                            <a href="{{ get_the_permalink($acf_options->choose_plan_page) }}" data-focus_course="{{ $course_1 }}" class="double-btn double-btn_red">suivre ce cours</a>
                        @endif
                    </div>
                    <a href="{{ get_the_permalink($course_1) }}" class="underline-btn underline-btn_white">APERÇU RAPIDE</a>
                </div>
            </div>
            @endif

            @if (($text_1
                ||$title_1
                ||$link_2)&&!$discount_1_hide)
            <div class="advertising advertising__first" data-aos="fade-up">
                <p class="advertising__tagline">{!! $text_1 !!}</p>
                <h3>{!! $title_1 !!}</h3>
                @if ($link_2)
                    <a href="{{ $link_2->url }}" class="advertising__btn fancybox" style="display:inline-block;">{{ $link_2->title }}</a>
                @endif
            </div>
            @endif

            @if ($course_img||$course_2||$course_video_2)
            <div class="container banner-block__bg banner-block__second-banner" data-aos="fade-up">
                <div class="banner-block__img">
                    @if ($course_2_type=='video'&&$course_video_2)
                        <video src="{{ $course_video_2->url }}" autoplay loop
                        muted></video>
                    @endif
                    @if ($course_2_type=='image'&&$course_img)
                        <img src="{{ $course_img->sizes->{'1600x700'} }}" alt="{{ $course_img->alt }}"> 
                    @endif
                </div>
                <div class="banner-block__content">
                    <h2><a href="{{ get_the_permalink($course_2) }}">{!! get_the_title($course_2) !!}</a></h2>
                    <p>{!! get_the_excerpt($course_2) !!}</p>
                    <div class="banner-block__wrap-btn">
                        <button class="double-btn double-btn_white open-view-course" data-course_url="{{ get_the_permalink($course_2) }}" data-action="ajax_template_part" data-target="quick-view" data-template="popup-course-preview" data-id="{{ $course_2 }}">DÈCOUVRIR</button>
                        @if ($acf_options->choose_plan_page)
                            <a href="{{ get_the_permalink($acf_options->choose_plan_page) }}" data-focus_course="{{ $course_2 }}" class="double-btn double-btn_red">suivre ce cours</a>
                        @endif
                    </div>
                    <a href="{{ get_the_permalink($course_2) }}" class="underline-btn underline-btn_white">APERÇU RAPIDE</a>
                </div>
            </div>
            @endif
            @if ($link_3)
                <a href="{{ $link_3->url }}" target="{{ $link_3->target }}" class="underline-btn">{{ $link_3->title }}</a>
            @endif
            
            @if (($title_2
                ||$subtitle
                ||$image
                ||$text_2
                ||$link_4)&&!$discount_2_hide)
            <div class="advertising advertising__second" data-aos="fade-up">
                <div class="container">
                    @if ($image)
                    <div class="advertising__second-img">
                        <div class="bigger-photo"><img
                                src="{{ $image->sizes->{'420x420'} }}" alt="{{ $image->alt }}">
                        </div>
                    </div>
                    @endif
                    
                    <div class="advertising__second-content">
                        <h3>{!! $title_2 !!}</h3>
                        <p class="advertising__description">{!! $text_2 !!}</p>
                        @if ($link_4)
                            <a href="{{ $link_4->url }}" class="advertising__btn fancybox" style="display:inline-block;">{{ $link_4->title }}</a>
                        @endif
                    </div>
                </div>
                <div class="pos-element pos-element__pos-right"><img
                        src="{{ get_template_directory_uri() }}/assets/img/advertising-right.png" alt=""></div>
            </div>
            @endif

        </section>


        @include('partials.content-advantages')


        @include('partials.content-specialists')


        @if (($text_3||$title_5||$link_7)&&!$discount_3_hide)
        <div class="advertising advertising__first" data-aos="fade-up">
            <p class="advertising__tagline">{!! $text_3 !!}</p>
            <h3>{!! $title_5 !!}</h3>
            @if ($link_7)
                <a href="{{ $link_7->url }}" class="advertising__btn fancybox" style="display:inline-block;">{{ $link_7->title }}</a>
            @endif
        </div>
        @endif

        @include('partials.content-coming-soon')

    </main>

@endsection