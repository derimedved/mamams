{{--
Template Name: After quiz
--}}


@php

if (is_user_logged_in()) {

  $page = $_GET['quiz_result_id'] ? $_GET['quiz_result_id'] : 2894;

  wp_redirect(get_permalink( $page ));
}
@endphp


@extends('layouts.app')

@section('content')

<div class="quiz-wrap">
  <div class="no-login-form">
    <div class="bg">
      @php the_post_thumbnail('full') @endphp

      @if($background_mobile)
      @php echo wp_get_attachment_image($background_mobile->ID, 'full', false, array('class' => 'bg-mob')) @endphp
      @endif

    </div>
    <div class="content-width">
      <div class="content">

        @if($image)
        <figure>
          @php echo wp_get_attachment_image($image->ID, 'full') @endphp
        </figure>
        @endif

        <h5 class="title">{!!  get_the_title()  !!}</h5>
        
        @php the_content() @endphp

        <form action="#" class="quiz-default-form ajax_form registration-quiz">
{{--          <div class="input-wrap input-wrap-50">--}}
{{--            <label for="lastName"></label>--}}
{{--            <input type="text" name="lastName" id="lastName" placeholder="Nom" required>--}}
{{--          </div>--}}
{{--          <div class="input-wrap input-wrap-50">--}}
{{--            <label for="firstName"></label>--}}
{{--            <input type="text" name="firstName" id="firstName" placeholder="Prénom" required>--}}
{{--          </div>--}}
          <div class="input-wrap">
            <label for="email"></label>

            <input type="email" data-msg-remote="Un compte existe déjà pour cette adresse email. Identifiez-vous ou utilisez un mot de passe oublié"
            data-rule-remote="/wp-admin/admin-ajax.php?action=validate_email&r=<?= rand(0,99999) ?>" id="email" name="email" placeholder="Adresse email" required>


          </div>





{{--          <div class="input-wrap">--}}
{{--            <label for="tel"></label>--}}
{{--            <input type="text" name="tel" id="tel" placeholder="Téléphone" minlength="17" required>--}}
{{--          </div>--}}

          <div class="input-wrap input-wrap-50">
            <input name="password" id="password" class="login__fields_password field__input" type="password" placeholder="Mot de passe" required>
          </div>

          <div class="input-wrap input-wrap-50">
            <input name="password2" data-rule-equalTo="#password" class="login__fields_password field__input" type="password" placeholder="Confirmez votre mot de passe" required>
          </div>


          <div class="input-wrap-radio">
            <p><strong style="font-weight: bold;">Sans aucun engagement!</strong></p>
{{--            <div class="wrap">--}}
{{--              <label for="radio11">--}}
{{--                <input type="radio" name="radio1" id="radio11">--}}
{{--                <span>oui</span>--}}
{{--              </label>--}}
{{--              <label for="radio12">--}}
{{--                <input type="radio" name="radio1" id="radio12">--}}
{{--                <span>non</span>--}}
{{--              </label>--}}
{{--            </div>--}}
          </div>

          <div class="input-wrap-submit">
            <button class="btn submit-registration-quiz" type="submit" id="show-analyze">Continuer</button>
            <div class="text">
              <p>Vous avez déjà un compte ?</p>
              <p><a href="/login?quiz_result_id={{ $_GET['quiz_result_id'] }}">Se connecter</a></p>
            </div>
          </div>

          <input type="hidden" name="action" value="ajax_registration">
          <input type="hidden" name="quiz" value="{{ get_permalink(3794) . '?quiz_result_id=' . $_GET['quiz_result_id'] }}">
          <input type="hidden" name="quiz_result_id" value="{{   $_GET['quiz_result_id'] }}">
          
          @php wp_nonce_field( 'ajax-registration-nonce', 'security' ); @endphp

        </form>
      </div>
    </div>
  </div>



</div>


@endsection


