<section class="testimonials-slider-wrap">
    <div class="container">
        <div class="content">
            <figure>
                <img src="<?= get_field('image_left', $post_id)['url'] ?>" alt="">
            </figure>
            <div class="slider-wrap">
                <div class="owl-carousel owl-theme testimonials-slider">


                    <?php foreach (get_field('testimonials_slider', $post_id) as $item) { ?>

                    <div class="slide">
                        <div class="img-wrap">
                            <img src="<?= $item['image']['url'] ?>" alt="">
                        </div>
                        <blockquote>
                            <?= $item['quote']  ?>
                        </blockquote>
                    </div>

                    <?php } ?>


                </div>
            </div>
        </div>
    </div>
</section>
