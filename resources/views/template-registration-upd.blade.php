{{--
    Template Name: Registration UPD Template
--}}

@php



    if(!current_user_can( 'administrator' )&&is_user_logged_in()) {
    //    wp_redirect(get_home_url());
    }
@endphp

@extends('layouts.app')

@section('content')

    <div class="checkout-upd  user-cabinet">
        <div class="bg">
            <img src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-bg-1.svg" alt="">
            <img src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-bg-2.svg" alt="">
        </div>
        <form class="ajax_form"  >
            <div class="container">
                <div class="menu-wrap">
                    <div class="sticky" style="display: none">
                        <ul class="checkout-menu">
                            <li class=" is-active">
                                <a href="#"><span>1</span> <b>ÉTAPE 1</b></a>
                            </li>

                                <li class="disabled">
                                    <a href="#"><span>2</span> <b>ÉTAPE 2</b></a>
                                </li>

                            <li class="disabled" >
                                <a href="#"><span>3</span> <b>ÉTAPE 3</b></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="checkout-content">

                    <div style="display: block;" class="content-item content-item-1" >
                        <div class="wrap-img-form wrap-img-form-2" >
                            <figure>
                                <img class="img-big" src="{{ get_the_post_thumbnail_url() }}" alt="">
                            </figure>
                            <div class="right">


                                <div class="form-wrap form-wrap-payment">

                                    <h4 class="login__title">S’inscrire</h4>
                                    @if ($acf_options->social_login_page0)
                                        <div class="login__social">
                                            <div class="login__social__block login-social__block_google">
                                                <a href="{{ get_permalink($acf_options->social_login_page) }}?loginSocial=google" rel="nofollow" aria-label="Continue with <b>Google</b>" data-plugin="nsl" data-action="connect" data-redirect="{{ get_permalink(340) }}" data-provider="google">
                                                    <img src="{{ get_template_directory_uri() }}/assets/img/logo-google.svg" alt="">
                                                    <span>S’inscrire avec Google</span>
                                                </a>
                                            </div>
                                            <div class="login__social__block login-social__block_facebook">
                                                <a href="{{ get_permalink($acf_options->social_login_page) }}?loginSocial=facebook" data-plugin="nsl" data-action="connect" data-redirect="{{ get_permalink(340) }}" data-provider="facebook" data-popupwidth="475" data-popupheight="175">
                                                    <img src="{{ get_template_directory_uri() }}/assets/img/logo-facebook.svg" alt="">
                                                    <span>S’INSCRIRE AVEC FACEBOOK</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="login__separator signup__separator"><span>OU CRÉER MON COMPTE</span></div>


                                    <div class="login__fields  ">
                                        <div class="form-wrap form-wrap-checkout">
                                            <div class="input-wrap">
                                                <input type="email" data-msg-remote="Un compte existe déjà pour cette adresse email. Identifiez-vous ou utilisez un mot de passe oublié"
                                                       data-rule-remote="/wp-admin/admin-ajax.php?action=validate_email&r=<?= rand(0,99999) ?>" id="email" name="email" placeholder="Email" required>
                                            </div>
                                            <div class="input-wrap input-wrap-50">
                                                <input name="password" id="password" class="login__fields_password field__input" type="password" placeholder="Mot de passe" required>
                                            </div>

                                            <div class="input-wrap input-wrap-50">
                                                <input name="password2" data-rule-equalTo="#password" class="login__fields_password field__input" type="password" placeholder="Confirmez votre mot de passe" required>
                                            </div>


                                            <div class="login__field login__field_checkbox">
                                                <input class="login__fields_agree field__checkbox" name="newsletter" type="checkbox" id="agree">
                                                <label class="login__fields_agree-label field__label" for="agree">Je souhaite profiter pleinement de L’école des futures mamans et être alertée par e-mails des offres exclusives ou des nouveaux cours ! </label>
                                            </div>



                                            <div class="input-wrap input-wrap-50">
                                                <button type="" class="login__fields_submit main-btn red-btn btn-next-1">continuer</button>
                                            </div>

                                            <div class="input-wrap input-wrap-50">
                                                <div class="login__signin field__link">
                                                    Vous avez déjà en compte ? <a href="https://ecoledesfuturesmamans.fr/login/">Se connecter</a>
                                                </div>
                                            </div>


                                            <input type="hidden" name="action" value="ajax_registration">

                                            @php wp_nonce_field( 'ajax-registration-nonce', 'security' ); @endphp
                                            @if ($form_description)
                                                @php
                                                    if(str_contains($form_description, '<p>')) {
                                                        $form_description = str_replace('<p>','<p class="login__signin field__link text-bottom">',$form_description);
                                                    }
                                                @endphp
                                                {!! $form_description !!}
                                            @endif

                                        </div>
                                    </div>






                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: none;"  class="content-item content-item-2" >
                        <div class="wrap-img-form wrap-img-form-2" >
                            <figure>
                                <img class="img-big" src="{{ get_the_post_thumbnail_url() }}" alt="">
                            </figure>
                            <div class="right">
                                <div class="form-wrap form-wrap-payment">

                                    <h4 class="login__title">{!! App::title() !!}</h4>
                                    <div class="login__fields  ">

                                        <div class="form-wrap form-wrap-checkout">
                                            <div class="input-wrap">
                                                <input name="first_name"   class="login__fields_email field__input" type="text" placeholder="Prénom" required>
                                            </div>
                                            <div class="input-wrap">
                                                <input name="last_name"   class="login__fields_email field__input" type="text" placeholder="Nom de famille" required>
                                            </div>
                                            <div class="input-wrap input-wrap-50">
                                                <input name="age" class="login__fields_password field__input" type="number" placeholder="Votre âge" >
                                            </div>

                                            <div class="input-wrap input-wrap-50">
                                                <input name="phone" minlength="19" class="login__fields_password field__input tel-mask" type="text" placeholder="Numéro de téléphone" required>
                                            </div>

                                            <div class="status"></div>

                                            <div class="input-wrap input-wrap">
                                                <button type="submit" class="login__fields_submit main-btn red-btn form-submit">continuer</button>
                                            </div>
                                            
                                            {{--<div class="input-wrap input-wrap-50">
                                                <div class="login__signin field__link">
                                                    <a href="#" class="submit-registration">Répondre plus tard</a>
                                                </div>
                                            </div>--}}

                                            <input type="hidden" name="action" value="ajax_registration">

                                            @php wp_nonce_field( 'ajax-registration-nonce', 'security' ); @endphp
                                            @if ($form_description)
                                                @php
                                                    if(str_contains($form_description, '<p>')) {
                                                        $form_description = str_replace('<p>','<p class="login__signin field__link">',$form_description);
                                                    }
                                                @endphp
                                                {!! $form_description !!}
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div style="display: none;"  class="content-item content-item-3" >
                        <div class="wrap-img-form wrap-img-form-2" >
                            <figure>
                                <img class="img-big" src="{{ get_the_post_thumbnail_url() }}" alt="">
                            </figure>
                            <div class="right">
                                <div class="form-wrap form-wrap-radio">

                                    <h4 class="login__title">{!! App::title() !!}</h4>


                                </div>
                            </div>
                        </div>
                    </div>



                </div>


            </div>
        </form>
    </div>

    <div style="display:none !important;">

        <div class="_form_11"></div><script src="https://albelichenko39050.activehosted.com/f/embed.php?id=11" type="text/javascript" charset="utf-8"></script>

    </div>


@endsection


