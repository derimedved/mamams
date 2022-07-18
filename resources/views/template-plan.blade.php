{{-- 
    Template Name: Choose plan Template 
--}}


<?php if ($_GET['create_hook']) {

  //  create_webhooks();

    $paypal = new PayPalCheckoutSdk();

    print_r($paypal->getAgreementState($_GET['token']));
}



?>



@php

if(function_exists('learn_press_get_current_user')) {
    $user = learn_press_get_current_user();
}
$currency = function_exists('learn_press_get_currency_symbol') ? learn_press_get_currency_symbol() : '';
$log_in_url = $acf_options->log_in_btn ? $acf_options->log_in_btn->url : get_home_url( null, 'login/' );
$courses = get_posts( array(
    'numberposts' => -1,
    'fields' => 'ids',
    'post_type'   => 'lp_course',
    'suppress_filters' => false,
    'meta_query' => array(
        '_lp_price' => array(
            'key'     => '_lp_price',
            'value'   => 0,
            'compare' => '>',
        ),
    ),
) ); wp_reset_postdata(  );
foreach($courses as $course_id){
    $course = learn_press_get_course( $course_id );
    $course_price = $course->get_price()?:0;
}
$is_premium = App::isPremium();


//if($precent = get_field('c_tax','options')) {
   // $precent = (int)$precent;
   // $tax_price = ($promium_price/100)*$precent;
   // $promium_price = $promium_price+$tax_price;
//}
$premium_price_per_month = get_field('premium_price_per_month','options');

@endphp

@extends('layouts.app')

