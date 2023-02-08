<?php
/**
 * Template for displaying content of single course.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */
namespace App;

defined( 'ABSPATH' ) || exit;


/**
 * If course has set password
 */
if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

global $wp_filter;
global $purchased;
$user        = learn_press_get_current_user();
$course      = learn_press_get_the_course();
$course_count = $course->count_items('', true) ?: 0;
$user_course = $user->get_course_data( get_the_ID() );

$purchased = $user ? $user->has_enrolled_course( $course->get_id() ) : false;
if(\App::isPremium()) $purchased=true;
$curriculum = $course->get_curriculum();
$choose_plan_page = get_field('choose_plan_page','options');

$course_duration=0;
$custom_course_duration = get_field('custom_course_duration');

if($curriculum_items = $course->get_item_ids()) {
	foreach ( $curriculum_items as $lesson_id ) {
		if(!$custom_course_duration) {
			if($lesson_duration = get_field('duration',$lesson_id)) $course_duration += (int)$lesson_duration;
		}
	}
}

if(is_user_logged_in(  )) {
	setlocale(LC_TIME, "fi_FI");
	$start_date_timestamp = $user_course->get_start_time()->getTimestamp();
	$start_date = strftime("%e %B %Y",$start_date_timestamp);
    $available = get_field('available', $course->get_id()) ;
	$user_id=get_current_user_id(  );
	$courses_progress=get_field('courses_progress','user_'.$user_id ) ? json_decode(get_field('courses_progress','user_'.$user_id ),true) : [];;
	$course_progress=array_key_exists(get_the_ID(),$courses_progress) ? $courses_progress[get_the_ID()] : [];
}
$course_price = $course->get_price()?:__('Free','sage');

$course_avaliable =   $purchased ? 'course_avaliable' : '';

$promo = get_field('promo', $course->get_id()) ;

/**
 * Header for page
 */
echo template('partials.head');
do_action('get_header');
echo template('partials.header');



?>

  <div id="course1" class="course-popup" style="display: none">
    <div class="main-popup">
      <h5>You must be registered to download this item. Please register.</h5>
      <div class="btn-wrap">
        <a href="<?= get_permalink(274) ?>" class="double-btn double-btn_red">S'inscrire</a>
      </div>
    </div>
  </div>

  <div class="mob-fix-menu">
    <div class="line"></div>
    <ul class="et_pb_side_nav">

        <li class="current"><a href="#info-block">Présentation</a></li>

        <li><a href="#course-block">Programme</a></li>

        <?php  if($instructors = get_field('related_instructors')) { ?>
            <li><a href="#instructeurs-block">Spécialistes</a></li>
        <?php } ?>

        <?php if(get_field('faqs')) {  ?>
            <li><a href="#faq-block">FAQ</a></li>
        <?php } ?>
    </ul>
  </div>

