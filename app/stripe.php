<?php

namespace App;
use Stripe\Stripe;


class StripeHandler
{

    private $publishable_key;
    private $secret_key;
    private $stripe;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->publishable_key = get_field('stripe_publishable_key_test','options');
        $this->secret_key = get_field('stripe_secret_key_test','options');

//        $this->publishable_key = 'pk_test_51Ir22sLGWTRPugoEgsgGKmKjasJZL9zMMKQd29DFYBTyBlZ5omu7NuABK83YFojLQBL0KAMaySq93It8wn40Udx900MJU106Bx';
//        $this->secret_key = 'sk_test_51Ir22sLGWTRPugoEbxgvdrH0OUVLyWETJAfbjFnIl0ktw1N8VqjaOMcUlnu0gt28JUXnQfRLRR6abvxelyG3OX1P00tUDJgVIl';



        $this->stripe = new \Stripe\StripeClient($this->secret_key);
    }


    public function create_webhook ($args=[]) {

        $response = $this->stripe->webhookEndpoints->create(wp_parse_args( $args, [
            'url' => 'https://example.com/my/webhook/endpoint',
            'enabled_events' => [
              'payment_intent.succeeded',
            ],
        ] ));

        return $response?$response->id:null;

    }


    public function webhook () {

        \Stripe\Stripe::setApiKey($this->secret_key);
        
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        return $event;
    }


    public function createCheckoutSession($args=[], $order_id='') {

        $default_args = [
            'success_url' => get_home_url(  ),
            'cancel_url' => get_home_url(  ),
            'payment_method_types' => ['card'],
            'line_items' => [],
            'mode' => 'payment',
            'client_reference_id' => $order_id
        ];
        
        $checkout_session = $this->stripe->checkout->sessions->create(wp_parse_args( $args, $default_args ));

        return [
            'checkoutSessionId' => $checkout_session['id'],
            'payment_intent' => $checkout_session['payment_intent'],
        ];

    }


    public function createCoupon($args=[]) {
        
        $coupon = $this->stripe->coupons->create(wp_parse_args( $args, array(
            'percent_off' => 25,
            'duration' => 'once',
        ) ));

        return $coupon->id?:false;

    }


    public function retrieveCoupon($coupon_id='') {
        
        $coupon = $this->stripe->coupons->retrieve($coupon_id, []);

        return $coupon;

    }

    public function checkCoupon($coupon_id='') {

        $allow = false;
        $coupons = $this->stripe->coupons->all();

        if($coupons->data) {
            foreach($coupons->data as $coupon){
                if($coupon->id==$coupon_id) $allow=true;
            }
        }
        
        return $allow;
    }    


    public function createProduct($prod_args=[],$price_args=[]) {

        $return=[];

        if(!empty($prod_args)&&!empty($price_args)) {

            $product = $this->stripe->products->create(wp_parse_args( $prod_args, array(
                'name' => 'Test Product',
            ) ));

            $return['product_id'] = $product->id;

            $price = $this->stripe->prices->create(wp_parse_args( $price_args, array(
                'unit_amount' => 2000,
                'currency' => 'eur',
                'product' => $product->id,
            ) ));

            $return['price_id'] = $price->id;

        }

        return !empty($return) ? $return : false;

    }


    public function hasPrice($price_id='') {
        
        $return = false;

        $prices = $this->stripe->prices->all([]);

        foreach($prices->data as $price_obj) {
            
            if($price_obj->id==$price_id) {
                $return = true;
                break;
            }
        }

        return $return;

    }


    public function getSubscription($sub_id='') {
        
        if(empty($sub_id)) {
            return false;
        }

        $response = $this->stripe->subscriptions->retrieve(
            $sub_id,
            []
        );

        return $response;

    }


    public function getCustomer($customer_id='') {
        
        if(empty($customer_id)) {
            return false;
        }

        $response = $this->stripe->customers->retrieve(
            $customer_id,
            []
        );

        return $response;

    }

    

    public function getEevent($event_id='') {
        
        if(empty($event_id)) {
            return false;
        }

        $response = $this->stripe->events->retrieve(
            $event_id,
            []
        );

        return $response;

    }


    public function getTaxId($percentage=null) {

        if(!$percentage) {
            return false;
        }

        $tax_id = '';

        $taxes_list = $this->stripe->taxRates->all();

        $taxes_list = $taxes_list->data;

        if($taxes_list)
        foreach($taxes_list as $tax) {
            if($tax->percentage==$percentage) {
                $tax_id = $tax->id;
                break;
            } 
        }

        if(empty($tax_id)) {
            $response = $this->stripe->taxRates->create([
                'display_name' => "TVA",
                'description' => 'TVA created automatically',
                'jurisdiction' => 'FR',
                'percentage' => (int)$percentage,
                'inclusive' => false,
            ]);

            $tax_id = $response ? $response->id : '';
        }

        return $tax_id ?: false;
    }


    public function init() {
        $stripe = $this->createSession();
    }
    
 
}

// add_action('init',function() {
//     if($_GET['go']) {
//         $stripe = new StripeHandler();

//         $ty_page = get_field('thank_you_page','options') ? get_permalink( get_field('thank_you_page','options') )  : get_home_url(  );
//         $c_page = get_field('choose_plan_page','options') ? get_permalink( get_field('choose_plan_page','options') ) : get_home_url(  );
//         $items[]=[
//             'price' => 'price_1Iv40SLGWTRPugoEb9HEiPal',
//             'quantity' => 1,
//             'tax_rates' => ['txr_1JEu5qLGWTRPugoEyzQghxgR'],
//         ];

//         // $mode = 'subscription';
//         $mode = 'payment';

//         // tax_id_collection
       

//         $session_args = [
//             'success_url' => $ty_page,
//             'cancel_url' => $c_page,
//             'payment_method_types' => ['card'],
//             'line_items' => $items,
//             'mode' => $mode,
//             'customer_email' => 'jubileewinsthere@gmail.com',
//         ]; 
        
//         // $response = $stripe->createCheckoutSession($session_args);
//         // $response = $stripe->getEevent('evt_1IzkUULGWTRPugoEuj1UUs0R');

//         // // start sub strtotime
//         // $created = $response->data->object->current_period_start;

//         // txr_1JEu5qLGWTRPugoEyzQghxgR

//         // $response = $stripe->getCustomer('cus_Jd0V2gPIr3HVAk');
//         // $response = $stripe->checkCoupon('CY0SKFAr');
//         $response = $stripe->getTaxId(10);

//         echo '<pre>';
//         var_dump($response);
//         echo '</pre>';
//     }
// });