@section('content')

    <main class="plan">
        <div class="container">
            <div class="plan__container">
                <h4 class="plan__title">{!! App::title() !!}</h4>

                <form action="#" id="checkout" class="plan__fields ajax_checkout_form">

                    @if (!isset($_GET['hide'])&&$_GET['hide']!='one_course')
                    <div class="plan__field">
                        {{-- <input class="field__radio" name="course_type" value="one_course" type="radio" id="one_course"> --}}
                        <label for="one_course">
                         {{--   <div class="plan__field_check"></div>--}}
                            <div class="plan__field_info">
                                <div class="plan__field_title">{{ $c_title_1 }}</div>
                                <div class="plan__field_amount">
                                    <div class="select" data-state="" id="course_one">
                                        <div class="select__title" data-default=" ">{{ $selector_placeholder }}</div>
                                        <div class="select__content">
                                            @foreach ($courses as $course_id)
                                            @php
                                            if( $user && $user->has_enrolled_course( $course_id ) ) continue;
                                            
                                            $course = learn_press_get_course( $course_id );
                                            $course_price = $course->get_price()?:__('Free','sage');
                                            @endphp
                                            <input id="course-{{ $course_id }}" class="select__input" type="radio" name="course_id" value="{{ $course_id }}" data-currency="{{ $currency }}" data-price="{!! $course_price !!}" data-tax="{{ get_field('c_tax',$course_id)?:'' }}" data-description="{{ get_the_excerpt($course_id) }}" data-image="{{ $course->get_image( '300x200' ) }}" />
                                            <label for="course-{{ $course_id }}" class="select__label">{{ get_the_title($course_id) }}</label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="plan__field_price-wrap">
                                        <div class="price-text-wrap">
                                            <div class="price-text tax-text" data-tax_text="{{ $c_tax_text?:'Tax' }}"></div>
                                            <div class="price-text coupone-text" data-promo_text="{{ $c_promo_code?:'Promo code' }}"></div>
                                        </div>
                                        <div class="old-price">
                                            
                                        </div>
                                        <div class="plan__field_price"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="plan__field_details">
                                <div class="plan__field_details-title">{{ $sub_title_1 ?: 'Course details' }}</div>
                                <div class="plan__field_details-info">
                                    <div class="plan__field_details-img"></div>
                                    <div class="plan__field_details-description"></div>
                                </div>
                            </div>

                            @if ($features_2)
                            <div class="plan__field_info-check">
                                <ul>
                                    @foreach ($features_2 as $feature)
                                    <li>
                                        <figure>
                                            @if ($feature->icon)
                                            <img src="{{ $feature->icon->sizes->{'100x100'} }}" alt="{{ $feature->icon->alt }}">
                                            @endif
                                        </figure>
                                        <h6>{{ $feature->title }}</h6>
                                        <p>{{ $feature->text }} </p>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="plan__field_promo">
                                <div class="plan__field_promo-titile">{{ $sub_title_2 ?: 'Promo Code' }}</div>
                               <div class="wrap-flex">
                                   <div class="plan__field_promo-input">
                                       <input type="text" name="coupon" placeholder="{{ $c_promo_code_placeholder ?: 'Apply Promo Code' }}">
                                   </div>
                                   <div class="plan__field_promo-button">
                                       <button type="button" class="red-btn apply-coupon">{{ $c_promo_code_btn }}</button>
                                   </div>
                               </div>
                            </div>
                            <div class="plan__field_paymethod">
                                <div class="plan__field_promo-titile">{{ $sub_title_3 }}</div>
                                <div class="plan__field_paymethod-item">
                                    <input class="field__radio" name="payment" value="stripe" type="radio" id="credit">
                                    <label for="credit">
                                        <div class="plan__field_check"></div>
                                        <img src="{{ get_template_directory_uri() }}/assets/img/credit-card.svg" alt="">
                                        <span>Credit/Debit</span>
                                    </label>
                                </div>

                                <?php //if ($_GET['hide'] !='one_course' ) { ?>

                                <?php //if ($_GET['tp'] || $_GET['hide'] !='one_course'  ) { ?>

                                <div class="plan__field_paymethod-item">
                                    <input class="field__radio" name="payment" value="paypal" type="radio" id="paypal">
                                    <label for="paypal">
                                        <div class="plan__field_check"></div>
                                        <img src="{{ get_template_directory_uri() }}/assets/img/PayPal.svg" alt="">
                                    </label>
                                </div>

                                <?php // } ?>

                                <?php// } ?>
                            </div>
                            <!-- <div class="plan__field_description">Consectetur adipiscing elit, sed do eiusmod tempor incididunt elit, sed do eiusmod tempor incidionsectetur</div> -->
                            <div class="plan__field_description">{!! $sub_text_1 !!}</div>
                            <div class="btn-wrap">
                                <button type="submit" class="red-btn checkout_button" data-course_type="one_course">{{ $submit_btn_2 }}</button>
                            </div>
                        </label>
                    </div>
                    @endif

                    <div class="plan__field">
                        {{-- <input class="field__radio" name="course_type" value="premium" type="radio" id="premium"> --}}
                        <label for="premium">
                           {{-- <div class="plan__field_check"></div>--}}
                            <div class="plan__field_info">
                                <div class="plan__field_title">{{ $c_title_2 }}</div>
                                <div class="plan__field_amount">
                                    <div class="select select-2">
                                        {!! $p_descr ?: 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt elit, sed do eiusmod tempor incidionsectetur' !!}
                                    </div>
                                    
                                    <div class="plan__field_price-wrap">
                                        {{-- new --}}
                                        @if ($premium_price_per_month)
                                        <div class="plan__field_price plan__field_price-2 premium_price_wrap">
                                            <div class="premium_price_cost" style="text-transform: initial;">
                                            {{ $premium_price_per_month }} {!! $currency !!}/mois*
                                            </div>
                                            <div class="premium_price_descr price-text">
                                            facturés annuellement
                                            </div>
                                        </div>
                                        @endif
                                        {{-- new end --}}
                                    </div>

                                </div>
                            </div>
                            @if ($features)
                            <div class="plan__field_benefit">
                                @foreach ($features as $feature)
                                <div class="plan__field_benefit-item">
                                    <div class="plan__field_benefit-item_image">
                                        @if ($feature->icon)
                                        <img src="{{ $feature->icon->sizes->{'100x100'} }}" alt="{{ $feature->icon->alt }}">
                                        @endif
                                    </div>
                                    <div class="plan__field_benefit-item_title">{{ $feature->title }}</div>
                                    <div class="plan__field_benefit-item_description">{{ $feature->text }}</div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <div class="plan__field_paymethod">
                                <div class="plan__field_promo-titile">{{ $sub_title_4 }}</div>
                                <div class="plan__field_paymethod-item">
                                    <input class="field__radio" name="payment" value="stripe" type="radio" id="credit1">
                                    <label for="credit1">
                                        <div class="plan__field_check"></div>
                                        <img src="{{ get_template_directory_uri() }}/assets/img/credit-card.svg" alt="">
                                        <span>Credit/Debit</span>
                                    </label>
                                </div>

                                <?php //if ($_GET['hide'] !='one_course' ) { ?>

                                <?php// if ($_GET['tp'] || $_GET['hide'] !='one_course'  ) { ?>

                                <div class="plan__field_paymethod-item">
                                    <input class="field__radio" name="payment" value="paypal" type="radio" id="paypal2">
                                    <label for="paypal2">
                                        <div class="plan__field_check"></div>
                                        <img src="{{ get_template_directory_uri() }}/assets/img/PayPal.svg" alt="">
                                    </label>
                                </div>
                                <?php //} ?>
                            </div>
                            <div class="plan__field_description">{!! $sub_text_2 !!}</div>
                            <div class="btn-wrap">
                                <button type="submit" class="red-btn checkout_button" data-course_type="premium">{{ $submit_btn_2 }}</button>
                            </div>
                        </label>
                    </div>

                    <div class="status"></div>
                   {{-- <button class="plan__fields_submit main-btn red-btn form-submit checkout_button">CONTINUE</button>--}}
                    <input type="hidden" name="action" value="ajax_checkout">
                    <input type="hidden" name="user_id" value="{{ get_current_user_id() }}">
                    <input type="hidden" name="log_in_url" value="{{ $log_in_url }}">
                    <input type="hidden" name="payment_method" value="">
                </form>

            </div>
            <div class="pos-element pos-element__pos-left"><img src="{{ get_template_directory_uri() }}/assets/img/main-description-left.png" alt=""></div>
            <div class="pos-element pos-element__pos-right"><img src="{{ get_template_directory_uri() }}/assets/img/main-description-right.png" alt=""></div>
        </div>
    </main>

@endsection
