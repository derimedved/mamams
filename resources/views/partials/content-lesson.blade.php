 @php
    ++$i;
    // Get the lesson ID.
    $tracking_class = '';
    $demo_video = '';
    $video = null;
    $is_preview = LP_Lesson::get_lesson( $lesson_id )->is_preview();
    $lesson_thumb = get_field('video_thumb',$lesson_id);

    if($purchased) {
        $video=get_field('video',$lesson_id)?:'';
        $tracking_class='tracking_video';
    }
    else if ($is_preview) {
        $video = get_field('demo_video',$lesson_id)?:'';
        $tracking_class='demo_video';
    }

    $lesson_progress = isset($course_progress) && !empty($course_progress) && array_key_exists($lesson_id,$course_progress) ? $course_progress[$lesson_id] : '';
    $lesson_thumb = $lesson_thumb?:LP()->image( 'no-image.png' );
    if(get_field('custom_demo_thumb',$lesson_id)) $lesson_thumb = get_field('custom_demo_thumb',$lesson_id)['sizes']['300x200'];
    $lesson_duration = get_field('duration',$lesson_id);

@endphp
<form action="#" class="course-item {{ $tracking_class }}" {!! $i>$lessons_per_page?'style="display:none;"':'' !!}>

    <div class="">
        @if ($video)
            {!! $video !!}
        @else
            <img src="{{ $lesson_thumb }}" alt="{!! get_the_title($lesson_id) !!}">
        @endif
    </div>
    <a href="{{ get_permalink($id) }}" class="course-item__content">
        <div class="course-item__title-wrap">
            <p class="course-item__title"><span>{{ $i }}.</span> {!! get_the_title($lesson_id) !!}</p>
            <div class="video-time">
              <img src="{{ get_template_directory_uri() }}/assets/img/clock-svg.svg" alt="">
              <span>{{ gmdate("H:i:s", $lesson_duration) }}</span>
            </div>
        </div>
        <p class="course-item__description">{!! get_the_content(null,null,$lesson_id) !!}</p>
        <div class="progress-block">
            <div class="progress-block__result-title {{ $lesson_progress ? 'progress-block__result-title_green' : '' }}"><span>{{ $lesson_progress?:0 }}%</span>complété</div>
            <div class="progress-block__progress">
                <span class="progress-block__progress-result" style="width:{{ $lesson_progress?:0 }}%;"></span>
            </div>
        </div>
    </a>

    <input type="hidden" name="progress" value="<?= $lesson_progress; ?>" />
    <input type="hidden" name="lesson_id" value="<?= $lesson_id; ?>" />
    <input type="hidden" name="course_id" value="<?= $course->get_id(); ?>" />

</form>
