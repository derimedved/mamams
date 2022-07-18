{{-- 
    Template Name: lostpassword Template 
--}}

@php
if(!current_user_can( 'administrator' )&&is_user_logged_in()) {
    wp_redirect(get_home_url());
}
@endphp

@extends('layouts.app')

@section('content')

    <main class="reset">
        <div class="container">
            <div class="reset__container">
                <h4 class="reset__title">{!! App::title() !!}</h4>

                @if ($_GET['reset_key']&&$_GET['login'])
                    <form class="reset__fields ajax_form">
                        <div class="reset__field">
                            <input name="password" class="login__fields_password field__input" type="password" placeholder="NOUVEAU MOT DE PASSE" style="margin-bottom: 10px;">
                            <input name="password2" class="login__fields_password field__input" type="password" placeholder="CONFIRMATION MOT DE PASSE">
                        </div>
                        <div class="status"></div> 
                        <button type="submit" name="wp-submit" class="reset__fields_submit main-btn red-btn form-submit">{{ $button_text_2 }}</button>
                        <input type="hidden" name="action" value="ajax_reset">
                        <input type="hidden" name="reset_key" value="{{ $_GET['reset_key'] }}">
                        <input type="hidden" name="login" value="{{ $_GET['login'] }}">
                        @php wp_nonce_field( 'ajax-reset-nonce', 'security' ); @endphp
                    </form>
                @else
                    <form class="reset__fields ajax_form" name="lostpasswordform" id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
                        <div class="reset__field">
                            <input name="email" class="reset__fields_email field__input" type="email" placeholder="{{ $input_placeholder }}">
                        </div>
                        <div class="status"></div> 
                        <button type="submit" name="wp-submit" class="reset__fields_submit main-btn red-btn form-submit">{{ $button_text_2 }}</button>
                        <input type="hidden" name="action" value="ajax_reset">
                        @php wp_nonce_field( 'ajax-reset-nonce', 'security' ); @endphp
                    </form>
                    <div class="reset__succsess">
                        {{ $success_notice }}
                    </div>
                @endif
                
                @if ($button)
                <div class="reset__signin field__link">
                    {{ $button_text }} <a href="{{ $button->url }}">{{ $button->title }}</a>
                </div>
                @endif
            </div>
        </div>
    </main>

@endsection
