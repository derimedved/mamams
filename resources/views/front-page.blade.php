@extends('layouts.app')
@section('content')

    <main class="home-wrap">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Infant&display=swap" rel="stylesheet">

        <section class="home-top">
            <div class="right">
                <img src="{{ $banner_image->sizes->large }}" alt="">
                <div class="btn-wrap">
                    <a href="#video" class="fancybox-video btn-border">
                        <img src="{{ get_template_directory_uri() }}/assets/img/icon200-1.svg" alt="">
                        {{ $video_button->title }}</a>
                </div>
            </div>
            <div class="bg">
                <img src="{{ $background_image->url }}" alt="">
            </div>
            <div class="content-width">
                <div class="left">
                    <h1>{{ the_title() }}</h1>
                    <div class="content"> {!! the_content() !!}
                    </div>
                    <div class="form-wrap">
                        <form action="{{ get_permalink(276) }}" class="default-form">
                            <label for="email-top"></label>
                            <input type="email" name="email" id="email-top" placeholder="Adresse email" required>
                            <button class="btn-default">COMMENCER</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>


        <div id="video" class="popup-default popup-video" style="display: none;">
            <div class="main-wrap">
                {{--<div class="btn-wrap">
                    <a href="#"><img src="https://edfm1dev.wpengine.com/wp-content//themes/mamams/resources/assets/img/icon200-2.svg" alt=""></a>
                </div>--}}
                {{--<video  playsinline autoplay="false" controls class="video-file" id="video-file">
                    <source src="{{ $top_video->url }}" autostart="false">
                </video>--}}

                <iframe src="{{ $vimeo_video_top }}" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
            </div>
        </div>


        <section class="knowledge">
            <div class="content-width">
                <h2>ÉVALUEZ VOS CONNAISSANCES</h2>
                <div class="mob-block">
                    <div class="btn-wrap">
                        <a href="/quiz-1" class="red-btn">Commencez votre évaluation</a>
                    </div>
                    <p class="info">*sans engagement</p>
                </div>

                <div class="content">

                    <div class="sale">
                        <h6>NOUVEAU</h6>
                    </div>
                    <figure>
                        <img src="{{ get_template_directory_uri() }}/assets/img/img-600.png" alt="">
                    </figure>
                    <div class="text-wrap">
                        <h6>Les femmes préparées et informées <b>vivent mieux</b> leur accouchement et leur maternité, <b>c’est scientifiquement prouvé.</b></h6>
                        <ul>
                            <li>
                                <img src="{{ get_template_directory_uri() }}/assets/img/icon-601.svg" alt="">
                                <p>Mais <b>comment savoir</b> si vous avez les connaissances nécessaires et si vous êtes prête ?</p>
                            </li>
                            <li>
                                <img src="{{ get_template_directory_uri() }}/assets/img/icon-602.svg" alt="">
                                <p>Nos professionnels de santé et spécialistes de la maternité ont élaboré ce module <b>d’auto-évaluation qui vous aide</b> à détecter ce que vous devez encore apprendre afin d’être actrice de votre maternité, de rester sereine et confiante et de prévenir toutes les difficultés.</p>
                            </li>
                            <li class="dark">
                                <img src="{{ get_template_directory_uri() }}/assets/img/icon-603.svg" alt="">
                                <p>Ne ratez pas l’opportunité d’offrir à votre bébé la <b>meilleure version de sa maman.</b></p>
                            </li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="/quiz-1" class="red-btn">Commencez votre évaluation</a>
                        </div>
                        <p class="info">*sans engagement</p>
                    </div>
                </div>
            </div>
        </section>


        <section class="home-info">
            <div class="content-width">
                <h4>{!!  $title  !!}</h4>
                <div class="line"></div>
                <h3>{!! $title_2  !!}</h3>

                <div class="btn-wrap">
                    <a href="{{ $button_1->url }}" class="btn-white">{{ $button_1->title }}</a>
                    <p>OU</p>
                    <a href="{{ $button_2->url }}" class="btn-white">{{ $button_2->title }}</a>
                </div>
            </div>
        </section>

        <section class="video-bg-block">
            <div class="title">
                <div class="content-width">
                    <h3>{{ $block_3_title }}</h3>
                </div>
            </div>
            <div class="content">
                <div class="video-bg">
                    <video  playsinline autoplay="autoplay" muted loop class="video-file" id="video-bg-1">
                        <source src="{{ $course_video->url }}" autostart="false">
                    </video>
                </div>
                <div class="btn-wrap">
                    <a href="#"><img src="{{ get_template_directory_uri() }}/assets/img/icon200-4.svg" alt=""></a>
                </div>
                <div class="content-width">

                    <div class="text">
                        <h3>{{ $cat_title }}</h3>
                        <div class="line"></div>
                        <ul>
                            @foreach ($links as $link)
                            <li><a href="{{ $link->course_link->url }}" class="">{{ $link->course_link->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </section>

        <section class="main-banner section home-banner" data-aos="fade-up" {!! has_post_thumbnail() ? sprintf('style="background-image: url(%s);"', get_the_post_thumbnail_url( get_the_ID(), '1920x1024')) : '' !!}>
            <div class="container main-banner__wrap">
                <div class="main-banner-content">
                    <h3 data-aos-delay="1000" data-aos="fade-up">{!! $top_title ?: App::title() !!}</h3>
                    <p data-aos-delay="2600" data-aos="fade-up">{!! $text_4 !!}</p>


                </div>
                @if ($image_left)
                    <div class="pos-element pos-element__pos-left"><img
                            src="{{ $image_left->sizes->{'600x600'} }}" alt="{{ $image_left->alt }}"></div>
                @else
                    <div class="pos-element pos-element__pos-left"><img
                            src="{{ get_template_directory_uri() }}/assets/img/main_banner_maman1.png" alt=""></div>
                @endif
                @if ($image_right)
                    <div class="pos-element pos-element__pos-right dt-only"><img
                            src="{{ $image_right->sizes->{'600x600'} }}" alt="{{ $image_right->alt }}"></div>
                @else
                    <div class="pos-element pos-element__pos-right"><img
                            src="{{ get_template_directory_uri() }}/assets/img/main_banner_maman2.png" alt=""></div>
                @endif

                @if ($image_right_mob)
                    <div class="pos-element pos-element__pos-right mob-only"><img
                            src="{{ $image_right_mob->sizes->{'600x600'} }}" alt="{{ $image_right_mob->alt }}"></div>
                @endif


            </div>
        </section>



        <section class="video-bg-block">
            <div class="content">
                <div class="video-bg">
                    <video  playsinline autoplay="autoplay" muted loop class="video-file" id="video-bg-2">
                        <source src="{{ $course_video_2->url }}" autostart="false">
                    </video>
                </div>
                <div class="btn-wrap">
                    <a href="#"><img src="{{ get_template_directory_uri() }}/assets/img/icon200-4.svg" alt=""></a>
                </div>
                <div class="content-width">

                    <div class="text">
                        <h3>{{ $cat_title_2 }}</h3>
                        <div class="line"></div>
                        <ul>
                            @foreach ($links_2 as $link)
                                <li><a href="{{ $link->course_link->url }}" class="">{{ $link->course_link->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </section>





        @include('partials.content-specialists-upd', ['title' => $title_expert])

        <section class="item-3n-bg">
            <div class="bg">
                <img src="{{ get_template_directory_uri() }}/assets/img/img200-8.png" alt="">
            </div>
            <div class="content-width">
                <h3>{{ $title_doc }}</h3>
                <div class="content">
                    @foreach ($documents as $document)
                    <div class="item">
                        <figure>
                            <img src="{{ $document->image->sizes->large }}" alt="">
                        </figure>
                        <div class="text-wrap">
                            <div class="top">
                                <p class="label">{{ $document->title }}</p>
                                <h4>{!!  $document->label  !!}</h4>
                                <div class="line"></div>
                                <p class="text">{{ $document->excerpt_text }}</p>
                            </div>
                            <div class="btn-wrap">
                                <a href="{{ $document->button->url }}">{{ $document->button->title }}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        @if ($show_discount)
                @if(!App::isPremium())
                <section class="sale-block">
                    <div class="bg">
                        <img src="{{ get_template_directory_uri() }}/assets/img/img200-9.png" alt="">
                    </div>
                    <div class="content-width">
                        <div class="content">
                            <div class="left">
                                <h3>{{ $title_discount }}</h3>
                                <div class="line"></div>
                                <p>{{ $text_discount }}</p>
                                <div class="sale">
                                    <h6>{{ $sale }}</h6>
                                </div>
                            </div>
                            <figure>
                                <img src="{{ $img_discount->url }}" alt="">
                            </figure>
                        </div>
                    </div>
                </section>
                @endif
        @endif

        <section class="home-testimonials">
            <div class="content-width">
                <figure>
                    <img src="{{ $image_testim->sizes->large }}" alt="">
                </figure>
                <div class="slider-wrap">
                    <div class="owl-carousel home-testimonials-slider owl-theme">
                        @foreach ($testimonials as $testimonial)
                        <div class="slide">
                            <div class="top">
                                <div class="stars-wrap">
                                    <img src="{{ get_template_directory_uri() }}/assets/img/icon200-5.svg" alt="">
                                    <img src="{{ get_template_directory_uri() }}/assets/img/icon200-5.svg" alt="">
                                    <img src="{{ get_template_directory_uri() }}/assets/img/icon200-5.svg" alt="">
                                    <img src="{{ get_template_directory_uri() }}/assets/img/icon200-5.svg" alt="">
                                    <img src="{{ get_template_directory_uri() }}/assets/img/icon200-5.svg" alt="">
                                </div>
                                <p>{{ $testimonial->rate_text }}</p>
                            </div>
                            <div class="slide-content">
                                <blockquote>{{ $testimonial->quote }}</blockquote>
                            </div>
                            <div class="bottom">
                                <div class="user">
                                    <div class="img">
                                        <img src="{{ $testimonial->photo->url }}" alt="">

                                    </div>
                                    <div class="text">
                                        <p><b>{{ $testimonial->name }}</b></p>
                                        <p>{{ $testimonial->location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="owl-theme nav-wrap">
                        <div class="owl-controls">
                            <div id="customNav" class="owl-nav"></div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if ($show_logos)
        <section class="logo-block">
            <div class="content-width">
                <h3>{{ $logos_title }}</h3>
                <div class="content">
                    <div class="wrap">
                        @foreach ($logos_images as $logos_image)
                        <figure>
                            <img src="{{ $logos_image->sizes->large }}" alt="">
                        </figure>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif
       

        <div class="home-wrap">
            @include('partials.content-coming-soon')
        </div>

    </main>

@endsection