{{-- 
    Template Name: Registration Template 
--}}

@php



   if(!current_user_can( 'administrator' )&&is_user_logged_in()) {
       wp_redirect(get_home_url());
   }
@endphp

@extends('layouts.app')

@section('content')

    <main class="login">
        <div class="container">
            <div class="login__container">
                <h4 class="login__title">{!! App::title() !!}</h4>
                @if ($acf_options->social_login_page)
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
                <div class="login__separator signup__separator">OU CRÉER MON COMPTE</div>
                <form class="login__fields ajax_form">
                    <div class="login__field">
                        <input name="email" value="{{ $_GET['email'] }}" class="login__fields_email field__input" type="email" placeholder="Adresse email" required>
                    </div>
                    <div class="login__field">
                        <input name="password" class="login__fields_password field__input" type="password" placeholder="Mot de passe" required>
                    </div>

                    <div class="login__field">
                        <input name="password2" class="login__fields_password field__input" type="password" placeholder="Confirmez votre mot de passe" required>
                    </div>


                    <div class="login__field login__field_checkbox">
                        <input class="login__fields_agree field__checkbox" name="newsletter" type="checkbox" id="agree">
                        <label class="login__fields_agree-label field__label" for="agree">Je souhaite profiter pleinement l’école des futures mamans et recevoir des e-mails comportant des offres exclusives, des notifications de lancement des nouveaux cours!</label>
                    </div>
                    <div class="status"></div> 
                    <button type="submit" class="login__fields_submit main-btn red-btn form-submit">S’INSCRIRE</button>
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
                    {{-- <p class="login__signin field__link">En vous inscrivant, vous acceptez nos <a href="https://www.udemy.com/terms/">conditions générales</a> d'utilisation et notre <a href="https://www.udemy.com/terms/privacy/">politique de confidentialité</a></p> --}}
                </form>
                <div class="login__signin field__link">
                    Vous avez déjà un compte? <a href="{{ $acf_options->log_in_btn->url }}">Se connecter</a>
                </div>
            </div>
        </div>
    </main>

@endsection