<main class="course-page course-page-new">



	<div class="quick-view all-courses" id="container">

	<?php
	/**
	 * @since 3.0.0
	 */
	// do_action( 'learn-press/before-main-content' );
	// do_action( 'learn-press/before-main-content-single-course' );
	?>
    <div id="info-block" class="info-block">
        <div class="container" >
        <div class="bg-img">
          <img src="<?= get_template_directory_uri() ?>/assets/img/icon-400.svg" alt="">
          <img src="<?= get_template_directory_uri() ?>/assets/img/icon-401.svg" alt="" class="mob-img">
        </div>



        <div class="course-page__container"  >
          <div class="video-time">
            <span><span><?= $course->count_items('', true)?:0; ?></span>vidéo </span>
            <?php
            if($course_duration||$custom_course_duration) {
              $course_duration_formated = $custom_course_duration ?: date('G\h i',$course_duration);
              printf('<img src="%s/assets/img/clock-svg.svg" alt="">
						<span><span>%s</span>total</span>',
                get_template_directory_uri(),
                $course_duration_formated,
					);
            } ?>
          </div>
          <h3><?= get_the_title(); ?></h3>




          <?php if(get_field('top_video')): ?>
            <div class="video-wrap" >
              <div class="hover-block">
                <img src="<?= get_the_post_thumbnail_url(get_the_id(), 'full') ?>" alt="">
                <a href="#"><img src="<?= get_template_directory_uri() ?>/assets/img/icon-402.svg" alt=""></a>

                  <div class="video-bage">
                      Ceci est une vidéo de présentation de formation
                  </div>
              </div>

              <div style="padding:56.25% 0 0 0;position:relative;">
                <?= get_field('top_video'); ?>
              </div>

                <div class="video-bage">
                    Ceci est une vidéo de présentation de formation
                </div>
              <style>
                .video-wrap iframe {position:absolute;top:0;left:0;width:100%;height:100%;"}
              </style>

            </div>
          <?php endif; ?>

          <div class="mob-padding">
            <div class="quick-view__title-wrap <?= $course_avaliable ?>" >
              <div class="text-wrap">
                <h6><?php the_field('subtitle') ?></h6>
                <div class="price-wrap">


                    <?php if(!$purchased) {  ?>
                        <?php if ($course->get_origin_price() > $course_price) { ?>
                            <p class="old-price">€<?= $course->get_origin_price()*1.2  ?></p>
                        <?php } ?>
                        <p class="price"><?= $course->get_price() ? '€'.$course->get_price()*1.2 :__('Free','sage');  ?></p>
                    <?php } else { ?>


                    <div class="quick-view__date-container" >
                        <div class="quick-view__date-wrap">


                        </div>

                    </div>


                    <?php } ?>


                </div>
              </div>



              <div class="btn-wrap">
                <?php if(!$purchased) {  ?>
                  <?php if($choose_plan_page) printf('<a href="%s" data-focus_course="%d" class="double-btn double-btn_red">OBTENIR CETTE FORMATION</a>', get_permalink( $choose_plan_page ), get_the_id()); ?>
                <?php } else {  ?>
                    <div class="banner-block__img-purchased">

                        <?php



                        if($start_date && $available):

                            $end_date = date('d/m/Y', strtotime($start_date. " + $available month"));
                            ?>
                            <span>Accessible jusqu'au</span> <?= $end_date; ?>
                        <?php endif; ?>

                    </div>
                  <?php } ?>
              </div>

            </div>
            <hr>



            <div class="quick-view__description" >

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
                          <img src="<?=  get_template_directory_uri() ?>/assets/img/new-img-102.svg" alt="">
                          <?= get_field('video') ? get_field('video') : $course_count; ?> vidéos
                        </span>

                      <?php  if ($bonus = get_field('bonus')) { ?>
                        <span>
                          <img src="<?=  get_template_directory_uri() ?>/assets/img/new-img-103.svg" alt="">
                          <?= $bonus  ?>
                        </span>

                      <?php } ?>
                  </div>
                    <p><?= get_field('class_info') ?></p>
                    <div class="video-time">
                    <span><span><?= $course->count_items('', true)?:0; ?></span>vidéo </span>

                    <?php
                    if($course_duration||$custom_course_duration) {
                      $course_duration_formated = $custom_course_duration ?: date('G\h i',$course_duration);
                      printf('<img src="%s/assets/img/clock-svg.svg" alt="">
                                    <span><span>%s</span>total</span>',
                        get_template_directory_uri(),
                        $course_duration_formated,
                                );
                    } ?>
                  </div>
                  <hr>
                </div>


              <div class="quick-view__resources-wrap btn-link-block">

                  <?= $post->post_excerpt ?>


              </div>



            <!-- course END -->




          </div>


        </div>
      </div>
        <?php if(get_field('files')) {  ?>

            <div class="bonus">
                <div class="">
                  <h3>LES BONUS</h3>
                  <div class="slider-wrap">
                    <div class="owl-carousel owl-theme bonus-slider">
                        <?php foreach(get_field('files') as $file) {
                            if(!$file['file']) continue;
                            $available=$file['available'];
                            $url=$available||$purchased?$file['file']['url']:get_permalink($choose_plan_page);
                            $icon=$available||$purchased?406:405;

                            ?>
                            <div class="item">
                                <div class="text-wrap">
                                  <div class="top-wrap">
                                    <p class="label">Fichier PDF</p>
                                  </div>
                                  <div class="center-wrap">
                                    <h3><?= $file['file']['title'] ?></h3>
                                    <p class="info"><?= $file['file']['description'] ?></p>
                                  </div>
                                  <div class="bottom-wrap">
                                    <div class="btn-wrap">
                                      <a data-focus_course="<?php the_ID() ?>"   href="<?= $url ?>"><img src="<?= get_template_directory_uri() ?>/assets/img/icon-<?= $icon ?>.svg" alt=""></a>
                                    </div>
                                    <div class="text">
                                      <p><?= size_format($file['file']['filesize'], 2) ?></p>
                                    </div>
                                  </div>
                                </div>
                                <figure>
                                  <img src="<?= $file['image']['url'] ?>" alt="">
                                </figure>
                              </div>
                        <?php } ?>
                    </div>
                  </div>
                </div>
              </div>

        <?php } ?>
    </div>




    <div id="course-block" class="course-block">
      <div class="course" >
        <h3>AU PROGRAMME DE CETTE FORMATION</h3>
        <div class="course__wrap <?= $course_avaliable ?>">
          <?php
          if ( $curriculum ) {
            $i=1;
            $play_icon='<button type="button" class="video-play-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100"><path d="M79.674,53.719c2.59-2.046,2.59-5.392,0-7.437L22.566,1.053C19.977-0.993,18,0.035,18,3.335v93.331c0,3.3,1.977,4.326,4.566,2.281L79.674,53.719z"/></svg></button>';
            $block_icon=sprintf('<div class="video-blocked"><img src="%s/assets/img/blocked.svg" alt=""></div>',get_template_directory_uri());

              $count_lessons = 0;
            foreach ( $curriculum as $section ) {
              $lessons = $section->get_items();

              $count_lessons = $count_lessons + count($lessons);
              // Iterate over each lesson.
              foreach ( $lessons as $lesson ) {
                // Now you can work with each lesson, for example:

                // Get the lesson ID.
                $lesson_id = $lesson->get_id();
                $tracking_class = '';
                $lesson_video_src = '';
                $demo_video = '';
                $video = '';
                $lesson_thumb = get_field('video_thumb',$lesson_id);

                if(get_field('demo_video',$lesson_id)) {
                  preg_match('/src="(.+?)"/', get_field('demo_video',$lesson_id), $matches);
                  $demo_video = $matches[1];
                }


                if(get_field('video_embed',$lesson_id)) {
                    $video = get_field('video_embed',$lesson_id);
                } elseif(get_field('video',$lesson_id)) {


                  preg_match('/src="(.+?)"/', wp_oembed_get(get_field('video',$lesson_id)), $matches);
                  $video = $matches[1];
                    update_field('video_embed', $video, $lesson_id);
                }
                if($purchased&&$video) {
                  $lesson_video_src=$video;
                  $tracking_class='tracking_video';
                }
                if($lesson->is_preview()&&$demo_video&&!$purchased) {
                  $lesson_video_src=$demo_video;
                  $tracking_class='demo_video';
                }
                $lesson_progress = isset($course_progress) && !empty($course_progress) && array_key_exists($lesson_id,$course_progress) ? $course_progress[$lesson_id] : '';
                $lesson_thumb = $lesson_thumb?:LP()->image( 'no-image.png' );
                if(get_field('custom_demo_thumb',$lesson_id)) $lesson_thumb = get_field('custom_demo_thumb',$lesson_id)['sizes']['300x200'];
                $lesson_duration = get_field('duration',$lesson_id);
                ?>
                <form action="#" class="course-item <?= get_field('experts', $lesson_id)['value'] ?>">
                  <div class="mob-title">
                    <p class="course-item__title"><span><?= $i; ?>.</span> <?= $lesson->get_title( 'display' ); ?></p>

                  </div>
                  <div class="video-img">
                    <?php if($lesson_video_src) {
                      printf('<a class="%s"
												href="%s">%s<img src="%s" alt="" width="211" height="118"></a>',
                        $tracking_class,
                        $lesson_video_src,
                        $play_icon,
                        $lesson_thumb);
                    } else { printf('<img src="%s" alt="thumb">',$lesson_thumb); } ?>
                  </div>

                  <div class="course-item__content">
                    <div class="course-item__title-wrap">
                      <p class="course-item__title"><span><?= $i; ?>.</span> <?= $lesson->get_title( 'display' ); ?></p>
                      <?php if($lesson_duration): ?>
                        <div class="video-time">
                          <img src="<?= get_template_directory_uri(); ?>/assets/img/clock-svg.svg" alt="">
                          <span><span><?= gmdate("H:i:s", $lesson_duration);  ?></span>
                        </div>
                      <?php endif; ?>
                    </div>
                    <p class="course-item__description"><?= get_the_content(null,null,$lesson_id); ?></p>
                    <div class="progress-block">
                      <div class="progress-block__result-title <?= $lesson_progress ? 'progress-block__result-title_green' : ''; ?>"><span><?= $lesson_progress?:0; ?>%</span>complété</div>
                      <div class="progress-block__progress">
                        <span class="progress-block__progress-result progress-block__progress-result_start" style="width:<?= $lesson_progress?:0; ?>%;"></span>
                      </div>
                    </div>

                      <?php if ( get_field('experts', $lesson_id) ||  get_field('custom', $lesson_id) ) { ?>
                      <span class="badge">
                          <?= get_field('custom', $lesson_id) ? get_field('custom', $lesson_id) : get_field('experts', $lesson_id)['label'] ?>

                      </span>
                      <?php } ?>


                  </div>

                  <input type="hidden" name="progress" value="<?= $lesson_progress; ?>" />
                  <input type="hidden" name="lesson_id" value="<?= $lesson_id; ?>" />
                  <input type="hidden" name="course_id" value="<?= get_the_ID(); ?>" />
                </form>
                <?php $i++; }
            }
          } else {
            echo apply_filters( 'learn_press_course_curriculum_empty', __( 'Curriculum is empty', 'learnpress' ) );
          }
          ?>
        </div>

          <?php if ($count_lessons > 3) { ?>

            <div class="btn-wrap">
              <a href="" onclick="$('.course-item').css({display: 'flex'});$(this).remove();return false" class="double-btn double-btn_red">Voir tous les cours</a>
            </div>

          <?php } ?>

      </div>
    </div>



    <div id="instructeurs-block" class="instructeurs-block">

        <?php  if($instructors = get_field('related_instructors')) { ?>


            <?php echo template('partials.content-specialists-upd', ['instructors' => $instructors] );  ?>


        <?php } ?>

        <?php wp_reset_query(); ?>


        <?php


        if (!\App::isPremium()) {

            if ( $promo ) {

                if ($user->has_enrolled_course($promo->ID)) {
                    $promo_premium = true;

                }
                else {
                    $promo_premium = false;
                }
            }
            else {
                $promo_premium = true;
            }
        }


        ?>

        <?php if($promo_premium) {  ?>

            <?php echo template('partials.content-premium-subscription' );  ?>

        <?php }
        elseif (!\App::isPremium() && !$user->has_enrolled_course($promo ? $promo->ID : get_the_id()))  {

            $promo_course = learn_press_get_course($promo ? $promo->ID : get_the_id());
            $promo_title = $promo_course->get_title();
            $promo_subtitle = get_field('subtitle', $promo_course->get_id());
            $promo_price = $promo_course->get_price() * 1.2 ?:__('Free','sage');
            $promo_image = get_field('cover_image', $promo_course->get_id())['url'];
            $promo_id = $promo_course->get_id();

            ?>
            <section class="premium-subscription">
                <div class="bg">
                  <img src="<?= get_template_directory_uri() ?>/assets/img/new-img-106.svg" alt="">
                  <img src="<?= get_template_directory_uri() ?>/assets/img/new-img-106-1.svg" alt="" class="mob-img">

                </div>
                <div class="container">
                  <div class="content">
                    <div class="text-wrap">
                      <h3><?= $promo_title ?></h3>
                      <p><?= $promo_subtitle ?>
                      </p>
                      <div class="btn-wrap">
                        <p class="price">€<?= $promo_price ?></p>


                        <div class="wrap">
                          <a href="<?= get_permalink( $choose_plan_page ) ?>" data-focus_course="<?= $promo_id ?>" class="double-btn double-btn_red">OBTENIR CE COURS</a>
                        </div>
                      </div>
                    </div>
                    <figure>
                      <img src="<?= $promo_image ?? get_the_post_thumbnail_url($promo_id) ?>" alt="">
                    </figure>
                  </div>
                </div>
           </section>
        <?php } ?>


      <?php
      if (get_field('testimonials_slider'))
      echo template('partials.content-testimonials-upd', ['post_id' => get_the_id()] );  ?>
    </div>



    <div id="faq-block" class="faq-block">


    <?php if(get_field('faqs')) {  ?>

      <?php echo template('partials.content-faq-upd', ['faqs' => get_field('faqs')] );  ?>

    <?php } ?>



      <section class="banner-block-wrap">
        <div class="content">
          <h3>LES AUTRES FORMATIONS DISPONIBLES EN LIGNE</h3>
          <div class="wrap">
            <?php
            wp_reset_query();
            $args = [
              'post_type' => 'lp_course',
              'posts_per_page' => 3  ,
                'post__in' => get_field('related')

            ];

            $loop = new \WP_Query($args); wp_reset_postdata(  );

            while ( $loop->have_posts() ) {
              $loop->the_post();

              if (\App::isPremium() && !get_field('_lp_price', $post->ID))
                continue;


              learn_press_get_template_part( 'content', 'course'  );
            }
            ?>
          </div>
        </div>

      </section>
    </div>




	<?php
	/**
	 * @since 3.0.0
	 */
	// do_action( 'learn-press/after-main-content-single-course' );
	// do_action( 'learn-press/after-main-content' );
	?>
	</div>



</main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sticky/1.0.4/jquery.sticky.min.js"></script>

<?php


/**
 * Footer for page
 */
do_action('get_footer');
echo template('partials.footer');
wp_footer();
