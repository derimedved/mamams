<?php
/**
 * template name: Updated checkout
 */


?>


<?php

if ($_GET['pp_tt']) {
    $PayPalHandler = new App\PayPalHandler();


    //655565663D7627343
  //  print_r($PayPalHandler->getOrder('1BX60239648871628'));


$pp_client_id= get_field('paypal_client_id','options');
$pp_secret   = get_field('paypal_client_secret','options');


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.paypal.com/v1/oauth2/token');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $pp_client_id.':'.$pp_secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
    'Content-Type'=> 'application/x-www-form-urlencoded',
    'grant_type'=>'client_credentials',

)));

$res_authcode = curl_exec($ch);
    curl_close($ch);
echo '<pre>';
$access_token =  json_decode($res_authcode)->access_token;
   //print_r($access_token);


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.paypal.com/v1/checkout/orders/8AM73603MN3053607');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

  //  curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
       // 'Paypal-Partner-Attribution-Id: Beomi',
        'Content-Type: application/json',
        "Authorization: Bearer " . $access_token,

    ));

    $orders = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($orders);

    foreach ($result->purchase_units as $unit) {
        foreach ($unit->payments->captures as $capture) {
            echo $capture->status;
        }
    }





    die();
}

?>

<script>

    window.addEventListener( "pageshow", function ( event ) {
        var historyTraversal = event.persisted ||
            ( typeof window.performance != "undefined" &&
                window.performance.navigation.type === 2 );
        if ( historyTraversal ) {
            // Handle page restore.
            window.location.reload();
        }
    });
    
</script>

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

    $step = !is_user_logged_in() ? 3 : 2;


    $is_premium_page = get_the_id() == 519 ? 'premium-page' : '';

@endphp

@extends('layouts.app')

