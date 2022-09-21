<?php

namespace App;

use Sober\Controller\Controller;

class Ajax extends Controller
{
    public function __construct()
    {
        add_action('wp_ajax_post_handler', [$this, 'post_handler']);
        add_action('wp_ajax_nopriv_post_handler', [$this, 'post_handler']);

        add_action('wp_ajax_ajax_registration', [$this, 'ajax_registration']);
        add_action('wp_ajax_nopriv_ajax_registration', [$this, 'ajax_registration']);

        add_action('wp_ajax_ajax_login', [$this, 'ajax_login']);
        add_action('wp_ajax_nopriv_ajax_login', [$this, 'ajax_login']);

        add_action('wp_ajax_upd_course_progress', [$this, 'upd_course_progress']);
        add_action('wp_ajax_nopriv_upd_course_progress', [$this, 'upd_course_progress']);

        add_action('wp_ajax_ajax_quiz', [$this, 'ajax_quiz']);
        add_action('wp_ajax_nopriv_ajax_quiz', [$this, 'ajax_quiz']);

        add_action('wp_ajax_ajax_template_part', [$this, 'ajax_template_part']);
        add_action('wp_ajax_nopriv_ajax_template_part', [$this, 'ajax_template_part']);

        add_action('wp_ajax_ajax_checkout', [$this, 'ajax_checkout']);
        add_action('wp_ajax_nopriv_ajax_checkout', [$this, 'ajax_checkout']);

        add_action('wp_ajax_ajax_reset', [$this, 'ajax_reset']);
        add_action('wp_ajax_nopriv_ajax_reset', [$this, 'ajax_reset']);

        add_action('wp_ajax_ajax_webhook', [$this, 'ajax_webhook']);
        add_action('wp_ajax_nopriv_ajax_webhook', [$this, 'ajax_webhook']);

        add_action('wp_ajax_ajax_webhook_2', [$this, 'ajax_webhook_2']);
        add_action('wp_ajax_nopriv_ajax_webhook_2', [$this, 'ajax_webhook_2']);

        add_action('wp_ajax_ajax_check_coupon', [$this, 'ajax_check_coupon']);
        add_action('wp_ajax_nopriv_ajax_check_coupon', [$this, 'ajax_check_coupon']);

        add_action('wp_ajax_send_template_mail', [$this, 'send_template_mail']);
        add_action('wp_ajax_nopriv_send_template_mail', [$this, 'send_template_mail']);

        add_action('wp_ajax_submit_dropzonejs', [$this, 'dropzonejs_upload']);
        add_action('wp_ajax_nopriv_submit_dropzonejs', [$this, 'dropzonejs_upload']);

        add_action('wp_ajax_validate_email', [$this, 'validate_email']);
        add_action('wp_ajax_nopriv_validate_email', [$this, 'validate_email']);



        

        add_action('acf/save_post', [$this, 'ajax_create_coupon'],10);

        add_action('remove_order_event', [$this, 'remove_order_event'],10, 3);

        add_action( 'wp_loaded', [$this, 'create_webhooks'], 999 );

    }


    public function add_profil_order($order_id=null,$user_id=null,$args=[]) {
        
        if($order_id){
            $order = learn_press_get_order( $order_id );
            $currency = function_exists('learn_press_get_currency_symbol') ? learn_press_get_currency_symbol() : '';
            $items = $order->get_items();
            $item = $items ? array_shift($items) : [];

            $profile_date_start = date('d/m/Y');
            $profile_date_end = '';
            $profile_mail = $order->get_user_email( ) ?: '';
            $profile_course = $item ? get_the_title( $item['course_id'] ) : '';
            $profile_cost = $currency.$order->get_total()?:'';
            $profile_coupon = get_field('coupon',$order_id) ?: '';

            if(!$user_id) {
                $user = get_user_by( 'email', $profile_mail);
                $user_id = $user ? $user->ID : null;
            }

            if(get_field('is_premium',$order_id)&&empty($profile_course)) {
                $profile_course = 'Premium';
            }
            
            $profile_order = [
                'order_id' => $order_id,
                'date_start' => $profile_date_start,
                'date_end' => $profile_date_end,
                'mail' => $profile_mail,
                'course' => $profile_course,
                'paid' => $profile_cost,
                'coupon' => $profile_coupon,
            ];
            if(!empty($args)) {
                $profile_order = wp_parse_args( $args, $profile_order );
            }
            $profile = new Profile();
            $profile->profile_add_order($user_id,$profile_order);
        }
        
    }
    
    
    public function dropzonejs_upload() {
        if ( !empty($_FILES) ) {
            $files = $_FILES;
            foreach($files as $file) {
                $newfile = array (
                    'name' => $file['name'],
                    'type' => $file['type'],
                    'tmp_name' => $file['tmp_name'],
                    'error' => $file['error'],
                    'size' => $file['size']
                );
    
                $_FILES = array('upload'=>$newfile);
                foreach($_FILES as $file => $array) {
                    $newupload =  $this->insert_attachment($file);
                }
            }
        }
        die();
    }
    public function insert_attachment($file_handler) {
        // check to make sure its a successful upload
        if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
    
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    
        $attach_id = media_handle_upload( $file_handler, 0 );
    
        echo intval($attach_id);
    }



    public function remove_order_event($arg1,$arg2)
    {
        
        if($arg1 && $arg2) {
            $response = wp_delete_post($arg1);
        }

    }

    public function ajax_check_coupon()
    {

        if($_POST['coupon']) {

            $posts = get_posts([
				'post_type' => 'coupons',
				'numberposts' => 1,
				'fields' => 'ids',
                'meta_key'   => 'stripe_coupon_id',
                'meta_value' => $_POST['coupon'],
			]); wp_reset_postdata(  );

            if($posts) {

                $stripe = new StripeHandler();

                $allow = $stripe->checkCoupon($_POST['coupon']);

                if($allow) {
                    if($percent_off = get_field('percent_off',$posts[0]))
                        $data = array(
                            'update'=>true, 
                            'percent' => $percent_off,
                            'status' => '<p class="success">'.__('Coupon applied','sage').'</p>',
                        );
                }
                
            }

        }

        if(empty($data))
            $data = array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Invalid coupon data','sage').'</p>',
            );

        echo json_encode($data);

