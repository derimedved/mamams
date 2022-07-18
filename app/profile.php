<?php

namespace App;

use Sober\Controller\Controller;

class Profile extends Controller
{
    public function __construct()
    {

        
        add_action('wp_enqueue_scripts', function () {

            $templates = ['template-profile-info.blade.php','template-profile-orders.blade.php'];
            
            if(in_array(basename(get_page_template()),$templates)){
        
                wp_enqueue_style('/assets/css/profile.css', get_template_directory_uri().'/assets/css/profile.css', false, null);
                wp_enqueue_script('/assets/css/profile.js', get_template_directory_uri().'/assets/js/profile.js', ['jquery'], null, true);
                wp_enqueue_script('/assets/css/dropzone.js', get_template_directory_uri().'/assets/js/dropzone.min.js', ['jquery'], null, true);

            }

        }, 100);


        $actions = [
            'prifile_upd',
            'profile_load_notice',
            'upd_avatar',
        ];
        foreach($actions as $action) {
            add_action("wp_ajax_{$action}", [$this, $action]);
            add_action('wp_ajax_nopriv_{$action}', [$this, $action]);
        }

        add_action( 'profile_notice', [$this, 'profile_notice_function'] );

        if ( ! wp_next_scheduled( 'send_mails_event' ) ) {
        //    wp_schedule_event( time(), 'daily', 'send_mails_event');
        }

       // add_action('send_mails_event', [$this, 'send_mails_event'],10, 3);

    }


    public function get_global_vars() {
        $other_courses=[];

        $other_courses_id = get_posts( array(
            'numberposts' => 3,
            'fields' => 'ids',
            'post_type'   => 'lp_course',
            'post_status' => 'publish',
        ) ); wp_reset_postdata(  );

        if($other_courses_id) {
            $other_courses['name'] = 'courses';
            foreach($other_courses_id as $other_course_id) {
                $excerpt = get_the_excerpt( $other_course_id );
                $text = strlen($excerpt)>40 ? mb_substr($excerpt, 0, 40).'...' : $excerpt;
                $img = has_post_thumbnail( $other_course_id ) ? get_home_url( '/' ).get_the_post_thumbnail_url( $other_course_id, '300x250' ) : '';
                $other_courses['content'][] = [
                    'name' => get_the_title($other_course_id),
                    'text' => $text,
                    'link' => get_the_permalink( $other_course_id ),
                    'image' => $img,
                ];
            }
        }

        return $other_courses;
    }


    public function send_mails_event() {

        // find pending orders
        $order_ids = get_posts( array(
            'numberposts' => -1,
            'fields' => 'ids',
            'post_type'   => 'lp_order',
            'post_status' => 'lp-pending',
        ) ); wp_reset_postdata(  );

        if($order_ids) {
            

            $target_mails = []; //array of email recipients
        
            foreach($order_ids as $order_id) {
                $order = learn_press_get_order( $order_id );
                $items = $order->get_items();
                $email = $order->get_user_email( );
                $user_id = $order->get_data( 'user_id' );
                $order_date = $order->get_order_date();

                if(strtotime('now')>strtotime("+1 day", strtotime($order_date))) continue; // skip new

                $item = $items ? array_shift($items) : [];
                if(!empty($item)&&$email) {  // if order contain course
                    $course_id = $item['course_id'];

                    // skip duplicates and purchased
                    if(!in_array($course_id,$target_mails[$email]) && !learn_press_is_enrolled_course($course_id,$user_id)) {
                        $target_mails[$email][] = $course_id;
                    }

                }

                // remove pending order
                $response = wp_delete_post((int)$order_id);
                
            }

            // send target mails
            if(!empty($target_mails)) {

                $mailchimp = new MailChimpHandler();

                $args = [
                    'email' => $_GET['email'] ?: '',
                    'subject' => 'Que s’est il passé ?',
                ];
                $template = 'target';

                $global_vars = [
            
                    [
                        "name" => "facts_left",
                        "content" => [
                            "Some fact about the course 1",
                            "Some fact about the course 2",
                            "Some fact about the course 3",
                        ]
                    ],
                    [
                        "name" => "facts_right",
                        "content" => [
                            "Some fact about the course 4",
                            "Some fact about the course 5",
                            "Some fact about the course 6"
                        ]
                    ]
                ];
                $other_courses=$this->get_global_vars();

                if(!empty($other_courses)) $global_vars[] = $other_courses;

                foreach($target_mails as $email => $target_courses) {

                    $user = get_user_by('email', $email);
                    $user_name = $user->first_name ?: $user->user_login;
                    $args['email'] = $email;
                    
                    foreach($target_courses as $target_course) {

                        $excerpt = get_the_excerpt( $target_course );
                        $text = strlen($excerpt)>40 ? mb_substr($excerpt, 0, 40).'...' : $excerpt;

                        $vars = [
                            [
                                'name' => 'name',
                                'content' => $user_name
                            ],
                            [
                                'name' => 'course_title',
                                'content' => get_the_title( $target_course )
                            ],
                            [
                                'name' => 'course_text',
                                'content' => $text
                            ],
                            [
                                'name' => 'course_link',
                                'content' => get_permalink( $target_course )
                            ],
                        ];
                        if(has_post_thumbnail( $target_course )) {
                            $vars[] = [
                                'name' => 'course_image',
                                'content' => get_home_url( '/' ).get_the_post_thumbnail_url( $target_course, '300x250' )
                            ];
                        }

                        $response = $mailchimp->send_message($args,$template,$vars,$global_vars);
                    }

                }
                

            }

        }
        
    }


