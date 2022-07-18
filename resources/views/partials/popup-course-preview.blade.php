
@if ($id)
@php
$user        = learn_press_get_current_user();
$course      = learn_press_get_course( $id );
$user_course = $user->get_course_data( $id );


$purchased = $user ? $user->has_enrolled_course( $course->get_id() ) : false;

$lesson_ids = $course->get_item_ids();
$lessons_per_page = 3;

$course_duration=0;
$custom_course_duration = get_field('custom_course_duration',$id);

if($lesson_ids) {
	foreach ( $lesson_ids as $lesson_id ) {
        if(!$custom_course_duration) {
		    if($lesson_duration = get_field('duration',$lesson_id)) $course_duration += (int)$lesson_duration;
        }
	}
}

if(is_user_logged_in(  )) {
	$user_id=get_current_user_id(  );
	$courses_progress=get_field('courses_progress','user_'.$user_id ) ? json_decode(get_field('courses_progress','user_'.$user_id ),true) : [];;
	$course_progress=array_key_exists($id,$courses_progress) ? $courses_progress[$id] : [];
}
$choose_plan_page = get_field('choose_plan_page','options');

$course_duration_formated = $custom_course_duration ?: date('G\h i',$course_duration);
@endphp


<div class="quick-view__container">

    @if ($top_video = get_field('top_video',$id))
    <div class="video-wrap">
        @php
        // Use preg_match to find iframe src.
        preg_match('/src="(.+?)"/', $top_video, $matches);
        $src = $matches[1];
        @endphp
        <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="{{ $src }}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="Cours Intro"></iframe></div>
    </div>  
    @endif
    
    <div class="quick-view__title-wrap">
        <h4><a href="{{ get_permalink($id) }}">{!! get_the_title($id) !!}</a></h4>
        @if (!$purchased&&$choose_plan_page)
            {!! sprintf('<a href="%s" class="double-btn double-btn_red" data-focus_course="%s">obtenir ce cours</a>', get_permalink( $choose_plan_page ),$id) !!}
        @endif
    </div>
    <hr>
    @if ($purchased)
    <div class="quick-view__date-container">
        <div class="quick-view__date-wrap">
            <div class="banner-block__img-purchased">OBTENU</div>
            <div class="quick-view__date"><span>Accessible jusqu'au</span> {!! $user_course->get_start_time( 'd F Y' ) !!}</div>
        </div>
        <hr>
    </div>
    @endif
    <div class="quick-view__description">
        @if ($class_info = get_field('class_info',$id))
            <p>{!! $class_info !!}</p>
        @endif
        <div class="video-time">
            <span><span>{{ $course->count_items('', true)?:0 }}</span>vidéo </span>
            @if ($course_duration||$course_duration_formated)
                {!! sprintf('<img src="%s/assets/img/clock-svg.svg" alt="">
                    <span><span>%s</span>total</span>',
                    get_template_directory_uri(),
                    $course_duration_formated,
                ) !!}
            @endif
        </div>
        <hr>
    </div>

    @if ($files = get_field('files',$id))
    <div class="quick-view__resources-wrap btn-link-block">
        <p class="btn-link-block__title">RESSOURCES <span>({{ count($files)?:0 }})</span> </p>
        <div class="btn-link-block__wrap">
            @foreach ($files as $file)
            @php
            if(!$file['file']) continue;
            $available=$file['available'];
            $url=$available||$purchased?$file['file']['url']:'#';
            $class=$available||$purchased?'btn-link btn-link_bg':'btn-link btn-link_bg btn-link_disabled';
            @endphp
            <a href="{{ $url }}" class="{{ $class }}" download>
                <div class="btn-link__title">{{ $file['file']['title'] }}</div>
                <div class="btn-link__size">{{ size_format($file['file']['filesize'], 2) }}</div>
            </a>
            @endforeach
        </div>
        <hr>
    </div>
    @endif

    @if ($lesson_ids)
    <div class="course">
        <p class="quick-view__title-p">PROGRAMME DU COURS</p>
        <div class="course__wrap ajax_imitation_wrap">
            @foreach ($lesson_ids as $i => $lesson_id)
               @include('partials.content-lesson')
            @endforeach
        </div>
        @if (count($lesson_ids)>$lessons_per_page)
            <a href="{{ get_permalink(246) }}" data-l_total="{{ count($lesson_ids) }}" data-l_per_page="{{ $lessons_per_page }}" class="load_lessons underline-btn">VOIR TOUS LES VIDÉOS</a>
        @endif
        <hr>
    </div>
    @endif

    @if ($related_instructors = get_field('related_instructors',$id))
    <section class="specialists">
        <div class="container specialists__wrap">
            <p class="quick-view__title-p">INSTRUCTEURS ASSOCIÉS</p>
            <div class="specialists__wrap-content">
                @foreach ($related_instructors as $instructor_id)
                <div class="accordion accordion_default">
                    <div class="accordion__item-main">
                        <div class="specialists__wrap_photo">
                            @if (has_post_thumbnail($instructor_id))
                                <img src="{{ get_the_post_thumbnail_url( $instructor_id, '200x200' ) }}" alt="instructor">
                            @endif
                        </div>
                        <div class="accordion__item-main-description">
                            <h5>{{ get_the_title($instructor_id) }}</h5>
                            <p>{{ get_field('position', $instructor_id) }}</p>
                        </div>
                        <div class="accordion__open-btn"><img src="{{ get_template_directory_uri() }}/assets/img/specialists-open.svg" alt=""></div>
                    </div>
                    <div class="accordion__item-second">
                        @if ($about = get_field('about', $instructor_id))
                        <p>À PROPOS DU SPÉCIALISTE</p>
                        {!! get_field('about', $instructor_id)['text'] !!}
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <hr>
    </section>
    @endif

    @if ($faqs = get_field('faqs',$id))
    <section class="questions">
        <div class="container specialists__wrap">
            <p class="quick-view__title-p">CE QUE VOUS ALLEZ APPRENDRE</p>
            <div class="specialists__wrap-content">
                @foreach ($faqs as $key => $faq)
                <div class="accordion accordion_default">
                    <div class="accordion__item-main">
                        <div class="accordion__item-main-description">
                            <h5><span>{!! ++$key !!}.</span>{!! get_the_title($faq) !!}</h5>
                        </div>
                        <div class="accordion__open-btn"><img src="{{ get_template_directory_uri() }}/assets/img/specialists-open.svg" alt=""></div>
                    </div>
                    <div class="accordion__item-second">
                        {!! get_the_content(null, false, $faq) !!}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
</div>
<div class="autorize-line">

</div>
@endif