        wp_die();
    }

    
    public function ajax_create_coupon( $post_id )
    {

        if(get_post_type($post_id)=='coupons') {

            // Get newly saved values.
            $coupon_id = get_field( 'stripe_coupon_id', $post_id );
            

            if(!$coupon_id) {
                $percent_off = get_field( 'percent_off', $post_id );
                $duration = get_field( 'duration', $post_id );

                
                if($percent_off&&$duration) {
                    $stripe = new StripeHandler();
                    $coupon_id = $stripe->createCoupon([
                        'percent_off' => (int)$percent_off,
                        'duration' => $duration,
                    ]);

                    if($coupon_id) update_post_meta( $post_id, 'stripe_coupon_id', $coupon_id );

                }
                
            }

        }

    }


    public function ajax_reset()
    {

        // First check the nonce, if it fails the function will break
        check_ajax_referer( 'ajax-reset-nonce', 'security' );

        if($_POST['email']) {

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(array(
                    'update'=>false, 
                    'status' => '<p class="error">Email address '.$_POST['email'].' is incorrect</p>',
                ));
                wp_die();
            }

            if( $user = get_user_by( 'email', $_POST['email']) ) {

                // var_dump($user->user_login);

                $key = get_password_reset_key( $user );

                $reset_link = add_query_arg( array(
                    'reset_key' => $key,
                    'login' => $user->user_login,
                ), get_permalink( 619 ) );


                // send mail
                $mailchimp = new MailChimpHandler();
                $args = [
                    'email' => $_POST['email'],
                    'subject' => 'Reset password',
                ];
                $template = 'lost-password';
                $vars = [
                    [
                        'name' => 'reset_link',
                        'content' => $reset_link
                    ]
                ];
                $response = $mailchimp->send_message($args,$template,$vars);
                // send mail end


                $data = array(
                    'update'=>true, 
                    'remove' => '.ajax_form',
                    'show' => '.reset__succsess',
                );

            } else {
                $data = array(
                    'update'=>false, 
                    'status' => '<p class="error">'.sprintf(__('User with email %s does not exist','sage'),$_POST['email']).'</p>',
                );
            }

        }

        if($_POST['reset_key']&&$_POST['login']) {

            $user = check_password_reset_key( $_POST['reset_key'], $_POST['login'] );

            if( is_wp_error($user) ){
                $data = array(
                    'update'=>false, 
                    'status' => '<p class="error">'.$user->get_error_message().'</p>',
                );
            }
            else {

                if($_POST['password']!=$_POST['password2']||!$_POST['password']||!$_POST['password']) {

                    $data = array(
                        'update'=>false, 
                        'status' => '<p class="error">'.__('Password mismatch','sage').'</p>',
                    );

                } else {

                    wp_set_password( $_POST['password'], $user->ID );
                    $data = array(
                        'update'=>true, 
                        'status' => '<p class="success">'.__('Password changed successfully','sage').'</p>',
                        'redirect' => get_permalink( 274 ),
                    );

                }

            }

        }
        

        if(empty($data))
            $data = array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Unknow email','sage').'</p>',
            );

        echo json_encode($data);

        wp_die();

    }


    public function send_template_mail()
    {

        if($_POST['email']&&$_POST['template']) {
            $user = get_user_by('email', $_POST['email']);
            if($user) {
                $user_name = $user->first_name ?: $user->user_login;
            } else {
                $user_name = '';
            }
            
            $mailchimp = new MailChimpHandler();
            $args = [
                'email' => $_POST['email'],
            ];
            $template = $_POST['template'];
            $vars = [
                [
                    'name' => 'name',
                    'content' => $user_name
                ]
            ];
            if($_POST['template']=='soon') {
                $args['subject'] = 'Soon';
                if($course_title = get_the_title($_POST['course_id'])) {
                    $vars[] = [
                        'name' => 'course_title',
                        'content' => html_entity_decode($course_title)
                    ];
                }
            }
            
            $response = $mailchimp->send_message($args,$template,$vars);
            $data = array(
                'update'=>true,
            );
        }

                
        if(empty($data))
            $data = array(
                'update'=>false, 
            );

        echo json_encode($data);

        wp_die();

    }


    public function send_order_mail($email='',$course_id=null)
    {

        if(!empty($email)) {
            $mailchimp = new MailChimpHandler();
            $profile = new Profile();
            $args = [
                'email' => $email,
                'subject' => 'Order',
            ];
            $template = $course_id ? 'order' : 'order-subscription';
            $vars = [];
            $global_vars = [];
            if($course_id){
                if($course_title = get_the_title($course_id)) {
                    $vars[] = [
                        'name' => 'course_title',
                        'content' => $course_title
                    ];
                }
                if($course_text = get_the_excerpt($course_id)) {
                    $vars[] = [
                        'name' => 'course_text',
                        'content' => $course_text
                    ];
                }
                if(has_post_thumbnail($course_id)) {
                    $vars[] = [
                        'name' => 'course_image',
                        'content' => get_home_url( '/' ).get_the_post_thumbnail_url( $course_id, '430x300' )
                    ];
                } 
            } else {
                $vars = [
                    [
                        'name' => 'course_title',
                        'content' => 'Premium'
                    ],
                    [
                        'name' => 'course_text',
                        'content' => 'Accès Premium sans aucune limite'
                    ],
                    [
                        'name' => 'course_image',
                        'content' => get_home_url( '/' ).get_template_directory_uri().'/assets/mails/img/img03.jpg',
                    ]
                ];
            }

            $other_courses=$profile->get_global_vars();
            if(!empty($other_courses)) $global_vars[] = $other_courses;

            $response = $mailchimp->send_message($args,$template,$vars,$global_vars);
        }
        

    }


    public function create_webhooks()
    {

        $stripe_webhook_id=get_field('stripe_webhook_id','options');
        $paypal_webhook_id=get_field('paypal_webhook_id','options');

        if(!$stripe_webhook_id) {
            $stripe = new StripeHandler();

            $endpoint = add_query_arg( array(
                'action' => 'ajax_webhook',
            ), admin_url('admin-ajax.php') );

            $args = [
                'url' => $endpoint,
                'enabled_events' => [
                    'payment_intent.succeeded',
                    'payment_intent.canceled',
                    'customer.subscription.created',
                    'customer.subscription.deleted',
                ],
            ];

            $response = $stripe->create_webhook($args);
            
            update_field( 'stripe_webhook_id', $response, 'options' );

        }

        if(!$paypal_webhook_id) {

            $paypal = new PayPalHandler();

            $endpoint = add_query_arg( array(
                'action' => 'ajax_webhook_2',
            ), admin_url('admin-ajax.php') );

            $response = $paypal->create_webhook($endpoint);


            if ($_GET['create_hook']) {
                print_r($response);
            }
            
            if($response['id'])
            update_field( 'paypal_webhook_id', $response['id'], 'options' );

        }
        
    }


    public function ajax_webhook_2()
    {

        $paypal = new PayPalHandler();

        $event = $paypal->webhook();

        wp_mail('oleg.derimedved@gmail.com', 'event', 'e - '. json_encode($event));
        


        $log = get_field('paypal_test', 'options');
        update_field( 'paypal_test', $log. ' webhook1 --- '. json_encode($event), 'options' );





        switch ($event['event_type']) {
            case 'CHECKOUT.ORDER.APPROVED':
                // Then define and call a method to handle the successful payment intent.
                // handlePaymentIntentSucceeded($paymentIntent);

                // change learnpress order status
                $payment_intent = $event['resource']['id'] ?: false;
                if($payment_intent) {
                    $order_ids = get_posts( array(
                        'numberposts' => 1,
                        'fields' => 'ids',
                        'post_type'   => 'lp_order',
                        'post_status' => 'any',
                        'meta_key'    => 'paypal_order_id',
                        'meta_value'  => $payment_intent,   
                    ) ); wp_reset_postdata(  );
                    $order_id=$order_ids?$order_ids[0]:0;
                    if($order_id) {
                        $order = learn_press_get_order( $order_id );
                        $order->update_status( 'completed' );

                        $items = $order->get_items();
                        $user_id = $order->get_data( 'user_id' );

                        if($items)
                        foreach($items as $item) {
                            // add cron event
                            if($available = get_field('available',$item['course_id'])) {
                                wp_schedule_single_event( strtotime($available.' month'), 'remove_order_event',  array( $order->get_id(),$user_id ) );
                            }
                        }

                        // send mail
                        $items = $order->get_items();
                        $email = $order->get_user_email( );
                
                        $item = $items ? array_shift($items) : [];
                
                        $course_id = $item['course_id'];

                        $this->send_order_mail($email,$course_id);
                        // send mail end


                        // add order to profile
                        $profile_args=[];
                        if($available) {
                            $profile_args = [
                                'date_end' => date('d/m/Y',strtotime($available.' month')),
                            ];
                        }
                        $this->add_profil_order($order_id,$user_id,$profile_args);
                        // add order to profile end
                        
                    }
                }

                break;
            case 'BILLING.SUBSCRIPTION.ACTIVATED':
                // Then define and call a method to handle the successful attachment of a PaymentMethod.
                // handlePaymentMethodAttached($paymentMethod);
                $plan_id = $event['resource']['plan_id'] ?: false;

                $end_sub = $event['resource']['billing_info']['next_billing_time'];
                    
                $end_sub = $end_sub ? strtotime($end_sub) : strtotime("+1 month");
                
                if($plan_id) {
                    $order_ids = get_posts( array(
                        'numberposts' => 1,
                        'fields' => 'ids',
                        'post_type'   => 'lp_order',
                        'post_status' => 'any',
                        'meta_key'    => 'paypal_plan_id',
                        'meta_value'  => $plan_id,   
                    ) ); wp_reset_postdata(  );
                    $order_id=$order_ids?$order_ids[0]:0;
                    if($order_id) {
                        $order = learn_press_get_order( $order_id );
                        $order->update_status( 'completed' );
                    }
                    

                    // remove order cron event
                    if($order) {
                        wp_schedule_single_event( $end_sub, 'remove_order_event',  array( $order->get_id(), $order->user_id ) );
                    }
                }

                break;
            case 'BILLING.PLAN.ACTIVATED':
                $plan_id = $event['resource']['id'] ?: false;

                // $end_sub = $event['resource']['billing_info']['next_billing_time'];

                $end_sub = strtotime("+1 month");

                if($plan_id) {
                    $order_ids = get_posts( array(
                        'numberposts' => 1,
                        'fields' => 'ids',
                        'post_type'   => 'lp_order',
                        'post_status' => 'any',
                        'meta_key'    => 'paypal_plan_id',
                        'meta_value'  => $plan_id,   
                    ) ); wp_reset_postdata(  );
                    $order_id=$order_ids?$order_ids[0]:0;
                    if($order_id) {
                        $order = learn_press_get_order( $order_id );
                        $order->update_status( 'completed' );
                    }
                    

                    // remove order cron event
                    if($order) {
                        wp_schedule_single_event( $end_sub, 'remove_order_event',  array( $order->get_id(), $order->user_id ) );
                    }
                }

                break;

            case 'PAYMENT.CAPTURE.COMPLETED':
                $payment_intent = $event['resource']['supplementary_data']['related_ids']['order_id'] ?: false;
                $payment_status = $event['resource']['status'] ;
                $order_ids = get_posts( array(
                    'numberposts' => 1,
                    'fields' => 'ids',
                    'post_type'   => 'lp_order',
                    'post_status' => 'any',
                    'meta_key'    => 'paypal_order_id',
                    'meta_value'  => $payment_intent,
                ) ); wp_reset_postdata(  );
                $order_id=$order_ids?$order_ids[0]:0;
                if($order_id) {
                    update_post_meta( $order_id, 'paypal_payment_status', $payment_status );
                }
                break;
                
            default:
              // Unexpected event type
              echo 'Received unknown event type';

        }

        wp_die();

    }


    public function ajax_webhook()
    {

        $stripe = new StripeHandler();

        $event = $stripe->webhook();
        
        update_field( 'stripe_test', json_encode($event), 'options' );

        switch ($event->type) {
            case 'payment_intent.succeeded':
                // Then define and call a method to handle the successful payment intent.
                // handlePaymentIntentSucceeded($paymentIntent);

                // change learnpress order status
                $payment_intent = $event->data->object->id ?: false;
                if($payment_intent) {
                    $order_ids = get_posts( array(
                        'numberposts' => 1,
                        'fields' => 'ids',
                        'post_type'   => 'lp_order',
                        'post_status' => 'any',
                        'meta_key'    => 'stripe_payment_id',
                        'meta_value'  => $payment_intent,   
                    ) ); wp_reset_postdata(  );
                    $order_id=$order_ids?$order_ids[0]:0;
                    if($order_id) {
                        $order = learn_press_get_order( $order_id );
                        $order->update_status( 'completed' );

                        $items = $order->get_items();
                        $user_id = $order->get_data( 'user_id' );

                        if($items)
                        foreach($items as $item) {
                            // add cron event
                            if($available = get_field('available',$item['course_id'])) {
                                wp_schedule_single_event( strtotime($available.' month'), 'remove_order_event',  array( $order->get_id(),$user_id ) );
                            }
                        }


                        // send mail
                        $items = $order->get_items();
                        $email = $order->get_user_email( );
                
                        $item = $items ? array_shift($items) : [];
                
                        $course_id = $item['course_id'];

                        $this->send_order_mail($email,$course_id);
                        // send mail end

                        // add order to profile
                        $profile_args=[];
                        if($available) {
                            $profile_args = [
                                'date_end' => date('d/m/Y',strtotime($available.' month')),
                            ];
                        }
                        $this->add_profil_order($order_id,$user_id,$profile_args);
                        // add order to profile end
                        
                    }
                }

                break;
            case 'payment_intent.canceled':
                // Then define and call a method to handle the successful attachment of a PaymentMethod.
                // handlePaymentMethodAttached($paymentMethod);
                // change learnpress order status
                $payment_intent = $event->data->object->id ?: false;
                if($payment_intent) {
                    $order_ids = get_posts( array(
                        'numberposts' => 1,
                        'fields' => 'ids',
                        'post_type'   => 'lp_order',
                        'post_status' => 'any',
                        'meta_key'    => 'stripe_payment_id',
                        'meta_value'  => $payment_intent,   
                    ) ); wp_reset_postdata(  );
                    $order_id=$order_ids?$order_ids[0]:0;
                    if($order_id) {
                        $order = learn_press_get_order( $order_id );
                        $order->update_status( 'cancelled' );
                    }
                }

                break;

            case 'customer.subscription.created':

                // get subscription id
                $sub_id = $event->data->object->id;

                // start subscription strtotime
                $start_sub = $event->data->object->current_period_start;

                // end subscription strtotime
                $end_sub = $event->data->object->current_period_end;

                // get customer 
                $customer_id = $event->data->object->customer;
                $cusotmer = $stripe->getCustomer($customer_id);
                $cusotmer_email = $cusotmer->email;

                // get wp user
                if($cusotmer_email) {
                    $user = get_user_by('email', $cusotmer_email);
                }

                if(!$user) break;

                // find order
                $order_ids = get_posts( array(
                    'numberposts' => -1,
                    'fields' => 'ids',
                    'post_type'   => 'lp_order',
                    'post_status' => 'any',
                    'meta_query' => [
                        [
                            'key' => 'is_premium',
                            'value' => true,
                        ],
                        [
                            'key' => '_user_id',
                            'value' => $user->ID,
                        ]
                    ], 
                ) ); wp_reset_postdata(  );

                // change status order
                if($order_ids){
                    $order = learn_press_get_order( $order_ids[0] );
                    $order->update_status( 'completed' );
                }

                // upd user metas
                update_user_meta( $user->ID, 'subscription_id', $sub_id );

                // remove order cron event
                if($order) {
                    wp_schedule_single_event( $end_sub, 'remove_order_event',  array( $order->get_id(), $user->ID ) );
                }

                // send mail
                $email = $order ? $order->get_user_email( ) : $cusotmer_email;

                $this->send_order_mail($email);
                // send mail end

                if($order) {
                    // add order to profile
                    $profile_args=[];
                    if($end_date=date('d/m/Y',$end_sub)) {
                        $profile_args = [
                            'date_end' => $end_date,
                        ];
                    }
                    $this->add_profil_order($order->get_id(),$user->ID,$profile_args);
                    // add order to profile end
                }
            
                break;

            case 'customer.subscription.deleted':

                // get subscription id
                $sub_id = $event->data->object->id;

                // get customer 
                $customer_id = $event->data->object->customer;

                $users = get_users( [
                    'meta_key'     => 'subscription_id',
                    'meta_value'   => $sub_id,
                    'number'       => 1,
                    'fields'       => 'ids',
                ] );
                if($users) $user_id = $users[0];

                if(!$user_id) break;

                // find order
                $order_ids = get_posts( array(
                    'numberposts' => -1,
                    'fields' => 'ids',
                    'post_type'   => 'lp_order',
                    'post_status' => 'any',
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
                ) ); wp_reset_postdata(  );

                // remove order
                if($order_ids){
                    $response = wp_delete_post($order_ids[0]);
                }


                break;
            default:
              // Unexpected event type
              echo 'Received unknown event type';

        }

        wp_die();

    }


    public function ajax_checkout()
    {

        $ty_page = get_field('thank_you_page','options') ? get_permalink( get_field('thank_you_page','options') )  : get_home_url(  );
        $c_page = get_field('choose_plan_page','options') ? get_permalink( get_field('choose_plan_page','options') ) : get_home_url(  );
        $items = [];
        $user = get_user_by('id',$_POST['user_id']);
        $user_email = $user ? $user->user_email : '';

        
        if(!$_POST['user_id']) {
            echo json_encode(array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Unknow user','sage').'</p>',
            ));
            wp_die();
        }

        if($_POST['payment_method']=='stripe') {
            
            $stripe = new StripeHandler();

            // One Course
            if($_POST['course_type']=='one_course') {

                if(!$_POST['course_id']) {
                    echo json_encode(array(
                        'update'=>false, 
                        'status' => '<p class="error">'.__('Unknow course','sage').'</p>',
                    ));
                    wp_die();
                }

                $stripe_price = get_field('stripe_price_id',$_POST['course_id']);
                $mode = 'payment';
                $course_id=(int)$_POST['course_id'];

                if($stripe_price) {
                    if(!$stripe->hasPrice($stripe_price)) {
                        $stripe_price='';
                        
                    }
                }
                    
                // create stripe product
                if(!$stripe_price) {
                    if($course = learn_press_get_course( $course_id )) {
                        $price = $course->get_price();
                    }
                    // A positive integer in cents (or 0 for a free price) representing how much to charge.
                    $price = $price&&$price>0?($price*100):0;
                    $images = has_post_thumbnail( $course_id ) ? [get_home_url(  ).get_the_post_thumbnail_url( $course_id, '730x500' )] : [];

                    $product_args = [
                        'name' => get_the_title( $course_id ),
                        'description' => get_the_excerpt( $course_id ),
                        'images' => $images,
                        'url' => get_the_permalink( $course_id ),
                    ];
                    $price_args = [
                        'unit_amount' => $price,
                    ];

                    if(function_exists('learn_press_get_currency')) $price_args['currency'] = strtolower(learn_press_get_currency());

                    $new_product = $stripe->createProduct($product_args,$price_args);
                    
                    if($new_product['price_id']) {
                        update_post_meta( $course_id, 'stripe_price_id', $new_product['price_id'] );
                        $stripe_price = $new_product['price_id'];
                    }
                }

                if($c_tax = get_field('c_tax',$course_id)) {
                    $c_tax_id = $stripe->getTaxId((int)$c_tax);
                }

            }
            // Premium
            else if($_POST['course_type']=='premium') {
                $stripe_price = get_field('premium_price_id','options');
                $mode = 'subscription';
                if($c_tax = get_field('c_tax','options')) {
                    $c_tax_id = $stripe->getTaxId((int)$c_tax);
                }
            }

            $item=[
                'price' => $stripe_price,
                'quantity' => 1,
            ];

            // add tax
            if($c_tax_id) $item['tax_rates'] = [$c_tax_id];

            $items[] = $item;
                        
            $session_args = [
                'success_url' => $ty_page,
                'cancel_url' => $c_page,
                'payment_method_types' => ['card'],
                'line_items' => $items,
                'mode' => $mode,
                'customer_email' => $user_email,
            ]; 
            $allow=false;
            //if($_POST['coupon']&&$_POST['course_type']=='one_course') {

            if($_POST['coupon'] ) {
                $allow = $stripe->checkCoupon($_POST['coupon']);
                if($allow)
                    $session_args['discounts'][] = [
                        'coupon' => $_POST['coupon'],
                    ];
            }
            
            if($stripe_price) {

                // create checkout session
                $response = $stripe->createCheckoutSession($session_args);
                

                // create course order
                if($_POST['course_type']=='one_course') {
                    $order = new \LP_Order();
                    $order->set_user_id( $_POST['user_id'] );
                    $order->update_status();
                    $order->add_item( $_POST['course_id'] );
                    $order->save();
                    learn_press_update_order_items( $order->get_id() );


                    if(!$course)
                        $course = learn_press_get_course( $course_id );


                    if($_POST['coupon']&&$allow) {

                        $posts = get_posts([
                            'post_type' => 'coupons',
                            'numberposts' => 1,
                            'fields' => 'ids',
                            'meta_key'   => 'stripe_coupon_id',
                            'meta_value' => $_POST['coupon'],
                        ]); wp_reset_postdata(  );
                        if($posts) {
                            $percent_off = get_field('percent_off',$posts[0]);
                            if($percent_off) {
                                $course_price = $course->get_price()?:0;
                                $course_price = $course_price - (($course_price/100)*$percent_off);

                                update_post_meta( $order->get_id(), 'coupon', $_POST['coupon'] );
                            }
                        }
                    }

                    if($c_tax) {
                        $c_tax = (int)$c_tax;

                        $course_price = $course_price ?: $course->get_price();
    
                        $tax_price = ($course_price/100)*$c_tax;
    
                        $course_price = $course_price+$tax_price;
                    }

                    if($course_price) {
                        $order->set_subtotal($course_price);
                        $order->set_total($course_price);
                        $order->save();
                    }

                }

                // create premium order
                else if($_POST['course_type']=='premium') {

                    $premium_price = get_field('premium_price','options') ? (int)get_field('premium_price','options') : 320;

                    if($precent = get_field('c_tax','options')) {
                        $precent = (int)$precent;
    
                        $tax_price = ($premium_price/100)*$precent;
    
                        $premium_price = $premium_price+$tax_price;
                    }

                    $order = new \LP_Order();
                    $order->set_user_id( $_POST['user_id'] );
                    $order->update_status();
                    $order->save();
                    $order->set_subtotal($premium_price);
                    $order->set_total($premium_price);
                    update_post_meta( $order->get_id(), 'is_premium', 1 );
                    update_post_meta( $order->get_id(), '_order_currency', learn_press_get_currency() );
                    update_post_meta( $order->get_id(), '_prices_include_tax', 'no' );
                    update_post_meta( $order->get_id(), '_order_subtotal', $premium_price );
                    update_post_meta( $order->get_id(), '_order_total', $premium_price );
                    update_post_meta( $order->get_id(), '_order_key', learn_press_generate_order_key() );
                    update_post_meta( $order->get_id(), '_payment_method', '' );
                    update_post_meta( $order->get_id(), '_payment_method_title', '' );
                    update_post_meta( $order->get_id(), '_order_version', '1.0' );
                }

                update_post_meta( $order->get_id(), 'method_title', $_POST['payment_method'] );

                if($response['payment_intent']) update_post_meta( $order->get_id(), 'stripe_payment_id', $response['payment_intent'] );

                $data = array(
                    'update'=>true,
                    'response'=>$response,
                    'payment_method' => $_POST['payment_method'],
                );

            } else {
                $data = array(
                    'update'=>false, 
                    'status' => '<p class="error">'.__('Empty price id','sage').'</p>',
                );
            }
        

        }

        if($_POST['payment_method']=='paypal') {
            
            $paypal = new PayPalHandler();

            $currency = function_exists('learn_press_get_currency') ? learn_press_get_currency() : 'USD';

            if($_POST['course_type']=='one_course') {

                if(!$_POST['course_id']) {
                    echo json_encode(array(
                        'update'=>false, 
                        'status' => '<p class="error">'.__('Unknow course','sage').'</p>',
                    ));
                    wp_die();
                }

                $course_id=(int)$_POST['course_id'];
                $course = learn_press_get_course( $course_id );

                $price = $course->get_price();

                $format_price = number_format($price, 2, '.', '');
    
                $item = [
                    'amount' =>
                        array(
                            'currency_code' =>  $currency,
                            'value' => $format_price,
                            'breakdown' =>
                                array(
                                    'item_total' =>
                                        array(
                                            'currency_code' =>  $currency,
                                            'value' => $format_price,
                                        ),
                                ),
                        ),
                    'items' =>
                        array(
                            array(
                                'name' => get_the_title( $course_id ),
                                'unit_amount' =>
                                    array(
                                        'currency_code' =>  $currency,
                                        'value' => $format_price,
                                    ),
                                
                                'quantity' => '1',
                            ),
                        ),
                ];

                if($_POST['coupon']) {
                    // $stripe = new StripeHandler();
                    // $allow = $stripe->checkCoupon($_POST['coupon']);
                    $allow=false;
                    $posts = get_posts([
                        'post_type' => 'coupons',
                        'numberposts' => 1,
                        'fields' => 'ids',
                        'meta_key'   => 'stripe_coupon_id',
                        'meta_value' => $_POST['coupon'],
                    ]); wp_reset_postdata(  );
                    if($posts) {
                        $percent_off = get_field('percent_off',$posts[0]);
                        $allow=true;
                        if($percent_off) {
                            $percent_off=(int)$percent_off;
                            $discount = ($percent_off / 100) * $price;
                            $new_price = $price - $discount;
        
                            $format_new_price = number_format($new_price, 2, '.', '');
                            $format_discount = number_format($discount, 2, '.', '');
        
                            $item['amount']['value'] = $format_new_price;
                            $item['amount']['breakdown']['discount'] = array(
                                    'currency_code' =>  $currency,
                                    'value' => $format_discount,
                            );
                            $item['items'][0]['discount'] = array(
                                'currency_code' =>  $currency,
                                'value' => $format_discount,
                            );
                        }
                    }
                }

                if($precent = get_field('c_tax',$course_id)) {
                    
                    $precent = (int)$precent;

                    $price = $new_price ?: $price;

                    $tax_price = ($price/100)*$precent;

                    $format_tax_price = number_format($tax_price, 2, '.', '');

                    $price = $price+$tax_price;

                    $total_format_price = number_format($price, 2, '.', '');
                    
                    $item['amount']['value'] = $total_format_price;
                    $item['amount']['breakdown']['tax_total'] =  array(
                        'currency_code' => $currency,
                        'value' => $format_tax_price,
                    );
                    $item['items'][0]['tax'] =  array(
                        'currency_code' => $currency,
                        'value' => $format_tax_price,
                    );
                }

                $context = [
                    "cancel_url" => $c_page,
                    "return_url" => $ty_page.'?paypal_capture_order=1',
                ];

                if($price==0) {

                    // create order
                    $order = new \LP_Order();
                    $order->set_user_id( $_POST['user_id'] );
                    $order->update_status();
                    $order->add_item( $_POST['course_id'] );
                    $order->save();
                    $order->update_status( 'completed' );
                    learn_press_update_order_items( $order->get_id() );
                    

                    update_post_meta( $order->get_id(), 'method_title', $_POST['payment_method'] );

                    $data = array(
                        'update'=>true,
                        'status' => '<p class="success">'.__('Order created','sage').'</p>',
                    );

                } else {

                    $response = $paypal->createOrder($item,$context);

                    if($response['status']==201) {

                        // create order
                        $order = new \LP_Order();
                        $order->set_user_id( $_POST['user_id'] );
                        $order->update_status();
                        $order->add_item( $_POST['course_id'] );
                        $order->save();
                        learn_press_update_order_items( $order->get_id() );

                        if($allow||$tax_price) {

                            $order->set_subtotal($price);
                            $order->set_total($price);
                            $order->save();

                            if($_POST['coupon']) update_post_meta( $order->get_id(), 'coupon', $_POST['coupon'] );
                            
                        }

                        update_post_meta( $order->get_id(), 'method_title', $_POST['payment_method'] );

                        if($response['id']) update_post_meta( $order->get_id(), 'paypal_order_id', $response['id'] );

                        $data = array(
                            'update'=>true,
                            'response'=>$response,
                            'payment_method' => $_POST['payment_method'],
                        );

                    }

                }


            } else if(

                $_POST['course_type']=='premium') {


                $premium_title = get_field('premium_title','options') ?: __('Accès Premium sans aucune limite','sage');
                $premium_price = get_field('premium_price','options') ? (int)get_field('premium_price','options') : 320;

                if($precent = get_field('c_tax_2','options')) {
                    $precent = (int)$precent;

                    $tax_price = ($premium_price/100)*$precent;

                    $premium_price = $premium_price+$tax_price;
                }
                




                if($_POST['coupon']) {
                    // $stripe = new StripeHandler();
                    // $allow = $stripe->checkCoupon($_POST['coupon']);
                    $allow=false;
                    $posts = get_posts([
                        'post_type' => 'coupons',
                        'numberposts' => 1,
                        'fields' => 'ids',
                        'meta_key'   => 'stripe_coupon_id',
                        'meta_value' => $_POST['coupon'],
                    ]); wp_reset_postdata(  );
                    if($posts) {
                        $percent_off = get_field('percent_off',$posts[0]);
                        $allow=true;
                        if($percent_off) {
                            $percent_off=(int)$percent_off;
                            $discount = ($percent_off / 100) * $premium_price;
                            $new_price = $price - $discount;

                            $format_new_price = number_format($new_price, 2, '.', '');
                            $format_discount = number_format($discount, 2, '.', '');

                        }
                    }
                }

                $item = [
                    'title' => $premium_title,

                    'value' => $premium_price - $discount,
                    'currency' => $currency,
                    'd' => $discount,
                ];

                $response = $paypal->createSubscription($item,$ty_page,$c_page);

               //    $response = $paypal->createSubscription($item,'',$c_page);



                if($response['status']==201) {f

                    $order = new \LP_Order();
                    $order->set_user_id( $_POST['user_id'] );
                    $order->update_status();
                    $order->save();
                    $order->set_subtotal($premium_price);
                    $order->set_total($premium_price);
                    update_post_meta( $order->get_id(), 'is_premium', 1 );
                    update_post_meta( $order->get_id(), '_order_currency', learn_press_get_currency() );
                    update_post_meta( $order->get_id(), '_prices_include_tax', 'no' );
                    update_post_meta( $order->get_id(), '_order_subtotal', $premium_price );
                    update_post_meta( $order->get_id(), '_order_total', $premium_price );
                    update_post_meta( $order->get_id(), '_order_key', learn_press_generate_order_key() );
                    update_post_meta( $order->get_id(), '_payment_method', '' );
                    update_post_meta( $order->get_id(), '_payment_method_title', '' );
                    update_post_meta( $order->get_id(), '_order_version', '1.0' );

                    update_post_meta( $order->get_id(), 'paypal_plan_id', $response['id'] );
                    update_post_meta( $order->get_id(), 'method_title', $_POST['payment_method'] );

                    $data = array(
                        'update'=>true,
                        'response'=>$response,
                        'payment_method' => $_POST['payment_method'],
                    );

                }

            }
                
            
            
        }
        
        if(empty($data))
            $data = array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Unknow payment method','sage').'</p>',
            );

        echo json_encode($data);

        wp_die();

    }


    public function ajax_template_part()
    {

        if(!empty($_POST['template'])&&!empty($_POST['id'])) {

            
            $output_html = template('partials.'.$_POST['template'],['id'=>$_POST['id']]);

            $data = array(
                'update'=>true,
                'output_html'=>$output_html,
            );
        }
        
        if(empty($data))
            $data = array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Unknow user','sage').'</p>',
            );

        echo json_encode($data);

        wp_die();

    }


    public function ajax_quiz()
    {

        if(is_user_logged_in()&&!empty($_POST['user_id'])) {

            $lesson_id = $_POST['user_id'];
            $user_id = $_POST['user_id']?:get_current_user_id();

            $quiz=[];

            if($_POST['pregnant_question']&&$_POST['pregnant_answer']) {
                $question = $_POST['pregnant_question'] ?: '';
                $answer = $_POST['pregnant_answer'] ?: '';
                $option = $_POST['pregnant_date']&&$answer=='yes' ? ' - ' . $_POST['pregnant_date'] : '';
                $quiz[] = [
                    'question' => $question,
                    'answer' => $answer.$option,
                ];

                if($_POST['pregnant_date']&&$answer=='yes') {
                    $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'decembre');
                    $date_arr = explode(' ', $_POST['pregnant_date']);
                    $month_number = array_search(strtolower($date_arr[1]),$french_months);
                    ++$month_number;
                    $month_number = str_pad($month_number, 2, '0', STR_PAD_LEFT); 
                    $formated_date = $date_arr[2].'-'.$month_number.'-'.$date_arr[0];
                    update_user_meta( $user_id, 'dob', $formated_date );
                }
            }

            if($_POST['children_question']&&$_POST['children_answer']) {
                $children_options = ['1 enfant','2 enfants','3 enfants','4 enfants','plus d\'enfants'];
                $question = $_POST['children_question'] ?: '';
                $answer = $_POST['children_answer'] ?: '';
                $children_option_number = $_POST['children_option'] ? (int)$_POST['children_option'] : '';
                $option = $children_option_number&&$answer=='yes' ? ' - ' . $children_options[($children_option_number-1)] : '';
                $quiz[] = [
                    'question' => $question,
                    'answer' => $answer.$option,
                ];

                if($children_option_number&&$answer=='yes') {
                    if($children_option_number>0||$children_option_number<4){
                        $children=[];
                        for ($i=0; $i < $children_option_number; $i++) { 
                            $children[]=[
                                'gender' => 'female',
                                'child_name' => '',
                                'child_age' => '',
                            ];
                        }
                        update_field('children', $children, 'user_'.$user_id);
                    }
                }

            }
            

            if($_POST['quiz'])
            foreach($_POST['quiz'] as $key => $value) {
                $question = $value['question'] ?: 'question-'.(++$key);
                $answer = $value['answer'] ?: '';
                $option = $value['option'] && $value['answer']!='no' ? ' - ' . $value['option'] : '';
                $quiz[] = [
                    'question' => $question,
                    'answer' => $answer.$option,
                ];
            }

            $test = update_field( 'quiz', $quiz, 'user_'.$user_id );

            $redirect = get_field('profile_info_page','options') ? get_permalink( get_field('profile_info_page','options') ) : get_home_url(  );

            $data = array(
                'update'=>true,
                'redirect'=>$redirect,
            );
        }
        
        if(empty($data))
            $data = array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Unknow user','sage').'</p>',
            );

        echo json_encode($data);

        wp_die();

    }
    

    public function upd_course_progress()
    {

        if(is_user_logged_in()&&!empty($_POST['progress'])&&!empty($_POST['course_id'])&&!empty($_POST['lesson_id'])) {

            $lesson_id = $_POST['lesson_id'];
            $course_id = $_POST['course_id'];
            $progress = $_POST['progress'];
            $user_id = get_current_user_id();

            $data_str = get_field('courses_progress','user_'.$user_id );
            $data_arr = $data_str ? json_decode($data_str,true) : [];
            
            $upd_data_arr = [
                $course_id => [
                    $lesson_id => $progress,
                ],
            ];
            $new_data_arr = array_replace_recursive((array)$data_arr, (array)$upd_data_arr );

            if(!empty($new_data_arr)&&is_array($new_data_arr))
            update_field( 'courses_progress', json_encode($new_data_arr), 'user_'.$user_id );

            $data = array(
                'update'=>true,
            );
        }
        
        if(empty($data))
            $data = array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Unknow error','sage').'</p>',
            );

        echo json_encode($data);

        wp_die();

    }
    

    public function post_handler()
    {


        $output_html = '';
        $btn_html = '';
        $post_type = $_GET['post_type'];
        $post_status = $_GET['post_status']?:'publish';
        $part = 'partials.content-'.$post_type;
        $btn_title = 'VOIR TOUS LES COURS';
        $additional_args_arr=[];
        if($_GET['post_status']){
            $additional_args_arr['post_status'] = $post_status = $_GET['post_status'];
        }
        if($_GET['part']) {
            $additional_args_arr['part'] = $part = $_GET['part'];
        }
        if($_GET['btn_title']) {
            $additional_args_arr['btn_title'] = $btn_title = $_GET['btn_title'];
        }
		
        $paged = $_GET['page'] ? (int)$_GET['page'] : 1;

		$args = array(
			'post_type' => $post_type,
            'paged' => $paged,
            'post_status' => $post_status,
        );

        $posts_per_page = $_GET['posts_per_page'] ? (int)$_GET['posts_per_page'] : get_option( 'posts_per_page' );
		if($posts_per_page) $args['posts_per_page'] = $posts_per_page;
		if($_GET['post__in'])
		    $additional_args_arr['post__in'] = $args['post__in'] = $_GET['post__in'];


        if(is_user_logged_in(  )&&$post_status=='publish') {
			$posts = get_posts([
				'post_type' => $post_type,
				'numberposts' => -1,
				'fields' => 'ids',
			]); wp_reset_postdata(  );
	
			$posts = lp_reorder_enrolled_courses($posts);

//			if ($post_type != 'specialists')
//			    $args['post__in'] = $posts;
			$args['orderby'] = 'post__in';
		}









        $tax_query=[];
        $taxonomies=get_object_taxonomies($post_type)?:[];
        if($taxonomies)
        foreach($taxonomies as $taxonomy) {
            if(isset($_GET[$taxonomy])&&!empty($_GET[$taxonomy])){
                $tax_query[] = [
                    'taxonomy' => $taxonomy,
                    'terms' => $_GET[$taxonomy],
                ];
            }
        }
        if(!empty($tax_query)) $args['tax_query']=$tax_query;



        if ($post_type == 'specialists') {
          $args['orderby'] = 'menu_order';
//            $args['order'] == 'ASC';
//            unset($args['post__in']);

            $args['paged'] = $paged;

        }


        $loop = new \WP_Query($args);
		if ( $loop->have_posts() ) {
            
            while ( $loop->have_posts() ) { $loop->the_post();

                if($post_type=="lp_course"&&$post_status=='publish') {
                    ob_start();



                        learn_press_get_template_part( 'content', 'course' );

                    $output_html .= ob_get_clean();


                } else {
                    $output_html .= template($part);

                   
                }

            }
            wp_reset_postdata(); 
        } else {
            $output_html .= template('partials.content-none');
        }

        if(!empty($additional_args_arr))
        foreach($additional_args_arr as $key => $value) {
            $additional_args[]=sprintf('data-%s="%s"',$key,$value);
        }
        $additional_args=$additional_args?implode(' ',$additional_args):'';

        if ($loop->max_num_pages>$paged):
            $new_page=$paged;
            $btn_html .= sprintf('<a href="#" class="underline-btn load_more" data-post_type="%s" data-page="%s" data-posts_per_page="%s" data-action="post_handler" %s>%s</a>',
            $post_type,
            ++$new_page,
            $posts_per_page,
            $additional_args,
            $btn_title);
        endif;

        $data = array(
            'update'=>true, 
            'output_html' => $output_html,
            'btn_html' => $btn_html,
        );

        echo json_encode($data);

        wp_die();
    }


    public function ajax_registration()
    {

        // First check the nonce, if it fails the function will break
      //  check_ajax_referer( 'ajax-registration-nonce', 'security' );

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array(
                'update'=>false, 
                'status' => '<p class="error">Email address '.$_POST['email'].' is incorrect</p>',
            ));
            wp_die();
        }
    
        if($_POST['email']&&$_POST['password'] &&$_POST['password2']) {

            if ($_POST['password'] !== $_POST['password2'])   {
                $data = array(
                    'update'=>false,
                    'status' => '<p class="error">'.__('Les mots de passe ne correspondent pas','sage').'</p>',
                );
                echo json_encode($data);

                wp_die();
            }


            if (strlen($_POST['password']) < 8) {
                $data = array(
                    'update'=>false,
                    'status' => '<p class="error">' .__('Votre mot de passe doit contenir au moins 8 caractères','sage').'</p>',
                );
                echo json_encode($data);

                wp_die();
            }

            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role']?:'subscriber';
            $login = explode('@',$email)[0];
            $i=1;

            while (username_exists( $login )) {
                ++$i;
                $login = $login.$i;
            }

            $user = get_user_by('email', $email);

            
            if(empty($user)){

                $user_data = [
                    'user_login' => $login,
                    'user_pass'  => $password,
                    'user_email' => $email,
                    'role'  => $role,
                    'show_admin_bar_front' => false,
                    'first_name' => $_POST['name'],
                    'last_name' => $_POST['last_name']
                ];
            
                $user_id = wp_insert_user($user_data);
                update_field('pregnant', $_POST['pregnant'], 'user_' . $user_id);
                update_field('phone', $_POST['phone'], 'user_' . $user_id);


                if($user_id) {

                    // $fields=['billing_phone','billing_first_name','billing_last_name','billing_email'];

                    // if($fields)
                    // foreach($fields as $field) {
                    //     if(!isset($_POST[$field])&&!empty($_POST[$field])) continue;
                    //     update_user_meta( $user_id, $field, $_POST[$field] );
                    // }

                    $redirect = get_permalink( 340 ) ?: get_home_url(  );
                    $gtm = 0;
                    if ($_POST['c']) {

                        $redirect = get_permalink((int)$_POST['c']);
                        $gtm = 1;

                    }

                    if($_POST['newsletter']) update_user_meta( $user_id, 'newsletter', $_POST['newsletter'] );

                    $data = array(
                        'update'=>true, 
                        'status' => '<p class="success">'.__('Registration completed successfully','sage').'</p>',
                        'redirect' => $redirect,
                        'user_id' => $user_id,
                        'gtm' => $gtm
                    );


                    if($user = get_user_by( 'id', $user_id )) {
                        wp_set_current_user( $user->ID );
                        wp_set_auth_cookie( $user->ID, true );
                        do_action( 'wp_login', $user->user_login, $user );
                    }

                    $user_name = get_userdata($user_id)->first_name ?: $login;
                    

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


                    if ($_POST['c']) {

                        if (get_field('_lp_price', $_POST['c']) > 0)
                        {

                        }
                        else  {

                            $order = new \LP_Order();
                            $order->set_user_id( $user_id );
                            $order->update_status( 'completed' );
                            $order->add_item( (int)$_POST['c'] );
                            $order->save();


                            learn_press_update_order_items( $order->get_id() );

                            $this->add_profil_order($order->get_id(),$user_id);
                        }

                    }
                }
                
            } else {
                $data = array(
                    'update'=>false, 
                    'status' => '<p class="error">'.__('<br>Un compte existe déjà pour cette adresse email. Identifiez-vous ou utilisez un mot de passe oublié','sage').'</p>',
                );
            }
        } else {
            $data = array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Email and password fields are required','sage').'</p>',
            );
        }

        if(empty($data))
            $data = array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Unknow error','sage').'</p>',
            );

        echo json_encode($data);
        
        wp_die();
    }


    public function ajax_login()
    {

        // First check the nonce, if it fails the function will break
        check_ajax_referer( 'ajax-login-nonce', 'security' );
    
        // Nonce is checked, get the POST data and sign user on
        $email = $_POST['email'];
        $password = $_POST['password'];
       
        $auth = wp_authenticate( $email, $password );
        $redirect = ($_COOKIE['return_to_plan'] || $_GET['return']) && get_field('choose_plan_page','options') ?
            get_permalink( get_field('choose_plan_page','options') ) . '?l=1'
            //'/choisissez-votre-option-upd/?l=1'
            : get_home_url();
    
        if ( is_wp_error( $auth ) ) {
            $data = array(
                'update' => false, 
                'status' => '<p class="error">'.__('Profil inconnu: veuillez vérifier votre identifiant ou votre mot de passe','sage').'</p>' ,
            );
        }
        else {

            if ($_POST['c']) {

                $redirect = get_permalink((int)$_POST['c']);

            }

            wp_set_current_user( $auth->ID );
            wp_set_auth_cookie( $auth->ID, true );
            do_action( 'wp_login', $auth->user_login, $auth );
            $data = array(
                'update' => true, 
                'status' => '<p class="success">'.__('Please wait...','sage').'</p>',
                'redirect' => $redirect,
            );
        }

        if(empty($data))
            $data = array(
                'update'=>false, 
                'status' => '<p class="error">'.__('Unknow error','sage').'</p>',
            );

        echo json_encode($data);
        
        wp_die();
    }


    public function validate_email() {
        if (($_GET['email'])) {
            if (!email_exists($_GET['email']))
                echo "true";
            else
                echo "false";

        }

        die();
    }

}

new Ajax();



// add_action('init', function (  ) {

    

//     if( $_GET['add_order'] ) {
//         $ajax = new Ajax();

//         $args = [
//             'date_end' => date('d/m/Y',strtotime('2'.' month')),
//         ];
//         $ajax->add_profil_order(1427,1,$args);
//     }

// });