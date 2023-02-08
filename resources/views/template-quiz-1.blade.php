{{--
Template Name: Quiz 1
--}}



@extends('layouts.app')

@section('content')


<div class="quiz-wrap">
  <section class="quiz-1-head">
    <div class="bg">
      <img src="/wp-content/themes/mamams/resources/assets/img/img-400.svg" alt="">
    </div>
    <div class="content-width">
      <div class="text-wrap">
        <h1>@php the_title() @endphp</h1>
        @php the_content() @endphp
      </div>
      <figure>
        @php the_post_thumbnail('full') @endphp

        @if($image_mobile)
        @php echo wp_get_attachment_image($image_mobile->ID, 'full', false, array('class' => 'mob')) @endphp
        @endif

      </figure>
    </div>
    <div class="img-wrap">

      @if($image)
      @php echo wp_get_attachment_image($image->ID, 'full') @endphp
      @endif

    </div>

  </section>

  <section class="our-quizzes">
    <div class="content-width">

      @if($title_1)
      <h2>{{ $title_1 }}</h2>
      @endif

      @if($items)

      <ul>

        @foreach($items as $item)

        <li>

          @if($item->icon)
          <figure>
            @php echo wp_get_attachment_image($item->icon->ID, 'full') @endphp
          </figure>
          @endif

          @if($item->title)
          <h6>{{ $item->title }}</h6>
          @endif

          @if($item->text)
          <h6>{!! $item->text !!}</h6>
          @endif

        </li>

        @endforeach

      </ul>

      @endif

    </div>
  </section>

  <section class="choose-quiz">
    <div class="content-width">

      @if($title_2)
      <h2>@php echo $title_2 @endphp</h2>
      @endif

      @if($quizes)

      <ul>

        @foreach($quizes as $post)

        @php setup_postdata($post) @endphp

        @php
        if(get_field('is_ready', $post->ID)){
          $permalink = get_the_permalink($post->ID);
          $class = '';
        } else{
          $permalink = '#no-questions';
          $class = ' class="fancybox"';
        }
        
        @endphp
        <li>
          <a href="@php echo $permalink @endphp" @php echo $class @endphp>
            <span class="bg">
              @php echo get_the_post_thumbnail($post->ID, 'full') @endphp
            </span>
            <h6>@php echo get_the_title($post->ID) @endphp</h6>
          </a>
        </li>

        @endforeach
        @php wp_reset_postdata() @endphp

      </ul>

      @endif

    </div>
  </section>
</div>

<div id="no-questions" class="popup-no-questions" style="display:none;">
  <div class="main-popup">
    <figure>
      <img src="/wp-content/themes/mamams/resources/assets/img/img-413.png" alt="">
    </figure>
    <div class="text-wrap">
      <p>Ce quiz sera disponible d'ici très peu</p>
    </div>
  </div>
</div>

@endsection




