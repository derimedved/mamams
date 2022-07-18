<?php
/**
 * Template for displaying content of archive courses page.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */
namespace App;

defined( 'ABSPATH' ) || exit;


/**
 * Header for page
 */
// get_header( 'course' );

echo template('partials.head');
do_action('get_header');
echo template('partials.header');


global $post, $wp_query, $lp_tax_query, $wp_query;

$page_title = learn_press_page_title( false );
$posts_per_page = LP()->settings()->get( 'archive_course_limit' );
$post_type = get_post_type(  );
$user        = learn_press_get_current_user();
if (is_user_logged_in()) {
    $archive_orders = get_field('archive_orders', 'user_'.get_current_user_id());
    $profile       = learn_press_get_profile();
    $query         = $profile->query_courses( 'purchased', array( 'status' => $filter_status ) );
}
$isPremium = \App::isPremium();



?>
<main class="all-courses all-courses-new">

  

  <section class="new-courses">
    <div class="bg">
      <img src="<?= get_template_directory_uri() ?>/assets/img/new-img-100-1.svg" alt="">
      <img src="<?= get_template_directory_uri() ?>/assets/img/new-img-100-1-1.svg" alt="" class="mob-img">

    </div>
    <div class="container output_wrap">
      <h1><?= get_the_title(246) ?></h1>
        <div class="subtitle"><?= get_post(246)->post_content ?></div>
      <div class="tabs-courses">
        <ul class="tabs-menu">

            <li class="<?= !$_GET['my'] ? 'is-active' : '' ?>" data-page="0">Tous</li>

            <?php
            $course_categories[0] = '';
            foreach ($terms = get_terms(['taxonomy' => 'course_category']) as $term) {
                $i++;
                $course_categories[$i] = $term->slug;
                ?>
              <li><?= $term->name ?></li>

            <?php } ?>


            <?php if ($archive_orders) { ?>
                <li class="my-tab <?= $_GET['my'] ? 'is-active' : '' ?>">Mes formations</li>
            <?php } ?>



        </ul>
        <div class="tab-content">

            <?php foreach ($course_categories as $term_slug) { ?>
                <div class="tab-item <?= is_user_logged_in() ? '' : 'user-no-login' ?> ">

                    <?php
                    $args = [
                        'post_type' => 'lp_course',
                        'post_status' => ['publish', 'future'],
                        'posts_per_page' => -1  ,
                        'orderby' => 'post_status',
                        'course_category' => $term_slug
                    ];

                    $loop = new \WP_Query($args); wp_reset_postdata(  );

                    while ( $loop->have_posts() ) {
                        $loop->the_post();


                        if (!$user->has_enrolled_course($post->ID) && !get_field('_lp_price', $post->ID))
                            continue;

                        if (!is_user_logged_in() && !get_field('_lp_price', $post->ID))
                            continue;


                        learn_press_get_template_part( 'content', 'course'  );
                    }
                    ?>

                    </div>
            <?php } ?>

            <?php if ($query['items'] || \App::isPremium()) { ?>
                <div class=" tab-item">
                    <?php

                    foreach($query['items'] as $item) {
                        $ids[] = $item->get_id();
                    }



                    if (\App::isPremium())
                        $ids = '';
                    ?>
                    <?php
                    $args = [
                        'post_type' => 'lp_course',
                        'posts_per_page' => -1  ,
                        'post__in' => $ids
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
            <?php } ?>



        </div>
      </div>
    </div>
  </section>
    


    <?php if (get_field('enabled', 246)) { ?>

        <?php if (!$isPremium) { ?>

            <section class="premium-subscription">
                <div class="bg">
                  <img src="<?= get_template_directory_uri() ?>/assets/img/new-img-106.svg" alt="">
                  <img src="<?= get_template_directory_uri() ?>/assets/img/new-img-106-1.svg" alt="" class="mob-img">

                </div>
                <div class="container">
                  <div class="content">
                    <div class="text-wrap">
                      <h3><?php the_field('title', 246) ?></h3>
                        <p><?php the_field('text', 246) ?></p>
                      <div class="link-wrap">
                        <a href="<?= get_field('link', 246)['url'] ?>"><?= get_field('link', 246)['title'] ?></a>
                      </div>
                    </div>
                    <figure>
                      <img src="<?= get_field('image', 246)['url'] ?>" alt="">
                    </figure>
                  </div>
                </div>
              </section>

        <?php } ?>

    <?php } ?>



    <?php echo template('partials.content-specialists-upd',  ['title' => 'NOS EXPERTS']);  ?>

    <?php if (get_field('enabled_2', 246)) { ?>
        <?php if (!$isPremium) { ?>
            <?php echo template('partials.content-subscription-upd' );  ?>
        <?php } ?>
    <?php } ?>

    <?php echo template('partials.content-testimonials-upd',  ['post_id' => 246] );  ?>
    
    <?php echo template('partials.content-faq-upd' , ['faqs' => get_field('faqs', 246)] );  ?>








   


</main>

<?php if ($_GET['my']) { ?>

    <script>
        var tabPage = 3
    </script>

    <?php } ?>
<?php

/**
 * Footer for page
 */
do_action('get_footer');
echo template('partials.footer');
wp_footer();
