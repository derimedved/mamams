
<section class="expert-slider-wrap">
    <div class="container">
        <h3><?php
            if (is_front_page())
                echo $title;
            else
                $title ? 'NOS EXPERTS' : get_field('title_1', 246)


            ?></h3>

        <?php foreach (get_terms(['taxonomy' => 'categories_specialists']) as $term) {

            $i++;
            ?>

            <div class="owl-carousel owl-theme expert-slider  {{$i == 2 ? 'expert-slider-white' : '' }}">

            <?php
            $args = [
                'post_type'   => 'specialists',
                'posts_per_page' => -1,
                'paged' => 1,
                'post__in' => $instructors,
                'categories_specialists' => $term->slug
            ];


            if (!$instructors)
                $args['post__in'] = wp_list_pluck(get_field('experts_slider', 246), 'ID');

            ?>

                <div class="slide slide-first" style="background: #eee">
                    <div class="expert-category">

                        <div class="text-wrap">
                            <h5>{{ $term->name }}</h5>

                        </div>
                    </div>

                </div>

                <?php

            $specialists = new \WP_Query($args);
            while ($specialists->have_posts()) {
            $specialists->the_post();
            $specialist =  get_the_ID();

            ?>

            <div class="slide">
                <a href="#expert-<?php the_id() ?>" class="fancybox">
                    <figure>
                        <img src="<?= get_the_post_thumbnail_url($specialist,'large');?>" alt="specialist">
                    </figure>
                    <div class="text-wrap">
                        <h5><?php the_title() ?></h5>
                        <p><?php the_field('position') ?></p>
                        <div class="link-wrap">
                            <p >Montrer plus</p>
                        </div>
                    </div>
                </a>

            </div>


            <?php } ?>


        </div>

        <?php } ?>
    </div>
</section>

<?php

$args = [
    'post_type'   => 'specialists',
    'posts_per_page' => -1,
    'paged' => 1,
     
];
$specialists = new \WP_Query($args);

while ($specialists->have_posts()) {
$specialists->the_post();
$specialist = get_the_id()
?>

<div id="expert-<?php the_id() ?>" class="popup-default popup-expert" style="display: none;">
    <div class="wrap">
        <div class="left">

            <figure>
                <img src="<?= get_the_post_thumbnail_url($specialist,'large');?>" alt="specialist">
            </figure>
            <div class="text-wrap">
                <h5><?php the_title() ?></h5>
                <p><?php the_field('position') ?></p>
                <div class="link-wrap">
                    <a href="#" class="" data-fancybox-close>Montrer Moins</a>
                </div>
            </div>

        </div>
        <div class="right">
            <?php
            $contact = get_field('contact');
            $social = $contact['social']
            ?>

            <ul class="soc">
                <?php if ($social['facebook']) { ?>
                <li><a target="_blank" href="<?= $social['facebook'] ?>"><i class="fab fa-facebook-square"></i></a></li>
                <?php } ?>

                <?php if ($social['twitter']) { ?>
                <li><a target="_blank" href="<?= $social['twitter'] ?>"><i class="fab fa-twitter"></i></a></li>
                <?php } ?>

                <?php if ($social['linkedin']) { ?>
                <li><a target="_blank" href="<?= $social['linkedin'] ?>"><i class="fab fa-linkedin-in"></i></a></li>
                <?php } ?>

                <?php if ($social['insta']) { ?>
                <li><a target="_blank" href="<?= $social['insta'] ?>"><i class="fab fa-instagram"></i></a></li>
                <?php } ?>
            </ul>

            <h5><?php the_title() ?></h5>
            <h6><?php the_field('position') ?></h6>
            <div class="line"></div>

            <?=  get_field('about')['text'] ?>

            <div class="bottom">
                <?= get_field('specializations')['text'] ?>
            </div>

            <div class="link-wrap">
                <a href="#" class="" data-fancybox-close>Montrer Moins</a>
            </div>
        </div>
    </div>
</div>

<?php } ?>