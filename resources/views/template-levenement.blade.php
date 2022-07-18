{{--
    Template Name: Levenement
--}}

@extends('layouts.app')
@section('content')

    <style>
        header, .footer {
            display:none !important;
        }
    </style>

    @if (is_page(1715))
        <main data-lptitle="{{ get_the_title() }}" class="lp-wrapper lp-wrapper-01">
            @else
                <main data-lptitle="{{ get_the_title() }}" class="lp-wrapper">
                    @endif

                    <div class="lp-intro" style="background-image: url({{ $background_image->url }})">
                        <div class="container">
                            <div class="lp-intro-text">
                                <div class="lp-intro-logo"><img src="{{ $logo->url }}" alt=""></div>
                                <p>{{ $congrats_text }}</p>
                                <h1>{{ $title }}</h1>
                                <a href="{{ $button->url }}" class="double-btn double-btn_red" target="{{ $button->target }}">{{ $button->title }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="lp-content">
                        <div class="pos-element pos-element__pos-left">
                            <img class="bg-landing-1" src="<?php bloginfo('template_directory'); ?>/assets/img/bg-landing.png" alt="">
                            <img class="bg-landing-2"  src="<?php bloginfo('template_directory'); ?>/assets/img/bg-landing-01.png" alt="">
                        </div>
                        <div class="pos-element pos-element__pos-right">
                            <img class="bg-landing-1" src="<?php bloginfo('template_directory'); ?>/assets/img/bg-landing.png" alt="">
                            <img class="bg-landing-2" src="<?php bloginfo('template_directory'); ?>/assets/img/bg-landing-02.png" alt="">
                        </div>
                        <div class="container">
                            <div class="lp-content-top">{!! $text !!}</div>
                            <div class="lp-chat-wrapper">
                                <span id="trigger"></span>
                                <div class="lp-chat">
                                    <div class="lp-chat-header">
                                        <h2>{{ $title_1 }}</h2>
                                    </div>
                                    <div class="lp-chat-list">

                                        @foreach ($testimonial_texts as $row)
                                            <div class="lp-chat-item">
                                                <figure>
                                                    <img src="{{ $row->image->url }}" alt="">
                                                </figure>
                                                <blockquote>{{ $row->text }}</blockquote>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="lp-fixed-btn">
                                <a href="{{ $button->url }}" class="double-btn double-btn_red" target="{{ $button->target }}">{{ $button->title }}</a>
                            </div>
                            <div class="lp-form-wrapper">
                                <h2>{{ $title_2 }}</h2>
                                <p>{{ $text_1 }}</p>
                                <div class="lp-form-main">
                                    <div class="lp-form-bg"><img src="<?php bloginfo('template_directory'); ?>/assets/img/envelope.png" alt=""></div>
                                    <div class="lp-form-bg-01"><img src="<?php bloginfo('template_directory'); ?>/assets/img/envelope-01.png" alt=""></div>
                                    <div class="lp-form" id="form">
                                        <!-- <form action="#">
                                          <h3>On vous envoie le document sur votre adresse email </h3>
                                          <div class="lp-form-inner">
                                            <div class="lp-form-field">
                                              <input type="email" placeholder="Email">
                                            </div>
                                            <div class="lp-form-field-check">
                                              <input type="checkbox" id="lpCheck">
                                              <label for="lpCheck">Je suis enceinte</label>
                                            </div>
                                            <button type="submit" class="double-btn double-btn_red">recevoir</button>
                                          </div>
                                          <p>*pas besoin de créer un compte, on vous offre le contenu</p>
                                        </form> -->
                                        @if (is_page(1715))
                                            @php echo do_shortcode('[activecampaign form=5 css=0]') @endphp
                                        @else
                                            @php echo do_shortcode('[activecampaign form=3 css=0]') @endphp
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            @media (min-width: 1200px){
                                .lp-text-block:before {
                                    background-image: url({{ $image_on_the_right->url }}) !important;
                                }
                            }
                            .lp-text-block:after{
                                background-image: url({{ $image_on_the_left->url }}) !important;
                            }
                        </style>
                        <div class="lp-text-block">
                            <div class="container">
                                <div class="lp-text-content">
                                    <h2>{{ $title_3 }}</h2>
                                    <p>{{ $text_2 }}</p>
                                    <ul class="lp-listing">

                                        @foreach ($list as $row)
                                            <li>{{ $row->text }}</li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="lp-links-block">
                            <div class="container">
                                {!! $text_3 !!}
                                <ul>

                                    @foreach ($links as $row)
                                        <li>
                                            <a href="{{ $row->link->url }}" target="{{ $row->link->target }}">
                                                <figure>
                                                    <img src="{{ $row->image->url }}" alt="">
                                                </figure>
                                                <span>{{ $row->link->title }}</span>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                        <div class="lp-footer">
                            <p>Copyright <?= date('Y') ?></p>
                        </div>
                    </div>
                </main>
                <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>

@endsection