@section('content')


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <div class="checkout-upd <?= $is_premium_page ?>">
        <div class="bg">
            <img src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-bg-1.svg" alt="">
            <img src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-bg-2.svg" alt="">
        </div>
        <form action="#" class="ajax_checkout_form">
            <div class="container">
                <div class="menu-wrap">
                    <div class="sticky">
                        <ul class="checkout-menu">
                            <li class="{{ $_GET['l'] ? '' : 'is-active' }}">
                                <a href="#"><span>1</span> <b>OPTION</b></a>
                            </li>
                            @if (!is_user_logged_in())
                            <li>
                                <a href="#"><span>2</span> <b>CONNEXION</b></a>
                            </li>
                            @endif
                            <li class="{{ is_user_logged_in() ? "" : "disabled" }} {{ $_GET['l'] ? 'is-active' : '' }}">
                                <a href="#"><span>{{ is_user_logged_in() ? 2 : 3 }}</span> <b>PAIEMENT</b></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="checkout-content">
                    <div {!! $_GET['l'] ? 'style="display: none"' : ''  !!}  class="content-item content-item-1">
                        <div class="content-bg">

                            @if (!$is_premium_page)
                            <div class="checkout-wrap checkout-wrap-1 is-active is-selected">
                                <div class="title">
                                    <p class="radio">
                                        <label>
                                            <input type="radio" value="one_course" name="course_type" {{ $_COOKIE['course_type'] ? checked('one_course', $_COOKIE['course_type']) : 'checked'  }} >
                                            <span></span>
                                            SOUSCRIRE À LA FORMATION
                                        </label>
                                    </p>
                                </div>
                                <div class="select-wrap">
                                    <div class="select-left">
                                        <div class="select-block ">
                                            <label class="form-label" for="select-1"></label>
                                            <select id="select-1" name="course_id">
                                                @foreach ($courses as $course_id)
                                                    @php
                                                        $i++;
                                                     //   if( $user && $user->has_enrolled_course( $course_id ) ) continue;

                                                        $course = learn_press_get_course( $course_id );
                                                        $course_price = $course->get_price()?:__('Free','sage');
                                                    @endphp
                                                    <option
                                                            data-currency="{{ $currency }}"
                                                            data-price="{!! $course_price !!}"
                                                            data-tax="{{ get_field('c_tax',$course_id)?:'' }}"
                                                            data-description="{{ get_the_excerpt($course_id) }}"
                                                            data-image_img="{{ $course->get_image( '300x200' ) }}"
                                                            data-image_big="{{ get_the_post_thumbnail_url($course_id, 'full') }}"
                                                            data-image="{{ get_the_post_thumbnail_url($course_id, 'medium') }}"
                                                            {{ $_COOKIE['focus_course'] ? selected($_COOKIE['focus_course'], $course_id) : selected(1, $i) }}

                                                            value="{{ $course_id }}">{{ get_the_title($course_id) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @php $i = 0; @endphp

                                        @foreach ($courses as $course_id)
                                            @php
                                                $i++;
                                                if( $user && $user->has_enrolled_course( $course_id ) ) continue;

                                                $course = learn_press_get_course( $course_id );
                                                $course_price = $course->get_price()?:__('Free','sage');
                                            @endphp


                                            <div style="display: {{ $i==1 ? '' : 'none'  }}"  class="price-courses price-wrap" id="course-{{ $course_id }}">
                                                <p class="price">€{{ $course_price*1.2 }}</p>

                                                @if ($course->get_origin_price() > $course_price)
                                                    <p class="old-price">€{{ $course->get_origin_price()*1.2  }}</p>
                                                @endif
                                                <div class="bottom-price tax-text"><p>*Dont la TVA de <br> 20% (€{{ round($course_price*1.2 - $course_price) }})</p></div>
                                            </div>

                                        @endforeach



                                    </div>
                                    <div class="select-right">
                                        <figure>
                                            <img class="course-image" src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-img-1-1.jpg" alt="">
                                        </figure>
                                    </div>
                                </div>



                                @foreach ($courses as $course_id)
                                   <div class="info-wrap info-wrap-{{ $course_id }}" style="display: none">

                                        @php
                                            $list = get_field('list', $course_id);
                                            $blocks = get_field('text_blocks', $course_id);
                                        @endphp


                                        {!! $list !!}

                                       <br>
                                        <div class="item-wrap">
                                            @foreach ($blocks as $block)
                                                <div class="item">
                                                    <p>{{ $block['text'] }}</p>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="btn-bottom-wrap">
                                            <a href="#">Choisi</a>
                                            <div class="mob-link">
                                                <a href="#" class="add-more btn">MONTRER PLUS</a>
                                                <a href="#" class="hide-more btn">Montrer moins</a>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach



                            </div>
                            @endif

                            <div class="checkout-wrap checkout-wrap-2">
                                <div class="label">
                                    <p>POPULAIRE</p>
                                </div>
                                <div class="title">
                                    <p class="radio">
                                        <label>
                                            <input type="radio" value="premium" name="course_type" {{ $_COOKIE['course_type'] == 'premium' ? 'checked' : ($is_premium_page ? 'checked' : '') }}>
                                            <span></span>
                                            L’ABONNEMENT PREMIUM EN ILLIMITÉ
                                        </label>
                                    </p>
                                </div>
                                <div class="select-wrap select-abonement">

                                    @foreach ($acf_options->premium as $premium)

                                        <label class="{{ $premium->months == 12 ? 'is-active' : '' }}">
                                            <p class="title" data-full="{!! $premium->title_full !!}">{!! $premium->title !!}</p>
                                            <span data-text1="{!! $premium->text !!}" data-text2="{!! $premium->text_2 !!}">{!! $premium->text !!} {!! $premium->text_2 !!}</span>
                                            @if ($premium->bage)
                                                <span class="bage">{!! $premium->bage !!}</span>
                                            @endif
                                            <input {{ $premium->months == 12 ? 'checked' : '' }} type="radio" name="premium-type" data-price="{{ $premium->price  }}" value="{{ $premium->months }}">
                                        </label>

                                    @endforeach

                                </div>
                                <div class="info-wrap">

                                    @php
                                        $list = get_field('list', get_field('choose_plan_page','options'));
                                        $blocks = get_field('text_blocks', get_field('choose_plan_page','options'));
                                    @endphp


                                    {!! $list !!}


                                    <div class="item-wrap">
                                        @foreach ($blocks as $block)
                                            <div class="item">
                                                <p>{{ $block['text'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="btn-bottom-wrap">
                                        <a href="#">Choisir</a>
                                        <div class="mob-link">
                                            <a href="#" class="add-more btn">MONTRER PLUS</a>
                                            <a href="#" class="hide-more btn">Montrer moins</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="total-btn">
                            <a href="#" data-step="{{ !is_user_logged_in() ? 2 : 3  }}" class="btn-next btn-next-{{ !is_user_logged_in() ? 1 : 1  }}">Continuer</a>
                        </div>
                    </div>

                    @if (!is_user_logged_in())
                    <div class="content-item content-item-2" style="display: none">
                        <div class="wrap-img-form wrap-img-form-1 ">
                            <figure>
                                <img class="img-big" src=" " alt="">
                            </figure>
                            <div class="right">
                                <div class="block-bg chosen-item">
                                    <h5></h5>
                                    <div class="cost-wrap">
                                        <p class="cost"></p>
                                        <p class="info"></p>
                                    </div>
                                </div>

                                <div class="form-wrap form-wrap-checkout">

                                    @php wp_nonce_field( 'ajax-registration-nonce', 'security' ); @endphp
                                    <div class="input-wrap input-wrap-50">
                                        <label for="name"></label>
                                        <input type="text" id="name" name="name" placeholder="Nom" required>
                                    </div>
                                    <div class="input-wrap input-wrap-50">
                                        <label for="last-name"></label>
                                        <input type="text" id="last-name" name="last_name" placeholder="Prenom" required>
                                    </div>
                                    <div class="input-wrap input-wrap-50">
                                        <label for="email"></label>
                                        <input type="email" data-msg-remote="Un compte existe déjà pour cette adresse email. Identifiez-vous ou utilisez un mot de passe oublié"
                                               data-rule-remote="/wp-admin/admin-ajax.php?action=validate_email&r=<?= rand(0,99999) ?>" id="email" name="email" placeholder="Email" required>
                                    </div>
                                    <div class="input-wrap input-wrap-50">
                                        <label for="phone"></label>
                                        <input type="tel"  id="phone" name="phone" data-rule-number="true" placeholder="Numéro de téléphone" >
                                    </div>
                                    <div class="input-wrap input-wrap-50">
                                        <label for="password"></label>
                                        <input minlength="8" type="password" id="password" name="password" placeholder="Mot de passe" required>
                                    </div>
                                    <div class="input-wrap input-wrap-50">
                                        <label for="password2"></label>
                                        <input type="password" id="password2" name="password2"
                                               placeholder="Confirmation de mot de passe" required
                                               data-rule-equalTo="#password">
                                    </div>
                                    <div class="input-wrap-radio">
                                        <p>Je suis enceinte:</p>
                                        <p class="radio-default">
                                            <label>
                                                <input type="radio" value="y" name="pregnant" checked>
                                                <span></span>
                                                oui
                                            </label>
                                        </p>
                                        <p class="radio-default">
                                            <label>
                                                <input type="radio" value="n" name="pregnant">
                                                <span></span>
                                                non
                                            </label>
                                        </p>
                                    </div>
                                    <div class="input-wrap-submit">
                                        <div class="btn-wrap">
                                            <a href="#" class="btn-next btn-next-2_0 submit_checkout">continuer</a>
                                        </div>
                                        <div class="text-wrap">
                                            <p> Vous avez déjà un compte? <a class="to-login" href="{{ get_permalink(274) }}?return=1">Se connecter</a></p>
                                        </div>
                                    </div>

                                    <div class="status">

                                    </div>


                                </div>


                            </div>
                        </div>
                    </div>
                    @endif

                    <div {!!  $_GET['l'] ? '' : 'style="display: none"'  !!} class="content-item content-item-{{ $step }}" >
                        <div class="wrap-img-form wrap-img-form-2" >
                            <figure>
                                <img class="img-big" src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-img-2.jpg" alt="">
                            </figure>
                            <div class="right">
                                <div class="block-bg chosen-item">
                                    <h5></h5>
                                    <div class="cost-wrap">
                                        <p class="cost"></p>
                                        <p class="info"></p>
                                    </div>
                                </div>

                                <div class="form-wrap form-wrap-payment">
                                    <div class="input-wrap input-wrap-label input-wrap-code">
                                        <label for="code">code promo</label>
                                        <input type="text" id="code" name="coupon" placeholder="Votre Code Promo">
                                        <button class="apply-coupon" type="submit">Appliquer</button>
                                        <div class="status"></div>
                                    </div>

                                    <div class="input-wrap-radio">
                                        <p>MODE DE PAIEMENT</p>
                                        <p class="radio-default">
                                            <label>
                                                <input type="radio" value="stripe" name="payment" checked>
                                                <span></span>
                                                <img src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-icon-3.svg" alt="">
                                                Credit/Debit
                                            </label>
                                        </p>
                                        <p class="radio-default">
                                            <label>
                                                <input type="radio" value="paypal" name="payment">
                                                <span></span>
                                                <img src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-icon-4.svg" alt="">
                                            </label>
                                        </p>
                                    </div>
                                    <div class="input-wrap input-wrap-text">
                                        <?php the_content() ?>
                                    </div>
                                    <div class="input-wrap-submit">
                                        <div class="btn-wrap">
                                            <button class="submit_checkout_payment checkout_button" type="submit">procéder au paiement</button>
                                        </div>
                                        <div class="text-wrap">
                                            <a href="#"><img src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-icon-5.svg" alt="">Achat
                                                securisé</a>
                                        </div>
                                    </div>

                                    <input type="hidden" name="user_id" value="{{ is_user_logged_in() ? get_current_user_id() : 0 }}">
                                    <input type="hidden" name="log_in_url" value="{{ get_permalink(274) }}">
                                    <input type="hidden" name="action" value="ajax_checkout">
                                    <input type="hidden" name="payment_method" value="stripe">
                                    <div class="status"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </form>
    </div>

    <div style="display:none">
        <div class="_form_9"></div><script src="https://albelichenko39050.activehosted.com/f/embed.php?id=9" type="text/javascript" charset="utf-8"></script>
    </div>



@endsection