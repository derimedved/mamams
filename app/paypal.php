<?php

namespace App;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersAuthorizeRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use \PayPal\Api\VerifyWebhookSignature;
use \PayPal\Api\WebhookEvent;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use PayPal\Api\Cost;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\PayerInfo;
use PayPal\Api\ShippingAddress;



class PayPalHandler
{

    private $clientId;
    private $clientSecret;
    private $client;
    // Sandbox account
    // sb-6dgih1239043@business.example.com

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->clientId = get_field('paypal_client_id','options');
        $this->clientSecret = get_field('paypal_client_secret','options');

        if(get_field('paypal_test_mode','options')) {
            $this->clientId = 'ASVkUYKOeBAAhMnsJ8nZYrbF2UNBZa2ljxe_V3Fif2G3_V317G9A8WbkVE4DNME--rq3QxQJRNN78utE';
            $this->clientSecret = 'EOn6kBsiQbcM6Z8kwLBqBfDjUBgV11v3NVVsxPPE-MK4burpqCFyWyz2MpNJrGG-94SBs1qGZGSLQcy0';

            $environment = new SandboxEnvironment($this->clientId, $this->clientSecret);
        } else {
            $environment = new ProductionEnvironment($this->clientId, $this->clientSecret);
        }
        

        
        $this->client = new PayPalHttpClient($environment);
    }

    function getApiContext($clientId, $clientSecret)
    {

        // #### SDK configuration
        // Register the sdk_config.ini file in current directory
        // as the configuration source.
        /*
        if(!defined("PP_CONFIG_PATH")) {
            define("PP_CONFIG_PATH", __DIR__);
        }
        */

        $mode = get_field('paypal_test_mode','options') ? 'sandbox' : 'live';


        // ### Api context
        // Use an ApiContext object to authenticate
        // API calls. The clientId and clientSecret for the
        // OAuthTokenCredential class can be retrieved from
        // developer.paypal.com

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );

        // Comment this line out and uncomment the PP_CONFIG_PATH
        // 'define' block if you want to use static file
        // based configuration

        $apiContext->setConfig(
            array(
                'mode' => $mode, // live sandbox
                'log.LogEnabled' => true,
                'log.FileName' => '../PayPal.log',
                'log.LogLevel' => 'FINE', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled' => true,
                //'cache.FileName' => '/PaypalCache' // for determining paypal cache directory
                // 'http.CURLOPT_CONNECTTIMEOUT' => 30
                // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
                //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
            )
        );

        // Partner Attribution Id
        // Use this header if you are a PayPal partner. Specify a unique BN Code to receive revenue attribution.
        // To learn more or to request a BN Code, contact your Partner Manager or visit the PayPal Partner Portal
        // $apiContext->addRequestHeader('PayPal-Partner-Attribution-Id', '123123123');

        return $apiContext;
    }


    public function deleteAllWebhooks () {

        $apiContext = $this->getApiContext($this->clientId, $this->clientSecret);

        $webhookList = $this->getAllWebhooks();

        // ### Delete Webhook
        try {
            foreach ($webhookList->getWebhooks() as $webhook) {
                $webhook->delete($apiContext);
            }
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {

            var_dump($ex);
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            // ResultPrinter::printError("Deleted all Webhooks", "WebhookList", null, null, $ex);
            exit(1);
        }

    }

    public function getAllWebhooks () {

        $apiContext = $this->getApiContext($this->clientId, $this->clientSecret);

        try {
            $output = \PayPal\Api\Webhook::getAll($apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            // ResultPrinter::printError("List all webhooks", "WebhookList", null, $webhookId, $ex);
            $output = [
                'status' => 400,
                'message' => $ex->getMessage(),
            ];
        }

        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        // ResultPrinter::printResult("List all webhooks", "WebhookList", null, null, $output);

        return $output;
    }



    public function create_webhook ($url='') {

        $apiContext = $this->getApiContext($this->clientId, $this->clientSecret);

        $return = [];

        if(!empty($url)) {
            $webhook = new \PayPal\Api\Webhook();
            $output_id = false;

            // Set webhook notification URL
            $webhook->setUrl($url);
    
            // Set webhooks to subscribe to
            $webhookEventTypes = array();
            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
            '{
                "name":"CHECKOUT.ORDER.APPROVED"
            }'
            );
            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
            '{
                "name":"PAYMENT.SALE.COMPLETED"
            }'
            );
            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
            '{
                "name":"BILLING.SUBSCRIPTION.ACTIVATED"
            }'
            );

            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"BILLING.SUBSCRIPTION.CREATED"
            }'
            );
            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
            '{
                "name":"BILLING.PLAN.ACTIVATED"
            }'
            );

            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"BILLING.SUBSCRIPTION.PAYMENT.FAILED"
            }'
            );



            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"BILLING.SUBSCRIPTION.CANCELLED"
            }'
            );

            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"BILLING.SUBSCRIPTION.SUSPENDED"
            }'
            );

            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"PAYMENT.ORDER.CANCELLED"
            }'
            );

            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"PAYMENT.SALE.DENIED"
            }'
            );

            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"PAYMENT.SALE.PENDING"
            }'
            );

            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"PAYMENT.SALE.REFUNDED"
            }'
            );

            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"PAYMENT.SALE.REVERSED"
            }'
            );


            $webhookEventTypes[] = new \PayPal\Api\WebhookEventType(
                '{
                "name":"INVOICING.INVOICE.CANCELLED"
            }'
            );





















    
            $webhook->setEventTypes($webhookEventTypes);

            // // For Sample Purposes Only.
            $request = clone $webhook;

            // ### Create Webhook
            try {
                
                $output = $webhook->create($apiContext);

                $return = [
                    'status' => $output->statusCode,
                    'id' => $output->id,
                ];

            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                // ^ Ignore workflow code segment
                if ($ex instanceof \PayPal\Exception\PayPalConnectionException) {

                    $data = $ex->getData();

                    $this->deleteAllWebhooks();

                    try {
                        $output = $webhook->create($apiContext);

                        $return = [
                            'status' => $output->statusCode,
                            'id' => $output->id,
                        ];

                    } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                        $return = [
                            'status' => 400,
                            'message' => $ex->getMessage(),
                            'data   ' => $ex->getData(),
                        ];
                    }

                } else {
                    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                    $return = [
                        'status' => 400,
                        'message' => $ex->getMessage(),
                        'data   ' => $ex->getData(),
                    ];
                    
                }
                // Print Success Result

            }


        }

        return $return;

    }

    
    public function webhook() {

        $payload = @file_get_contents('php://input');



        return json_decode($payload, true);

    }


    
    public function createOrder($item=[],$context=[]) {

        $return = [];

        $item = wp_parse_args( $item, [
            "amount" => [
                "value" => "100.00",
                "currency_code" => "USD"
            ]
        ]  );

        $context = wp_parse_args( $context, [
            "cancel_url" => get_home_url(  ),
            "return_url" => get_home_url(  ),
        ]  );

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        
        
        $request->body = [
            "intent" => "CAPTURE",  // CAPTURE || AUTHORIZE
            "purchase_units" => [$item],
            "application_context" => $context,
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);

            $links=[];
            
            foreach($response->result->links as $link)
            {
                $links[$link->rel] = $link->href;
            }

            $return = [
                'status' => $response->statusCode,
                'id' => $response->result->id,
                'link' => $links['approve'],
            ];
            
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            return $return;

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();

            
            return [
                'status' => $ex->statusCode,
                'message' => $ex->getMessage(),
            ];
            exit();
        }
    }



    /**
     * This function can be used to retrieve an order by passing order Id as argument.
     */
    public function getOrder($orderId)
    {
        
        // $client = PayPalClient::client();
        $response = $this->client->execute(new OrdersGetRequest($orderId));
        /**
         * Enable below line to print complete response as JSON.
         */
        //print json_encode($response->result);
        print "Status Code: {$response->statusCode}\n";
        print "Status: {$response->result->status}\n";
        print "Order ID: {$response->result->id}\n";
        print "Intent: {$response->result->intent}\n";
        print "Links:\n";
        foreach($response->result->links as $link)
        {
            print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
        }

        print "Gross Amount: {$response->result->purchase_units[0]->amount->currency_code} {$response->result->purchase_units[0]->amount->value}\n";

        // To toggle printing the whole response body comment/uncomment below line
        echo json_encode($response->result, JSON_PRETTY_PRINT), "\n";
    }


    public function getAgreementState($token='') {

        $apiContext = $this->getApiContext($this->clientId, $this->clientSecret);

        $agreement = new \PayPal\Api\Agreement();

        try {
            $agreement->execute($token, $apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // echo "Failed to get activate";

            // var_dump($ex);
            return false;
            exit();
        }

        $agreement = Agreement::get($agreement->getId(), $apiContext);
        $details = $agreement->getAgreementDetails();
        $state = $agreement->getState() ?: false;
        // $next_billing_date = strtotime($details->next_billing_date);
        $next_billing_date = strtotime("+13 month");


        return [
            'state' => $state,
            'next_billing_date' => $next_billing_date,
        ];

    }


    public function createPlan($item=[],$return_url='',$cancel_url='',$apiContext) {

        // $apiContext = $this->getApiContext($this->clientId, $this->clientSecret);

        $item = wp_parse_args( $item, [
            'title' => 'T-Shirt of the Month Club Plan',
            'value' => 320,
            'currency' => 'USD',
            'shipping' => 0,
        ]  );

        $plan = new Plan();

        $plan->setName($item['title'])
            ->setDescription('Template creation.')
            ->setType('infinite');

        $paymentDefinition = new PaymentDefinition();

        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('YEAR')
            ->setFrequencyInterval("1")
            ->setAmount(new Currency(array('value' => $item['value'], 'currency' => $item['currency'])));

        $chargeModel = new ChargeModel();
        $chargeModel->setType('SHIPPING')
            ->setAmount(new Currency(array('value' => $item['shipping'], 'currency' => $item['currency'])));

        $paymentDefinition->setChargeModels(array($chargeModel));

        $merchantPreferences = new MerchantPreferences();

        $merchantPreferences->setReturnUrl($return_url)
            ->setCancelUrl($cancel_url)
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0")
            ->setSetupFee(new Currency(array('value' => $item['value'], 'currency' => $item['currency'])));

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);

        try {
    

            $cPlan = $plan->create($apiContext);

//             $log = get_field('paypal_test', 'options');
//             update_field( 'paypal_test', $log. 'cPlan --- '. $cPlan->getId(), 'options' );
        
            try {
        
                $patch = new Patch();
        
                $value = new PayPalModel('{"state":"ACTIVE"}');
                $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
        
                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);
        
                $cPlan->update($patchRequest, $apiContext);
                $cPlan = Plan::get($cPlan->getId(), $apiContext);
        
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            }
        
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
  
            exit();
        }

        return $cPlan;
    }



    public function createSubscription($item=[],$return_url='',$cancel_url='') {

        $apiContext = $this->getApiContext($this->clientId, $this->clientSecret);


        $cPlan = $this->createPlan($item,$return_url,$cancel_url,$apiContext);
        

        $agreement = new Agreement();

        $agreement->setName('Base Agreement')
            ->setDescription('Basic Agreement')
            ->setStartDate(date('c',strtotime('+1 year')));

        $plan = new Plan();

        $plan->setId($cPlan->getId());
        $agreement->setPlan($plan);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        // $shippingAddress = new ShippingAddress();
        // $shippingAddress->setLine1('111 First Street')
        //     ->setCity('Saratoga')
        //     ->setState('CA')
        //     ->setPostalCode('95070')
        //     ->setCountryCode('US');

        // $agreement->setShippingAddress($shippingAddress);

        try {
            $agreement = $agreement->create($apiContext);

            $approvalUrl = $agreement->getApprovalLink();

            $get_plan = $agreement->getPlan( );

            $id = $get_plan->getId( );

            $details = $agreement->getAgreementDetails();

            $return = [
                'status' => 201,
                'id' => $id,
                'link' => $approvalUrl,
            ];

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            $return = [
                'status' => $ex->getCode(),
                'data' => $ex->getData(),
                'message' => "Failed to get activate",
            ];
        }

        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        // ResultPrinter::printResult("Created Billing Agreement. Please visit the URL to Approve.", "Agreement", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $agreement);

        return $return;


    }

    

    public function init() {
        echo 'test';
    }


    public function getPlanList() {

        $apiContext = $this->getApiContext($this->clientId, $this->clientSecret);

        try {
            // Get the list of all plans
            // You can modify different params to change the return list.
            // The explanation about each pagination information could be found here
            // at https://developer.paypal.com/docs/api/#list-plans
            $params = array('page_size' => '2');
            $planList = Plan::all($params, $apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            // ResultPrinter::printError("List of Plans", "Plan", null, $params, $ex);
            var_dump($ex);
            exit(1);
        }
        
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        //  ResultPrinter::printResult("List of Plans", "Plan", null, $params, $planList);
        
        return $planList;

    }


    public function getPlanInfo($planId) {

        var_dump($planId);

        $apiContext = $this->getApiContext($this->clientId, $this->clientSecret);

        try {
            $plan = Plan::get($planId, $apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            // ResultPrinter::printError("Retrieved a Plan", "Plan", $plan->getId(), null, $ex);
            var_dump($ex);
            exit(1);
        }
        
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        //  ResultPrinter::printResult("Retrieved a Plan", "Plan", $plan->getId(), null, $plan);
        
        return $plan;

    }
    

    public function ListPayments() {

        $apiContext = $this->getApiContext($this->clientId, $this->clientSecret);

        try {
            $params = array('count' => 10);

            var_dump($params);
        
            $payments = Payment::all($params, $apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            // ResultPrinter::printError("List Payments", "Payment", null, $params, $ex);
            var_dump($ex);
            exit(1);
        }
        
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        //  ResultPrinter::printResult("List of Plans", "Plan", null, $params, $planList);
        
        return $planList;

    }


    public function captureOrder($orderId, $debug=true)
    {
        $request = new OrdersCaptureRequest($orderId);
        $request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);

            $return = [
                'id' => $response->result->id,
                'status' => $response->result->status
            ];

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            // print_r($response);

        } catch (\PayPalHttp\HttpException $e) {
            // echo $e->getMessage();
            return false;
            exit();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) { // HttpException
            // echo $ex->statusCode;
            // print_r($ex->getMessage());
            return false;
            exit();
        }

        return $response ? $return : false;

    }
 
}
