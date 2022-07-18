

<section class="subscription">
    <div class="bg">
        <img src="<?= get_field('bg_image', 246)['url'] ?>" alt="">
    </div>
    <div class="container">
        <div class="content">
            <figure>
                <img src="<?= get_field('image_1', 246)['url'] ?>" alt="">
            </figure>
            <div class="text-wrap">
                <h3><?php the_field('title_2', 246) ?></h3>
                <p><?php the_field('text_1', 246) ?></p>
                <div class="sale">
                    <h6><?php the_field('sale', 246) ?></h6>
                </div>
            </div>
        </div>
    </div>
</section>