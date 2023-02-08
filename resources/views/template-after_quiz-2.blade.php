{{--
Template Name: After quiz 2
--}}



@extends('layouts.app')

@section('content')

<div class="quiz-wrap">


    <div class="no-login-form login-form">
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

                <h5 class="title">{{ get_the_title() }}</h5>

                @php the_content() @endphp

                @if($link)
                <div class="btn-wrap">
                    <a href="#" class="btn-red" id="show-analyze">{{ $link }}</a>
                </div>
                @endif
                
            </div>
        </div>
    </div>

    <div class="last-info" id="analyze" style="display: none;">
        <div class="bg">
            @php the_post_thumbnail('full') @endphp
        </div>
        <div class="content-width">
            <div class="content">
                <h5 class="title">Nous analysons vos réponses ...</h5>
                <div class="progress-wrap">
                    <div class="progress"><span></span></div>
                </div>
                <div class="info">
                    <p class="label">Pour avancer, choisissez</p>
                    <h5 class="title">Pensez-vous que les connaissances peuvent vous aider dans votre maternité ?</h5>
                    <div class="btn-wrap">
                        <a href="{{ get_permalink($_GET['quiz_result_id']) }}">Oui</a>
                        <a href="{{ get_permalink($_GET['quiz_result_id']) }}">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection


