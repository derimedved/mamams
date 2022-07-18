<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    if(is_singular( 'lp_course' )) {
        $classes[] = 'course-page';
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);


add_filter('wpcf7_autop_or_not', '__return_false');



/**
 * disable wp-admin/wp-login for subscribers
 */ 
if ( ! current_user_can('administrator') ) {
    add_filter('show_admin_bar', '__return_false');
}
add_action( 'admin_init', function (){  
    $role = get_role( 'subscriber' );
    $role->remove_cap( 'read' );    
} );
add_filter( 'login_redirect', function ( $redirect_to, $request, $user ) {
    if ( isset($user->roles) && is_array( $user->roles ) ) {
      if ( in_array( 'subscriber', $user->roles ) ) {
        $redirect_to = get_home_url( );
      }   
    }
    return $redirect_to;
}, 10, 3 );

/**
 * Allow logout without confirmation
 */
add_action('check_admin_referer', function ($action, $result)
{
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : 'url-you-want-to-redirect';
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
        header("Location: $location");
        die;
    }
}, 10, 2);


add_filter('wp_nav_menu_objects', function( $items, $args ) {


    if ($args->theme_location != 'primary_navigation') {

        foreach( $items as &$item ) {
		
            $item->classes[] = 'footer__list-item';

        }

    }

    // hide_for_guests 
    
    if ($args->theme_location == 'primary_navigation' && !is_user_logged_in()) {

        foreach( $items as $key => &$item ) {

            if(get_field('hide_for_guests',$item)){
                unset($items[$key]);
            } 

        }

    }
	
	// return
	return $items;
	
}, 10, 2);


add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args ) {

    // check if the item is in the primary menu
    if( $args->theme_location == 'primary_navigation' && !$item->menu_item_parent ) {

        // add the desired attributes:
        $atts['class'] = 'header__link';

    }
    return $atts;
}, 10, 3 );


add_filter( 'pre_site_transient_update_plugins', '__return_null' );