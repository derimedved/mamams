<?php


        $args = [
            'post_type'   => 'faq',
            'posts_per_page' => -1,
            'post__in' => $faqs
        ];

?>

<section class="faq-new">
    <div class="bg">
        <img src="<?= get_template_directory_uri() ?>/assets/img/new-img-118.png" alt="">
    </div>
    <div class="container">
        <h3><?= get_field('title_3', 246) ?></h3>
        <div class="content">
            <div class="left">
                <ul class="accordion">
                    <?php
                    $faqs = new \WP_Query($args);
                    while ($faqs->have_posts()) {
                    $faqs->the_post();

                    ?>
                    <li class="accordion-item ">
                        <div class="accordion-thumb">
                            <h5><?php the_title() ?></h5>
                        </div>
                        <div class="accordion-panel">
                            <?php the_content() ?>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <figure>
                <img src="<?= get_field('image_2', 246)['url'] ?>" alt="">
            </figure>
        </div>
    </div>
</section>