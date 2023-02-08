@extends('layouts.app')

@section('content')

<div class="quiz-wrap quiz-wrap-bg">
  <section class="quiz-reviews">
    <div class="content-width">
      <div class="content">
        <h1 class="title">{{ html_entity_decode(get_field('quiz_title')) }}</h1>

        @php $heart_result = round(get_field('result') / 3, 0); @endphp

        <p>Résultat personnel: <b>{{ $heart_result }}/5</b></p>
        <div class="top">
          <div class="stars-wrap">

            @for($i = 0; $i < $heart_result; $i++)
            <img src="{{get_template_directory_uri()}}/assets/img/img-450.svg" alt="">
            @endfor

            @for($i = 0; $i < 5 - $heart_result; $i++)
            <img src="{{get_template_directory_uri()}}/assets/img/img-451.svg" alt="">
            @endfor
            
          </div>
          <h6>

            @switch($heart_result)
            @case(3)
            Un manque de préparation important
            @break

            @case(4)
            La préparation n’est pas encore complète
            @break

            @case(5)
            Bravo, vous êtes bien informée
            @break

            @default
            Un manque de préparation trop important!
            @endswitch

          </h6>
        </div>
        <div class="bottom">
          <figure>
            <img src="{{get_template_directory_uri()}}/assets/img/heart_{{ $heart_result }}.svg" alt="">
          </figure>
          <div class="text">

            @php $quiz_id = get_field('quiz_id') @endphp

            @switch($heart_result)
            @case(1)
            @case(2)
            {!! get_field('1_2_hearts_text', $quiz_id) !!}
            @break

            @case(3)
            @case(4)
            {!! get_field('3_4_hearts_text', $quiz_id) !!}
            @break

            @default
            {!! get_field('5_hearts_text', $quiz_id) !!}
            @endswitch

          </div>
        </div>
        <div class="btn-wrap">
          <a href="#recommended" class="red-btn scroll-block">DÉCOUVRIR MON PROGRAMME</a>
        </div>
      </div>

      <div class="bottom-btn">
        <a href="#info-popup-quiz" class="fancybox1" id="questions_30">Répondez aux 30 questions restantes</a>
        <a href="{{get_permalink(2894)}}">Choisissez un autre sujet <img src="{{get_template_directory_uri()}}/assets/img/img-453.svg" alt=""></a>
      </div>
    </div>
  </section>

  <div class="total-wrap">
    <div class="bg">
      <img src="{{get_template_directory_uri()}}/assets/img/img-456.png" alt="" class="img img-1">
      <img src="{{get_template_directory_uri()}}/assets/img/img-457.png" alt="" class="img img-2">
    </div>
    <section class="top-img-text">
      <div class="content-width">
        <figure>
          <img src="{{get_template_directory_uri()}}/assets/img/img-455.svg" alt="">
          <img src="{{get_template_directory_uri()}}/assets/img/img-465.svg" alt="" class="img-mob">
        </figure>
        <div class="text">
          <p>Suite aux résultats de votre auto-évaluation, nous vous proposons ce programme pour améliorer vos connaissances et gagner en sérénité.</p>
        </div>
      </div>
    </section>

    @if($courses = get_field('courses', $quiz_id))
    <section class="recommended" id="recommended">
      <div class="content-width">
        <div class="content">

          @foreach($courses as $post)
          <h2 class="title">{{ html_entity_decode(get_the_title($post->ID)) }}</h2>
          <div class="item">

            @if($top_video = get_field('top_video', $post->ID))
            <div class="video-wrap">
              @php echo $top_video @endphp
              <div class="hover-block">
                @php echo get_the_post_thumbnail($post->ID, 'full') @endphp
                <a href="#"><img src="{{get_template_directory_uri()}}/assets/img/img-462.svg" alt=""></a>
              </div>
            </div>
@endif

            <div class="text">
              <div class="info-line">

                @if($time = get_field('time', $post->ID))
                <p>
                  <img src="{{get_template_directory_uri()}}/assets/img/img-458.svg" alt="">
                  {{ $time }} total
                </p>
                @endif

                @if($video = get_field('video', $post->ID))
                <p>
                  <img src="{{get_template_directory_uri()}}/assets/img/img-459.svg" alt="">
                  {{ $video }} vidéos
                </p>
                @endif

                @if($bonus = get_field('bonus', $post->ID))
                <p>
                  <img src="{{get_template_directory_uri()}}/assets/img/img-460.svg" alt="">
                  {{ $bonus }}
                </p>
                @endif

              </div>
              <div class="info">

                @php echo get_the_excerpt($post->ID) @endphp

              </div>
              <div class="btn-wrap">
                <a data-focus_course="{{ $post->ID }}" href="@php echo get_the_permalink(2329) @endphp" class="red-btn">OBTENIR CETTE FORMATION</a>
                <a href="@php echo get_the_permalink($post->ID) @endphp" class="btn-border">DECOUVRIR</a>
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </div>
    </section>
    @endif

  </div>
</div>

<div class="info-popup-quiz" id="info-popup-quiz" style="display: none;">
  <div class="main-popup">
    <h5 class="title">Ce nouveau questionnaire sera bientôt disponible.
    Nous vous en informerons par mail.</h5>
  </div>
</div>


@if (!$active_campaign && get_field('user')  )
  <script>

    jQuery(document).ready(function($){
      var email = "<?= get_field('user')['user_email'] ?>";
      var quiz_active_campaign_id = "<?=  get_field('active_campaign_id', get_field('quiz_id')  ) ?>";
      var quiz_score = "<?= $heart_result ?>";
      var link = "<?= home_url() ?><?= the_permalink() ?>";

      $('[data-name="email"]').val(email);
      $('[data-name="quizscore'+quiz_active_campaign_id+'"]').val(quiz_score);
      $('[data-name="quiz'+quiz_active_campaign_id+'link"]').val(link);

        $('#_form_15_submit').click();

      return false;
    })
  </script>


  <?php update_field('active_campaign', 1, get_the_id()) ?>

<div style="display: none">
  <div  class="_form_15"></div><script src="https://albelichenko39050.activehosted.com/f/embed.php?id=15" type="text/javascript" charset="utf-8"></script>

</div>
@endif

@endsection