<?php
/**
 * Template for displaying course content within the loop.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$user = LP_Global::user();
if(!$user) $user = learn_press_get_user( get_current_user_id(  ) );




$course = LP_Global::course();
$course_count = $course->count_items('', true) ?: 0;
$purchased = $user ? $user->has_enrolled_course( $course->get_id() ) : false;
if(App::isPremium()) $purchased=true;
$choose_plan_page = get_field('choose_plan_page','options');

$course_duration=0;
$custom_course_duration = get_field('custom_course_duration');
$total_progress=0;
$course_progress=[];
if(is_user_logged_in(  )) {
    $user_id=get_current_user_id(  );
    $courses_progress=get_field('courses_progress','user_'.$user_id ) ? json_decode(get_field('courses_progress','user_'.$user_id ),true) : [];;
    $course_progress=array_key_exists($course->get_id(),$courses_progress) ? $courses_progress[$course->get_id()] : [];
}

if($curriculum_items = $course->get_item_ids()) {
	foreach ( $curriculum_items as $lesson_id ) {
        if(!$custom_course_duration) {
            if($lesson_duration = get_field('duration',$lesson_id)) $course_duration += (int)$lesson_duration;
        }
		
        $total_progress += isset($course_progress) && !empty($course_progress) && array_key_exists($lesson_id,$course_progress) ? (int)$course_progress[$lesson_id] : 0;
	}
}

$total_progress = $course_count && $total_progress ? round(($total_progress / $course_count), 2) : 0 ;
$course_price = $course->get_price()?:__('Free','sage');
$future = $post->post_status == 'future';
$purchased = $future ? false : $purchased
?>




    <div class="banner-block__bg-new banner-block__second-banner-new <?= is_user_logged_in(  ) ? 'logged-in' : '' ?> <?= $purchased ? 'course-active' : '' ?> course-<?= $post->post_status ?>">
        <div class="banner-block__img">
            <a href="<?php the_permalink() ?>">

                <?php if ($course->is_featured()) { ?>
                <p class="label <?= get_field('colour') ?>">
                    <?= get_field('_lp_featured_review') ?? 'Populaire' ?>
                </p>
                <?php } ?>
                <?= $course->get_image( '730x500' ) ?>
            </a>
        </div>
        <div class="banner-block__content-new">
            <div class="top-wrap">

                <?php if ($post->post_status == 'future') { ?>

                    <div class="video-time-new">
                        <span>Bientôt disponible</span>
                        <span>Bientôt disponible</span>
                        <span>Bientôt disponible</span>


                    </div>

                <?php } else { ?>

                    <div class="video-time-new">
                    <span>

                        <?php

                        if ($time = get_field('time'))
                            printf('<img src="%s/assets/img/clock-svg.svg" alt="">
                                 %s total', get_template_directory_uri(), $time
                            );


                        elseif($course_duration||$custom_course_duration) {
                            $course_duration_formated = $custom_course_duration ?: date('G\h i',$course_duration);
                            printf('<img src="%s/assets/img/clock-svg.svg" alt="">
                                 %s total', get_template_directory_uri(), $course_duration_formated
                            );
                        }

                        ?>
                    </span>
                    <span>


                      <img src="<?= get_template_directory_uri() ?>/assets/img/new-img-102.svg" alt="">
                        <?= get_field('video') ?? $course_count; ?> vidéos
                    </span>

                    <?php  if ($bonus = get_field('bonus')) { ?>
                    <span>
                      <img src="<?= get_template_directory_uri() ?>/assets/img/new-img-103.svg" alt="">
                        <?= $bonus  ?>
                    </span>
                    <?php } ?>


                </div>

                <?php } ?>
                <div class="progress">
                    <p><?= $total_progress; ?>% complété</p>
                    <span>
                      <span style="width: <?= $total_progress; ?>%"></span>
                    </span>
                </div>
            </div>
            <h5><?= get_the_title(); ?></h5>
            <?php the_excerpt();?>

            <?php if ($post->post_status !== 'future') { ?>
            <div class="banner-block__wrap-btn">
                <p class="price">€<?= $course_price*1.2 ?>

                <?php if ($course->get_origin_price() > $course_price) { ?>
                <s>€<?= $course->get_origin_price()*1.2  ?></s>
                <?php } ?>



                </p>
                <div class="link-wrap">
                    <a href="<?php the_permalink() ?>">DECOUVRIR</a>
                    <a href="<?php the_permalink() ?>">
                        <?=  $purchased ? 'DECOUVRIR' : 'ouvrir' ?></a>
                </div>

            </div>
            <?php } ?>


            <div class="btn-wrap">




                <?php

                $title = $course->is_free() ? 'VOTRE COURS OFFERT' : 'ACCÈS OUVERT';


                if($purchased)
                    printf('<a href="%s" class="btn-default btn-red" >%s</a>', get_permalink(   ), $title );
                else {
                    if ($post->post_status == 'future')
                        printf('<a href="#" class="btn-default btn-white" data-remind_course="%s"  >NOTIFIEZ MOI</a>',   $course->get_id());
                    else
                        printf('<a href="%s" class="btn-default btn-red" data-focus_course="%s">obtenir ce cours</a>', get_permalink( $choose_plan_page ), $course->get_id());
                }



                ?>




            </div>
        </div>
    </div>


<?php return ?>

