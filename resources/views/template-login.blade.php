{{-- 
    Template Name: Log in Template 
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
                @if ($_GET['c'])
                    <h4 class="login__title">Plus qu'une etape avant d'accéder a votre cours offert</h4>
                    <p class="login-subtitle">Vous avez déjà un compte?
                        Connectez-vous</p>
                @else
                    <h4 class="login__title">{!! App::title() !!}</h4>
                @endif




                    @if ($acf_options->social_login_page0)
                    <div class="login__social">
                        <div class="login__social__block login-social__block_google">
                            <a href="{{ get_permalink($acf_options->social_login_page) }}?loginSocial=google&c=<?= $_GET['c'] ?>" rel="nofollow" aria-label="Continue with <b>Google</b>" data-plugin="nsl" data-action="connect" data-provider="google">
                                <img src="{{ get_template_directory_uri() }}/assets/img/logo-google.svg" alt="">
                                <span>SE CONNECTER AVEC GOOGLE</span>
                            </a>
                        </div>
                        <div class="login__social__block login-social__block_facebook">
                            <a href="{{ get_permalink($acf_options->social_login_page) }}?loginSocial=facebook" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="facebook" data-popupwidth="475" data-popupheight="175">
                                <img src="{{ get_template_directory_uri() }}/assets/img/logo-facebook.svg" alt="">
                                <span>SE CONNECTER AVEC FACEBOOK</span>
                            </a>
                        </div>
                    </div>


                        <div class="login__separator">OU</div>

                    @endif

                <form class="login__fields ajax_form">
                    <div class="login__field">
                        <input name="email" value="{{ $_GET['email'] ?  $_GET['email'] :   ''  }}" class="login__fields_email field__input" type="text" placeholder="Adresse email">
                    </div>
                    <div class="login__field">
                        <input name="password" class="login__fields_password field__input" type="password" placeholder="Mot de passe">
                    </div>
                    <div class="status"></div> 
                    <button type="submit" class="login__fields_submit main-btn red-btn form-submit">SE CONNECTER</button>
                    <input type="hidden" name="action" value="ajax_login">
                    @if ($_GET['focus_course'])
                        <input type="hidden" name="focus_course" value="{{ $_GET['focus_course'] }}">
                    @endif
                    @php wp_nonce_field( 'ajax-login-nonce', 'security' ); @endphp

                    @if ($_GET['c'])
                        <input type="hidden" name="c" value="{{ $_GET['c'] }}">
                    @endif
                </form>
                <div asd class="login__signin field__link">
                    Vous n’avez pas de compte?

                    <a href="{{ $_GET['c'] ? add_query_arg( array('c' => $_GET['c'],'email' => $_GET['email']), get_permalink(2219) ) : $acf_options->get_started_btn->url }}">S’inscrire</a>
                </div>
                <div class="field__link">
                    <a href="{{ get_permalink(619) }}" class="linkto">Mot de passe oublié?</a>
                </div>
            </div>
        </div>
    </main>

@endsection
