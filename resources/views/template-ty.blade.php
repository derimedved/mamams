{{-- 
    Template Name: ty Template 
--}}

 
@php
$type = false;

if(!empty($_GET['token'])) {
    $token = $_GET['token'];
    $type = $_GET['paypal_capture_order'] ? 'order' : 'plan';
}

if ($type=='order') {

    $paypal = new App\PayPalHandler();
    $resp = $paypal->captureOrder($token);

  //  print_r($resp);

    if($resp&&$resp['status']=='COMPLETED') {
        // success
    }
    
}

if ($type=='plan') {

    $paypal = new App\PayPalHandler();
    $resp = $paypal->getAgreementState($token);

  // print_r($resp);

    if($resp){
        
      //  $end_sub = $resp['next_billing_date'] ?: strtotime("+1 month");

        $user_id = get_current_user_id();

        if($resp['state']=='Active'&&$user_id) {
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

            // change status order
            if($order_ids){
                $order = learn_press_get_order( $order_ids[0] );
                $order->update_status( 'completed' );
            }

            if($order) {
            //    wp_schedule_single_event( $end_sub, 'remove_order_event',  array( $order->get_id(), $user_id ) );
            

                // add profile
                $order_id = $order_ids ? $order_ids[0] : '';
                $user_email = $order->get_user_email( );
                $order_total = $order->get_total();
                $currency = function_exists('learn_press_get_currency_symbol') ? learn_press_get_currency_symbol() : '';

                $charges_email = $event['resource']['payer']['email_address'];

                $profile_date_end = date('d/m/Y',$end_sub);
                $profile_coupon = get_field('coupon',$order_id) ?: '';
                $profile_course =  'Premium';
                $profile_mail = $charges_email ?: $user_email;
                $profile_cost = $order_total.$currency;

                $profile_order = [
                    'order_id' => $order_id,
                    'date_start' => date('d/m/Y'),
                    'date_end' => $profile_date_end,
                    'mail' => $profile_mail,
                    'course' => $profile_course,
                    'paid' => $profile_cost,
                    'coupon' => $profile_coupon,
                ];
                $profile = new App\Profile();
                //$profile->profile_add_order($user_id,$profile_order);


                // send mail
                $mailchimp = new App\MailChimpHandler();
                $args = [
                    'email' => $user_email,
                    'subject' => 'Order',
                ];
                $template = 'order-subscription';
                $global_vars = [];
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
                    ],
                ];

                $other_courses=$profile->get_global_vars();
                if(!empty($other_courses)) $global_vars[] = $other_courses;
                
                $response = $mailchimp->send_message($args,$template,$vars,$global_vars);
            }
        }
    }
    
}

@endphp

@extends('layouts.app')

@section('content')

    @while(have_posts()) @php the_post() @endphp

    <main class="text-page login">
      <section data-aos="fade-up">
        <div class="container">
            <h3 style="margin-bottom:30px;">{!! App::title() !!}</h3>
            @php the_content() @endphp
        </div>
      </section>
    </main>
    
  @endwhile

@endsection
