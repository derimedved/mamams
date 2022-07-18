<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin', 'ajax', 'profile', 'vimeo', 'stripe', 'paypal', 'mails', 'mailchimp', 'landing']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);

    add_filter( 'learn-press/override-templates', function(){ return true; } );


/**
 * social login redirect
 */ 
add_action('nsl_login', function ($user_id, $provider) {
    $user       = get_userdata($user_id);
    $user_roles = $user->roles;
    $choose_plan_url = get_field('choose_plan_page','options') ? get_permalink( get_field('choose_plan_page','options') ) : '';
    if (in_array('subscriber', $user_roles, true)&&$_COOKIE['return_to_plan']) {
        unset($_COOKIE['return_to_plan']);
        add_filter($provider->getId() . '_login_redirect_url', function () {
            return get_permalink( 463 );
        });
    }
}, 10, 2);


// add_action('nsl_register_new_user', function ($user_id) {
//     if (NextendSocialLogin::getTrackerData() == "registered_from") {
//         $user = new WP_User($user_id);

//         // send mail
//         $email = $user->user_email ?: '';
//         $user_name = get_userdata($user_id)->first_name ?: '';
//         $args = [
//             'name' => $user_name,
//         ];
//         $mails = new Mails();
//         $mails->send_mail($email,sprintf(__('[%s] Registration completed','sage'),get_bloginfo('name')),'welcome',$args);

//     }
// });



//add_action('init', function(){
//    if ($_GET['vimeo']) {
//        $q = new WP_Query([
//            'post_type' => 'lp_lesson',
//            'post_status' => 'any',
//            'posts_per_page' => -1
//        ]);
//
//        while ($q->have_posts()) {
//            $q->the_post();
//            $lesson_id = get_the_id();
//            if(get_field('video',$lesson_id)) {
//
//
//                preg_match('/src="(.+?)"/', wp_oembed_get(get_field('video',$lesson_id)), $matches);
//                $video = $matches[1];
//                update_field('video_embed', $video, $lesson_id);
//            }
//        }
//    }
//});