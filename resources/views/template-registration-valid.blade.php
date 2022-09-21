{{--
    Template Name: Registration Recommend Template
--}}

@php



    if(!current_user_can( 'administrator' )&&is_user_logged_in()) {
    //    wp_redirect(get_home_url());
    }
@endphp

@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>

    <div class="checkout-upd  user-cabinet sign-up-new">
        <div class="bg">
            <img src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-bg-1.svg" alt="">
            <img src="<?= get_template_directory_uri() ?>/assets/img/checkout/c-bg-2.svg" alt="">
        </div>
        <form class="ajax_form recommend-form"  >
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

                                    <h4 class="title">Futures et jeunes mamans, découvrez la première plateforme de cours en ligne qui vous donne les clés pour vivre une maternité</h4>


                                    <div class="info-block">
                                        <p>L’accès à notre site est exclusivement réservé aux membres. Pour le devenir vous devez obtenir la recommandation d'un professionnel de santé ou d'un membre de l'école des futures mamans.</p>
                                    </div>

                                    <div class="input-wrap-check">
                                        <p>J’ai reçu mon code de recommandation</p>
                                        <div class="wrap">
                                            <input type="checkbox" value="1" name="data-check" id="check-10">
                                            <label for="check-10"></label>
                                        </div>
                                    </div>
                                    <div class="input-wrap-hide">
                                        <label for="code"></label>
                                        <input type="text" id="code" name="code" placeholder="Entrer le code"/>
                                        <button type="" class="red-btn fake-code">VALIDER</button>
                                        <span class="fake-result"></span>
                                    </div>

                                    <div class="input-wrap-select">
                                        <label class="form-label" for="select-10">Qui peut me recommander ?</label>
                                        <select id="select-10">
                                            <option value="0">Une sage-femme</option>
                                            <option value="1">Un membre de l’école des futures mamans</option>
                                            <option value="2">Un médecin</option>

                                        </select>
                                    </div>

                                    <div class="input-wrap-submit">
                                        <p>Vous ne savez pas comment être recommandée ? Renseignez votre adresse mail afin que L’école des futures mamans vous éclaire.</p>
                                        <div class="wrap">
                                            <label for="email-10"></label>
                                            <input type="email" id="email-10" name="email-10" required="required" placeholder="Adresse email"/>
                                            <button type="submit" class="red-btn">Envoyer</button>
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

        <div class="_form_13"></div><script src="https://albelichenko39050.activehosted.com/f/embed.php?id=13" type="text/javascript" charset="utf-8"></script>

    </div>


@endsection


