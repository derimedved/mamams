<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});


add_action('acf/init', function () {
    acf_update_setting('google_api_key', get_field('gapikey','options'));
});


add_action('wp_logout',function (){
    wp_safe_redirect( home_url() );
    exit;
});

add_action('init', function( ){
    remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
    remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
	remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications', 10, 2 );

    
});

add_action( 'template_redirect', function ( ) {
    
    $closed_pages = [
        'template-profile-info.blade.php',
        'template-profile-orders.blade.php',
        // 'template-ty.blade.php',
    ];
    if(!is_user_logged_in(  )&&in_array(basename(get_page_template()),$closed_pages)) {
        wp_redirect(get_home_url());
    }
    
} );


// learnpress

function mamams_upd_course_duration($course_id=null) {
    if(!$course_id&&!function_exists('learn_press_get_the_course')) return;

    $duration = 0;
    $course = learn_press_get_course($course_id);


    if($course && $curriculum_items = $course->get_items()) {
        // Iterate over each lesson.
        foreach ( $curriculum_items as $lesson_id ) {
            if($lesson_duration = get_field('duration',$lesson_id)) $duration += (int)$lesson_duration;
        }
        update_field('duration', $duration, $course_id);
        return true;
    }

}


remove_action( 'learn-press/before-main-content', 'learn_press_breadcrumb' );
add_action('acf/save_post', function ( $post_id ) {

    // Get newly saved values.
    $values = get_fields( $post_id );

    // Check the new value of a specific field.
    $video = get_field('video', $post_id);

    if( $video && get_post_type( $post_id ) == 'lp_lesson' ) {
        preg_match('/src="(.+?)"/', $video, $matches);
        $src = $matches[1];
        $vimeo = new \App\VimeoHandler;
        $duration = $vimeo->getVimeoVideoDuration($src);
        $thumb = $vimeo->getVimeoVideoThumbnail($src);
        if( $duration ) update_field('duration', $duration, $post_id);
        if( $thumb ) update_field('video_thumb', $thumb, $post_id);
    }
});


add_action('nsl_register_new_user', function ($user_id) {
    

    $user = get_userdata( $user_id );
    $user_name = $user->first_name ?: $user->user_login;
    $email = $user->user_email;

    // send mail
    $mailchimp = new MailChimpHandler();
    $profile = new Profile();
    $global_vars = [];
    $args = [
        'email' => $email,
        'subject' => 'Registration completed',
    ];
    $template = 'welcome';
    $vars = [
        [
            'name' => 'name',
            'content' => $user_name
        ]
    ];

    $other_courses=$profile->get_global_vars();
    if(!empty($other_courses)) $global_vars[] = $other_courses;

    $response = $mailchimp->send_message($args,$template,$vars,$global_vars);
    // send mail end
    
});


// add_action('init', function (  ) {

    

//     if( $_GET['test'] ) {
//         $post_id=242;
//         $video = get_field('video', $post_id);

        
//         preg_match('/src="(.+?)"/', $video, $matches);
//         $src = $matches[1];
//         var_dump($src);
//         $vimeo = new \App\VimeoHandler;
//         // $duration = $vimeo->getVimeoVideoDuration($src);
//         $thumb = $vimeo->getVimeoVideoThumbnail('https://player.vimeo.com/video/549649893');
//         echo '<pre>';
//         // var_dump($vimeo->test());
        
//         // var_dump($duration);
//         var_dump($thumb);
//         echo '</pre>';
//     }
// });