<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;


/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style("style",get_stylesheet_uri(), false, null);
    //wp_dequeue_style( 'wp-block-library' );

    $styles= [
        "assets/style/reset.css",
        "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css",
      //  "https://unpkg.com/aos@next/dist/aos.css",
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css",
        "assets/css/datepicker.min.css",
        "assets/style/style.css",
        "assets/css/styles.css?v=".rand(0,9999),
        "assets/css/text-page.css",

    ];


    if(basename(get_page_template()) == "template-plan-upd.blade.php" ||
        basename(get_page_template()) == "template-registration-upd.blade.php" ||
        basename(get_page_template()) == "template-quiz.blade.php"   ){

        $styles[]="assets/css/nice-select.css";
        $styles[]="assets/css/updated_checkout.css?v=".rand(0,9999);
    }





    if(basename(get_page_template()) == "template-levenement.blade.php"){
        $styles[]="assets/css/levenement.css";
    }
    
    if(basename(get_page_template()) == "template-landing.blade.php"){
        $styles[]="assets/css/swiper.min.css";
        $styles[]="assets/css/landing.css";
    }
    
    if(is_front_page(  )) {
        $styles[]="assets/css/discover-popup-form.css";
    }

    if(basename(get_page_template()) == "template-bonheur.blade.php" || basename(get_page_template()) == "template-bonheur-reg.blade.php"){
        $styles =[];
        $styles[]="assets/css/main_bonheur.css";
        $styles[]="assets/css/vendor_bonheur.css";
        $styles[] = "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css";

    }

    if($styles)
    foreach($styles as $style) {
        $path = str_contains($style, 'https')?$style:get_template_directory_uri().'/'.$style;
        wp_enqueue_style($style, $path, false, '2');
    }

    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.6.0.min.js');
    wp_enqueue_script( 'jquery' );

    $scripts = [
        "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js",
        "https://unpkg.com/aos@next/dist/aos.js",
        "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js",
        "assets/js/jquery.mask.js",
        "assets/js/datepicker.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.fr.min.js",
        "assets/js/jquery.nicescroll.min.js",
        "assets/js/cuttr.js",
        "assets/js/script.js?v=".rand(0,9999),
        "assets/js/gtm.js",
        "assets/js/quiz_result.js",
    ];
    if(is_front_page(  )||is_singular( 'lp_course' )) {
        $scripts[]="https://player.vimeo.com/api/player.js";
    }
    if(basename(get_page_template()) == "template-plan.blade.php" ||
        basename(get_page_template()) == "template-plan-upd.blade.php" ||
        basename(get_page_template()) == "template-quiz.blade.php"){
        $scripts[]="https://js.stripe.com/v3/";
        $scripts[]="assets/js/checkout.js?v=".rand(0,9999);
        $stripe_publishable_key = get_field('stripe_publishable_key_test','options');

      //  $stripe_publishable_key = 'pk_test_51Ir22sLGWTRPugoEgsgGKmKjasJZL9zMMKQd29DFYBTyBlZ5omu7NuABK83YFojLQBL0KAMaySq93It8wn40Udx900MJU106Bx';


        wp_enqueue_script('jqueryvalidation',  'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js', array(), false, 1);
        wp_enqueue_script('jqueryvalidation_fr',  'https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/localization/messages_fr.js', array(), false, 1);


    }
    if(basename(get_page_template()) == "template-landing.blade.php"){
        $scripts[]="assets/js/countdown.js";
        $scripts[]="assets/js/swiper.js";
        $scripts[]="assets/js/landing.js";
    }
    $scripts[]="assets/js/common.js";
    if(basename(get_page_template()) == "template-bonheur.blade.php" || basename(get_page_template()) == "template-bonheur-reg.blade.php"){
        $scripts =[];

        $scripts[]="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js";
        $scripts[]="assets/js/common.js";
        $scripts[] ="assets/js/vendor_bonheur.js";
        $scripts[] ="assets/js/main_bonheur.js";
        $scripts[] ="assets/js/add.js";

     }


    if(basename(get_page_template()) == "template-plan-upd.blade.php" ||
        basename(get_page_template()) == "template-registration-upd.blade.php"
        ||
        basename(get_page_template()) == "template-after_quiz.blade.php"
        ||
        basename(get_page_template()) == "template-after_quiz-2.blade.php"
        || is_singular('quiz')
        || is_singular('quiz_result')
    ){

        $scripts[]="assets/js/jquery.sticky.js";
        $scripts[]="assets/js/jquery.nice-select.min.js";

        $scripts[]="assets/js/updated_checkout.js?v=".rand(0,9999);

        $scripts[]="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" ;


     }

    if(basename(get_page_template()) == "template-plan-upd.blade.php" ||
        basename(get_page_template()) == "template-registration-upd.blade.php" ||
        basename(get_page_template()) == "template-registration-valid.blade.php" ||
        basename(get_page_template()) == "template-after_quiz.blade.php" || is_singular('quiz')
        
    ){


        wp_enqueue_script('jqueryvalidation',  'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js', array(), false, 1);
        wp_enqueue_script('jqueryvalidation_fr',  'https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/localization/messages_fr.js', array(), false, 1);



    }


    if(  basename(get_page_template()) == "template-registration-upd.blade.php" ||
        basename(get_page_template()) == "template-registration-valid.blade.php"||
        basename(get_page_template()) == "template-after_quiz.blade.php" || is_singular('quiz')
    )  {
        $scripts[]="assets/js/registration.js?v=".rand(0,9999);
    }






    if($scripts)
    foreach($scripts as $script) {
        $path = str_contains($script, 'https')?$script:get_template_directory_uri().'/'.$script;
        wp_enqueue_script($script, $path, ['jquery'], null, true);
    }

    $choose_plan_page = get_field('choose_plan_page','options')?get_permalink( get_field('choose_plan_page','options') ) : '';
    $args = [
        'url' => admin_url('admin-ajax.php'),
        'choosePlanUrl' => $choose_plan_page,
    ];

    if($stripe_publishable_key) {
        wp_localize_script('assets/js/checkout.js', 'stripeCheckout',
            array(
                'publishable_key' => $stripe_publishable_key,
            )
        );
    }

    wp_localize_script('assets/js/common.js', 'global',
        $args
    );

}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');
    add_theme_support('soil', [
        'disable-asset-versioning',
        'disable-trackbacks',
        'nice-search',
        'relative-urls',
        // 'js-to-footer',
    ]);

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'footer_navigation_1' => __('Footer Navigation 1', 'sage'),
        'footer_navigation_2' => __('Footer Navigation 2', 'sage'),
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);


