@php

    /*if(isset($_POST['next-page'])){
      if (is_user_logged_in()) $url = get_page_link(2941);
      else $url = get_page_link(2931);
      header("Location: $url");
    }*/


    $post_id = get_the_id();
    $result_id = $_COOKIE['quiz_'. $post_id .'_result_id'];

    if ($result_id) {
      $data = get_field('data', $result_id);

      if ($data) {

       $data = json_decode($data, 1);
       $passed = 'passed';
       //  print_r(get_field('quiz_title', $result_id));

     }

    }


@endphp

@extends('layouts.app')

@section('content')


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


    <div class="quiz-wrap">


        @if($questions)

            <section class="quiz-steps">
                <div class="bg girl-1">

                    @if($background)
                        @php echo wp_get_attachment_image($background->ID, 'full', false, array('class' => 'bg-img')); @endphp
                    @endif

                    <div class="content-width">
                        @if($questions)
                            @foreach($questions as $index => $item)
                                @php
                                    $row = $index + 1;
                                    echo wp_get_attachment_image($item->woman_image->ID, 'full', false, array('class' => "girl-img girl-img-$row"));
                                @endphp
                            @endforeach
                        @endif
                    </div>

                </div>

                <form action="" method="POST" class="form-quiz {{$passed}}">
                    <div class="content-width">
                        <div class="content">
                            <div class="owl-carousel owl-theme quiz-step-slider">

                                @foreach ($questions as $index1 => $item1)

                                    <div class="item">

                                        @if($item1->image)
                                            <div class="icon-wrap">
                                                @php echo wp_get_attachment_image($item1->image->ID, 'full') @endphp
                                            </div>
                                        @endif

                                        <h4 class="title">{{ $item1->question->post_title }}</h4>

                                        @if($item1->answers)

                                            <div class="questions-wrap">

                                                @foreach ($item1->answers as $index2 => $item2)
                                                    <div class="default-item@php echo $item2->is_right ? ' item-ok' : ' item-error'; if(!$item2->image) echo ' no-image' @endphp">
                                                        <label for="d{{$index1 + 1}}{{$index2 + 1}}">

                                                            @php
                                                                $i = $index1 + 1 . $index2 + 1;
                                                                $value = 'd' . $i;
                                                            @endphp

                                                            <input {{ checked($data[$value], 'true')   }} type="radio" name="q{{$index1 + 1}}" id="d{{$index1 + 1}}{{$index2 + 1}}" value="@php echo $item2->is_right ? 1 : 0 @endphp">
                                                            <span>
                      <span class="bg-click">
                        @if($item2->is_right)
                              <img src="/wp-content/themes/mamams/resources/assets/img/img-422.png" alt="">
                          @else
                              <img src="/wp-content/themes/mamams/resources/assets/img/img-423.png" alt="">
                          @endif
                      </span>
                      <span class="wrap">
                        <p>
                          {{ $item2->image }}
                            {{$item2->text}}
                        </p>
                        <span class="click-block">
                          @if($item2->is_right)
                                <img src="/wp-content/themes/mamams/resources/assets/img/img-420.svg" alt="">
                            @else
                                <img src="/wp-content/themes/mamams/resources/assets/img/img-421.svg" alt="">
                            @endif
                        </span>
                      </span>
                    </span>
                                                        </label>
                                                    </div>
                                                @endforeach

                                            </div>

                                        @endif

                                        @if($item1->short_description_title || $item1->short_description_text)
                                            <div class="info">
                                                <div class="title">
                                                    <p>{{ $item1->short_description_title }}</p>
                                                </div>
                                                <div class="text">{!! $item1->short_description_text !!}</div>
                                            </div>
                                        @endif

                                    </div>

                                @endforeach

                            </div>
                            <div class="owl-theme nav-wrap">
                                <div class="owl-controls">
                                    <div id="customNav" class="owl-nav">
                                        <button type="submit" name="next-page"
                                                class="next-page quiz_result"
                                                data-quiz_id="{{ the_id() }}"
                                                data-quiz_title="{{ the_title() }}"
                                                data-quiz_rezult="{{ $passed ? $result_id : 0}}"

                                        ></button>
                                    </div>
                                    <div id="customDots" class="owl-dots"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .lds-ellipsis {

                            margin: 0 auto;
                            display: block;

                            position: fixed;
                            width: 80px;
                            height: 80px;

                            left: calc(50% - 40px);
                            top: calc(50% - 40px);
                            z-index: 99;
                        }
                        .lds-ellipsis div {
                            position: absolute;
                            top: 33px;
                            width: 13px;
                            height: 13px;
                            border-radius: 50%;
                            background: #c35748;
                            animation-timing-function: cubic-bezier(0, 1, 1, 0);
                        }
                        .lds-ellipsis div:nth-child(1) {
                            left: 8px;
                            animation: lds-ellipsis1 0.6s infinite;
                        }
                        .lds-ellipsis div:nth-child(2) {
                            left: 8px;
                            animation: lds-ellipsis2 0.6s infinite;
                        }
                        .lds-ellipsis div:nth-child(3) {
                            left: 32px;
                            animation: lds-ellipsis2 0.6s infinite;
                        }
                        .lds-ellipsis div:nth-child(4) {
                            left: 56px;
                            animation: lds-ellipsis3 0.6s infinite;
                        }
                        @keyframes lds-ellipsis1 {
                            0% {
                                transform: scale(0);
                            }
                            100% {
                                transform: scale(1);
                            }
                        }
                        @keyframes lds-ellipsis3 {
                            0% {
                                transform: scale(1);
                            }
                            100% {
                                transform: scale(0);
                            }
                        }
                        @keyframes lds-ellipsis2 {
                            0% {
                                transform: translate(0, 0);
                            }
                            100% {
                                transform: translate(24px, 0);
                            }
                        }

                    </style>

                    <div style="display: none" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>


                </form>
            </section>

        @endif

    </div>


    <?php  if (!is_user_logged_in()){ ?>
        <div class="info-popup-quiz-reg" id="info-popup-quiz-reg" style="display: none;">
            <div class="main-popup">

                <div class="quiz-wrap">
                    <div class="no-login-form">
                        @php

                            $image = get_field('image', 3793);


                        @endphp
                        <div class="content-width0">
                            <div class="content">

                                @if($image)
                                    <figure>
                                       <img src="{{ $image['url'] }}">
                                    </figure>
                                @endif

                                <h5 class="title">{!!  get_the_title()  !!}</h5>

                                {!! get_post(3793)->post_content !!}

                                <form action="#" class="quiz-default-form ajax_form registration-quiz">

                                    <div class="input-wrap">
                                        <label for="email"></label>

                                        <input type="email" data-msg-remote="Un compte existe déjà pour cette adresse email. Identifiez-vous ou utilisez un mot de passe oublié"
                                               data-rule-remote="/wp-admin/admin-ajax.php?action=validate_email&r=<?= rand(0,99999) ?>" id="email" name="email" placeholder="Adresse email" required>


                                    </div>


                                    <div class="input-wrap input-wrap-50">
                                        <input name="password" id="password" class="login__fields_password field__input" type="password" placeholder="Mot de passe" required>
                                    </div>

                                    <div class="input-wrap input-wrap-50">
                                        <input name="password2" data-rule-equalTo="#password" class="login__fields_password field__input" type="password" placeholder="Confirmez votre mot de passe" required>
                                    </div>




                                    <div class="input-wrap-submit">
                                        <button class="btn submit-registration-quiz" type="submit" id="show-analyze">Continuer</button>
                                        <div class="text">
                                            <p>Vous avez déjà un compte ?</p>
                                            <p><a href="/login?quiz_id={{ get_the_id() }}">Se connecter</a></p>
                                        </div>
                                    </div>

                                    <input type="hidden" name="action" value="ajax_registration">
                                    <input type="hidden" name="quiz" value="{{ get_permalink( ) }}">
                     
                                    @php wp_nonce_field( 'ajax-registration-nonce', 'security' ); @endphp

                                </form>
                            </div>
                        </div>
                    </div>




                </div>

            </div>
        </div>




        <script>

            jQuery(document).ready(function($){


                setTimeout(function(){
                    $.fancybox.open({ // FancyBox 3
                        src: '#info-popup-quiz-reg',
                        modal: true
                    });
                }, 1700)


            })
        </script>

    <?php  } ?>

    <div style="display:none">

        <div class="_form_15"></div><script src="https://albelichenko39050.activehosted.com/f/embed.php?id=15" type="text/javascript" charset="utf-8"></script>
    </div>



    <script>
        var quizName = "<?php the_title() ?>"
        var startDate = '<?= date('Y-m-d') ?>'
        var startTime = '<?= date('h:i') ?>'
        var link = "<?= home_url() ?><?= the_permalink() ?>";
        var quiz_active_campaign_id = "<?=  get_field('active_campaign_id'  ) ?>"


    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js" integrity="sha512-aUhL2xOCrpLEuGD5f6tgHbLYEXRpYZ8G5yD+WlFrXrPy2IrWBlu6bih5C9H6qGsgqnU6mgx6KtU8TreHpASprw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endsection
