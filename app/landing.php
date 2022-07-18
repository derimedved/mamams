<?php


namespace App;

use Sober\Controller\Controller;

class Landing extends Controller
{


    public function __construct()
    {
        add_filter( 'wpcf7_form_tag', [$this, 'dynamic_field_values'], 10, 2);
        add_filter( 'wpcf7_ajax_json_echo', [$this, 'filter_wpcf7_ajax_json_echo'], 10, 2 );

        add_action( 'wpcf7_before_send_mail', [$this, 'wpcf7_disablEmail']);
    }






    public function filter_wpcf7_ajax_json_echo( $items, $result ) {


        $id = $result['contact_form_id'];

        if ($id != 2197 && $id != 2198)
        {
            return;
        }

        $email = $_POST['email-991'];
        $course = $_POST['menu-934'];
        $phone = $_POST['tel-991'];


        if (is_user_logged_in())
            $email = get_userdata(get_current_user_id())->user_email;

        if ($user_id = email_exists($email)  ) {
            $user_id = email_exists($email);
            $link = get_permalink(274);

            if ($course) {

                if (get_field('_lp_price', (int)$course) > 0)
                {

                }
                else  {


                    $order = new \LP_Order();
                    $order->set_user_id( $user_id );
                    $order->update_status( 'completed' );
                    $order->add_item( (int)$course );
                    $order->save();

                    learn_press_update_order_items( $order->get_id() );

                    Ajax::add_profil_order($order->get_id(),$user_id);


                }

            }

        } else {
            $link = get_permalink(2219);
        }



        $url = add_query_arg( array(
            'c' => $course,
            'email' => $email,
            'phone' => $phone
        ), $link );



        $items['data'] = $url;

        return $items;

    }




    public function dynamic_field_values($tag){

        if ( $tag['name'] != 'menu-934' )
            return $tag;

        $args = array (
            'numberposts'   => -1,
            'post_type'     => 'lp_course',
            'orderby'       => 'title',
            'order'         => 'ASC',

        );

        $custom_posts = get_posts($args);

        if ( ! $custom_posts )
            return $tag;

        foreach ( $custom_posts as $custom_post ) {

            if (get_field('_lp_price', $custom_post->ID) > 0)
                continue;

            $tag['raw_values'][] = $custom_post->post_title;
            $tag['values'][] = $custom_post->ID;
            $tag['labels'][] = $custom_post->post_title;

        }

        return $tag;
    }




    function wpcf7_disablEmail( $cf7 ) {


        if ($cf7->id() == 2197 || $cf7->id() == 2198)
            add_filter('wpcf7_skip_mail', [$this, 'abort_mail_sending']);


    }

    function abort_mail_sending($contact_form){
        return true;
    }


}

new Landing();