/**
 * Custom thumb size.
 */
if ( function_exists( 'add_image_size' ) ) {
    $add_sizes=[
        [1920,1024],
        [1600,700],
        [730,500],
        [710,410],
        [640,640],
        [600,600,false],
        [430,330],
        [430,300],
        [420,420],
        [300,300,false],
        [300,250],
        [300,200],
        [200,200],
        [100,100,false],
    ];
    if($add_sizes)
    foreach($add_sizes as $size) {
        add_image_size( $size[0].'x'.$size[1], $size[0], $size[1], isset($size[2])?$size[2]:true);
    }
}


/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}



add_filter('manage_lp_order_posts_columns', function($columns) {
    return array_merge($columns,

        ['method_title' => 'Method'],
        ['id' => 'id']

    );
}, 1    );


add_action('manage_lp_order_posts_custom_column', function($column_key, $post_id) {

    if ($column_key == 'method_title') {
        $allegro_id = get_post_meta($post_id, 'method_title', true);
        echo  $allegro_id ;
    }
    if ($column_key == 'id') {
        $order_id = get_post_meta($post_id, 'method_title', true) == 'stripe' ? get_post_meta($post_id, 'stripe_payment_id', true) : get_post_meta($post_id, 'paypal_agreement_id', true);
        echo  $order_id  ;

    }



}, 10, 2);



add_filter('manage_quiz_result_posts_columns', function($columns) {
    return array_merge($columns,

        ['user' => 'User']

    );
}, 1    );


add_action('manage_quiz_result_posts_custom_column', function($column_key, $post_id) {

    if ($column_key == 'user') {
        $user = get_field( 'user', $post_id);
        echo(  $user['user_email'] ) ;
    }




}, 10, 2);



