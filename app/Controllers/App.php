<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{

    protected $acf = true;
    
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public static function videoDuration($vimeo_video_id=null)
    {
        if(!$vimeo_video_id) return '';
        

        $vimeo = new \App\VimeoHandler;

        var_dump($vimeo->getVimeoVideoDuration(541107805));
        
        return '08:12';
        

    }

    public static function isPremium()
    {

        $return = false;

        if(!$user_id = get_current_user_id()) return $return;

        $order_ids = get_posts( array(
            'numberposts' => 1,
            'fields' => 'ids',
            'post_type'   => 'lp_order',
            'post_status' => 'any',
            'suppress_filters' => true,
            'meta_query' => [
                [
                    'key' => 'is_premium',
                    'value' => true,
                ],
                [
                    'key' => '_user_id',
                    'value' => $user_id,
                ]
            ], 
        ) ); 
        // wp_reset_postdata(  );

        $completedStatusVariations = ['completed', 'Completed', 'Terminée'];

        if($order_ids) {
            if(in_array(learn_press_get_order_status($order_ids[0]),$completedStatusVariations))
            $return = true;
        }

        return $return;

    }

}