    public function upd_avatar() {

        if ( $_POST['img_id'] ) {

            update_field('avatar',(int)$_POST['img_id'],'user_'.get_current_user_id(  ));

            // $return = update_user_meta( get_current_user_id(  ), 'wp_user_avatar', (int)$_POST['img_id'] );
            // update_user_meta( get_current_user_id(  ), 'user_avatar', (int)$_POST['img_id'] );
        } 
        
        wp_die();
    }


    public function profile_notice_html( $notice=1 , $weeks='??' )
    {
        switch ($notice) {
            case 1:
                $notice = get_field('notice_1','options');
                $title = $notice['title'] ?: "Vous en êtes à $weeks semaines de grossesse";
                ?>
                <div class="profile_notice_item profile-pregnancy-term">
                    <h3><?= sprintf($title,$weeks) ?></h3>
                </div>
                <?php
                break;
            
            case 2:
                $notice = get_field('notice_2','options');
                $title = $notice['title'] ?: "Votre grossesse est maintenant de $weeks semaines";
                $text = $notice['text'] ?: "La date de naissance est maintenant hors limite, veuillez la mettre à jour";
                $button_1 = $notice['button_1'] ?: 'Le bébé est déjà né?';
                $button_2 = $notice['button_2'] ?: 'Perte de grossesse?';
                ?>
                <div class="profile_notice_item profile-pregnancy-term">
                    <h3><?= sprintf($title,$weeks) ?></h3>
                    <p><?= $text; ?></p>
                    <div class="profile-pregnancy-buttons">
                        <a href="#" class="double-btn double-btn_white" data-notice="4" data-action="profile_load_notice" data-fix_notice="4" data-remove="dob"><?= $button_1; ?></a>
                        <a href="#" class="double-btn double-btn_white" data-notice="3" data-action="profile_load_notice"><?= $button_2; ?></a>
                    </div>
                </div>
                <?php
                break;

            case 3:
                $notice = get_field('notice_3','options');
                $text = $notice['text'] ?: "Nous sommes terriblement navrés d’apprendre cette nouvelle. Nous vous souhaitons toute la force et le soutien que vous méritez. Veuillez confirmer que vous souhaitez réinitialiser votre date.";
                $button_1 = $notice['button_1'] ?: 'Oui';
                $button_2 = $notice['button_2'] ?: 'Non';
                ?>
                <div class="profile_notice_item profile-pregnancy-over">
                    <div class="profile-pregnancy-over-text">
                        <p><?= $text; ?></p>
                    </div>
                    <div class="profile-pregnancy-over-buttons">
                        <a href="#" data-notice="" data-action="profile_load_notice" data-remove="dob"><?= $button_1; ?></a>
                        <a href="#" data-notice="2" data-action="profile_load_notice"><?= $button_2; ?></a>
                    </div>
                </div>
                <?php
                break;

            case 4:
                $notice = get_field('notice_4','options');
                $text = $notice['text'] ?: "Vous souhaitez prolongez le suivi de votre grossesse, en êtes vous sûre";
                
                ?>
                <div class="profile_notice_item profile-pregnancy-over">
                    <div class="profile-pregnancy-over-text">
                        <p><?= $text; ?></p>
                    </div>
                </div>
                <?php
                break;
        }
    }


    public function profile_return_weeks( $user_id=null ) {
        if(!$user_id) return '';

        $weeks_of_pregnancy = get_field('weeks_of_pregnancy','options');
        $dob = get_field('dob','user_'.$user_id);

        if($user_id&&$dob&&$weeks_of_pregnancy) {

            $dob = strpos($dob, '/') ? str_replace('/','-',$dob) : $dob;
            $strtotime_dob = strtotime($dob);
            $dob_start = strtotime(" -$weeks_of_pregnancy weeks", $strtotime_dob);
            $difference = time() - $dob_start; // Difference in seconds
            $datediff = floor($difference / 604800) ?: 0;
        }

        return $datediff ?: '';

    }


    public function profile_notice_function(  ) {
        $user_id = get_current_user_id(  );
        $weeks_of_pregnancy = get_field('weeks_of_pregnancy','options');
        $dob = get_field('dob','user_'.$user_id);
        $control_weeks_count = 42;
        $fix_notice = get_user_meta( $user_id, 'fix_notice', true ); 

        if($user_id&&$dob&&$weeks_of_pregnancy) {

            $datediff = $this->profile_return_weeks($user_id);

            if($fix_notice) {
                $this->profile_notice_html((int)$fix_notice,$datediff);
            }
            else if($datediff<$control_weeks_count) {
                $this->profile_notice_html(1,$datediff);
            } 
            else {
                $this->profile_notice_html(2,$datediff);
            }
        }
        if(!$dob&&$fix_notice) $this->profile_notice_html((int)$fix_notice,'');
    }


