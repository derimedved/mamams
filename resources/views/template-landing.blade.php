{{-- 
    Template Name: Landing Template 
--}}

@extends('layouts.app')

@section('content')

    <header>
        <div class="header container">
            @if ($acf_options->logo)
        <div class="logo">
            <a href="{{ home_url('/') }}" class="header__logo"><img src="{{ $acf_options->logo->sizes->{'100x100'} }}" alt="{{ $acf_options->logo->alt }}"> <span>{{ $tagline }}</span></a>
        </div>
            @endif
            <div class="unauthorized">
                <p>{{ $timer_title }} :</p>
                @if ($timer_date)
                <div class="countdown" data-date="{!! explode(' ',$timer_date)[0] !!}" data-time="{!! explode(' ',$timer_date)[1] !!}">
                    <div class="day"><span class="num"></span><span class="word"></span></div>
                    <div class="hour"><span class="num"></span><span class="word"></span></div>
                    <div class="min"><span class="num"></span><span class="word"></span></div>
                    <div class="sec"><span class="num"></span><span class="word"></span></div>
                </div>
                @endif
            </div>
            <div class="btn-wrap">
                @if ($get_started_btn)
                    <a href="{{ $get_started_btn->url }}" class="red-btn fancybox">{{ $get_started_btn->title }}</a>
                @endif
            </div>
        </div>
    </header>

    <main>
   
        @if ($top_title||$descr||$video)
        <section class="main-banner section" >
            <div class="container main-banner__wrap">
                <div class="container banner-block__bg banner-block__first-banner">
                    <!-- <div class="banner-block__img"><img src="assets/img/main-page-banner1.png" alt=""></div> -->
                    <h1  data-aos="fade-up">{{ $top_title }}</h1>
                    <p class="top" data-aos-delay="500" data-aos="fade-up">{{ $descr }}</p>
                    <div class="banner-block__img">
                        @if ($video)
                        @php
                        
                        // Use preg_match to find iframe src.
                        preg_match('/src="(.+?)"/', $video, $matches);
                        $src = $matches[1];
                        @endphp
                        <div style="padding:38% 0 0 0;position:relative;" data-aos-delay="1000" data-aos="fade-up"><iframe
                                src="{{ $src }}"
                                style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0"
                                allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>
                        <script src="https://player.vimeo.com/api/player.js"></script>
                        @endif
                    </div>
                </div>

            </div>
            <a href="#" class="next-display"></a>
        </section>
        @endif


        @if ($title_1||$button||$acf_options->timer_date)
        <section class="discover-preview" data-aos="fade-up">
            <div class="container">
                <div class="text-wrap">
                    <h2>{{ $title_1 }}</h2>
                    <div class="btn-wrap">
                        @if ($button)
                        <a href="#discover" class="red-btn fancybox">{{ $button->title }}</a>
                        @endif
                    </div>
                </div>
                <div class="unauthorized">
                    <p>{{ $acf_options->timer_title }}</p>
                    @if ($acf_options->timer_date)
                    <div class="countdown1" data-date="{!! explode(' ',$acf_options->timer_date)[0] !!}" data-time="{!! explode(' ',$acf_options->timer_date)[1] !!}">
                        <div class="day"><span class="num"></span><span class="word"></span></div>
                        <div class="hour"><span class="num"></span><span class="word"></span></div>
                        <div class="min"><span class="num"></span><span class="word"></span></div>
                        <div class="sec"><span class="num"></span><span class="word"></span></div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif


        @if ($title_2||$reviews)
        <section class="our-customers" data-aos="fade-up">
            <div class="container">
                <h2>{{ $title_2 }} </h2>

                @if ($reviews)
                <div class="swiper-container our-customers-slider">
                    <div class="swiper-wrapper">

                        @foreach ($reviews as $row)
                        <div class="swiper-slide">
                            <div class="item">
                                <div class="text-wrap">
                                    @foreach ($row->review as $review)
                                    <div class="item">
                                        <p class="top">{{ $review->note }}</p>
                                        <blockquote>{{ $review->quote }}
                                            <b> {{ $review->date }}</b>
                                        </blockquote>
                                    </div>
                                    @endforeach
                                </div>
                                <figure>
                                    <img src="{{ get_template_directory_uri() }}/assets/img/img-2-1.png" alt="">
                                </figure>
                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>
                <div class="nav-wrap">
                    <div class="swiper-button-next swiper-button-next-1"></div>
                    <div class="swiper-button-prev swiper-button-prev-1"></div>
                </div>
                @endif

            </div>
        </section>
        @endif


        @if ($title_3||$button_2||$info)
        <section class="info" data-aos="fade-up">
            <div class="container">
                <h2>{{ $title_3 }}</h2>
                <div class="btn-wrap">
                    @if ($button_2)
                        <a href="#discover" class="btn-border fancybox">{{ $button_2->title }}</a>
                    @endif
                </div>
                @if ($info)
                @foreach ($info as $key => $row)
                <div class="item item-{{ ++$key }}">
                    <div class="bg">
                        <img src="{{ get_template_directory_uri() }}/assets/img/img-4-bg.png" alt="">
                    </div>
                    <div class="text-wrap">
                        <h6>{!! $row->text !!}</h6>
                    </div>
                    <figure>
                        @if ($row->img)
                            <img src="{{ $row->img->url }}" alt="{{ $row->alt }}">
                        @endif
                    </figure>
                </div>
                @endforeach
                @endif
                
            </div>
        </section>
        @endif


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
                        <a href="#discover" target="{{ $link_1->target }}" class="underline-btn fancybox">{{ $link_1->title }}</a>
                    @endif
                </div>
            </div>
            <div class="pos-element pos-element__pos-left"><img
                    src="{{ get_template_directory_uri() }}/assets/img/main-description-left.png" alt=""></div>
            <div class="pos-element pos-element__pos-right"><img
                    src="{{ get_template_directory_uri() }}/assets/img/main-description-right.png" alt=""></div>
        </section>
        @endif

        @include('partials.content-advantages')

        @if ($title_4||$topics)
        <section class="themes-covered" data-aos="fade-up">
            <div class="container">
                <h2>{{ $title_4 }}</h2>
                @if ($topics)
                <div class="swiper-container themes-covered-slider">
                    <div class="swiper-wrapper">
                        @foreach ($topics as $row)
                        <div class="swiper-slide">
                            <p><a href="{{ $row->link->url }}">{{ $row->text }}</a></p>
                        </div>
                        @endforeach

                    </div>

                </div>
                <div class="nav-wrap">
                    <div class="swiper-button-next swiper-button-next-2"></div>
                    <div class="swiper-button-prev swiper-button-prev-2"></div>
                </div>
                @endif
            </div>
        </section>
        @endif

        @if ($title_5||$form)
        <section class="access" data-aos="fade-up">
            <div class="container">
                <div class="text-wrap">
                    <h5>{!! $title_5 !!}
                    </h5>
                </div>
                @if ($form)
                <div class="form-wrap">
                    {!! do_shortcode("[contact-form-7 id='$form']") !!}
                </div>
                @endif
            </div>
        </section>
        @endif

    </main>

@endsection
