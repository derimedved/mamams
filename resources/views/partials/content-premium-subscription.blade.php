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