    public function profile_load_notice()
    {

        if($_GET['remove']) {
            update_user_meta( get_current_user_id(), $_GET['remove'], '' );
        }
        if($_GET['fix_notice']) {
            update_user_meta( get_current_user_id(), 'fix_notice', (int)$_GET['fix_notice'] );
        }
        if($notice = $_GET['notice']) {
            $datediff = $this->profile_return_weeks(get_current_user_id());
            $notice_html='';
            ob_start();
            $this->profile_notice_html((int)$notice,$datediff);
            $notice_html .= ob_get_clean();

            echo json_encode(array(
                'update' => true, 
                'notice_html' => $notice_html,
            ));
        } else {
            echo json_encode(array(
                'update' => true, 
                'notice_html' => '',
            ));
        }
        wp_die();
    }


    public function profile_add_order($user_id=null,$order=[])
    {
        if($user_id&&!empty($order)) {
            $archive_orders = get_field('archive_orders','user_'.$user_id) ?: [];

            array_unshift($archive_orders,$order);

            update_field('archive_orders', $archive_orders, 'user_'.$user_id);

        }

    }


    public function prifile_upd()
    {

        // First check the nonce, if it fails the function will break
        check_ajax_referer( 'ajax-prifile_upd-nonce', 'security' );

        $user_id = $_POST['user_id'] ?: 0;

        if (!$user = get_user_by( 'id', $user_id )) {
            echo json_encode(array(
                'update'=>false, 
                'status' => '<p class="error">Unknow user</p>',
            ));
            wp_die();
        }

        $fields = ['first_name','last_name','age','phone','newsletter_messenger','dob','waiting','children','themes'];
        $acf = ['children','themes'];
        $cleanable_fields = ['newsletter_messenger','phone','first_name','last_name','age'];
        if(!$_POST['newsletter_messenger']) $_POST['newsletter_messenger']='';

        // change date format (d/m/Y => Y-m-d)
        if($_POST['dob']&&strpos($_POST['dob'], '/')) {
            $dob_arr = explode('/', $_POST['dob']);
            $_POST['dob'] = $dob_arr[2].'-'.$dob_arr[1].'-'.$dob_arr[0];
        }
        // remove notice if new date
        if($_POST['dob']) {
            $old_dob = get_field('dob','user_'.$user_id);
            // change date format (d/m/Y => Y-m-d)
            if(strpos($old_dob, '/')) {
                $old_dob_arr = explode('/', $old_dob);
                $old_dob = $old_dob_arr[2].'-'.$old_dob_arr[1].'-'.$old_dob_arr[0];
            }
            if($_POST['dob']!=$old_dob) update_user_meta( $user_id, 'fix_notice', 0 );
        }
        // remove notice if new child
        if($_POST['children']) {
            $old_children = get_field('children','user_'.$user_id);
            $old_children_count = $old_children ? count($old_children) : 0;
            $children_count = $_POST['children'] ? count($_POST['children']) : 0;
            if($old_children_count!=$children_count) update_user_meta( $user_id, 'fix_notice', 0 );
        }

        // remove empty image fields from array
        // if($_POST['children'])
        // foreach($_POST['children'] as $key => $child) {
        //     if(!$child['image']) unset($_POST['children'][$key]['image']);
        // }

        foreach($fields as $key) {
            if(isset($_POST[$key])&&in_array($key, $cleanable_fields)) {
                update_field($key, $_POST[$key], 'user_'.$user_id);
                continue;
            }
            if (!isset($_POST[$key])||empty($_POST[$key])) continue;
            if(in_array($key, $acf)) {
                update_field($key, $_POST[$key], 'user_'.$user_id);
                continue;
            }
            update_user_meta( $user_id, $key, $_POST[$key] );
        }

        $data = array(
            'update' => true, 
            'status' => '<p class="success">'.__('Données enregistrées avec succès','sage').'</p>',
        );

        if(empty($data))
            $data = array(
                'update' => false, 
                'status' => '<p class="error">'.__('Unknow error','sage').'</p>',
            );

        echo json_encode($data);
        
        wp_die();

        
    }

}

new Profile();


// add_action( 'init', function() {
//     // if($_GET['add_order']) {

//     //     // $order = [
//     //     //     'order_id' => 34,
//     //     //     'date_start' => '22/11/22',
//     //     //     'date_end' => '22/12/22',
//     //     //     'mail' => 'test@test.test',
//     //     //     'course' => 'test course 2',
//     //     //     'paid' => 'eur50',
//     //     //     'coupon' => 'PEPEGA',
//     //     // ];
//     //     // $profile = new Profile();
//     //     // $profile->profile_add_order(1,$order);


        



//     // }

//     if($_GET['event_processed']) {
        

//         $profile = new Profile();
//         $profile->send_mails_event();

//     }

// } );