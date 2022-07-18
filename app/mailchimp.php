<?php

namespace App;


class MailChimpHandler
{

    private $apiKey;
    private $mailchimp;
    private $default_sender = 'noreply@ecoledesfuturesmamans.com';
    private $default_template_types = [
        'lost-password',
        'order',
        'order-subscription',
        'soon',
        'subscription',
        'target',
        'welcome',
        'welcome-landing1',
        'welcome-landing2',
    ];


    public function __construct()
    {

        $apiKey = get_field('mailchimp_api_key') ?: 'Ufr1DrEsFCOZKmLqvVqhLQ';
        $this->apiKey = $apiKey; 
        $this->mailchimp = new \MailchimpTransactional\ApiClient();
        $this->mailchimp->setApiKey($apiKey);

    }
    

    public function has_template($name=null)
    {

        $template_name = "template_{$name}";

        $mailchimp = $this->mailchimp;

        $response = $mailchimp->templates->info(["name" => $template_name]);
        
        return $response->name ?: false;

    }


    public function add_template($name = '')
    {

        $template_name = "template_{$name}";
        $template_html = template('mails.mail-' . $name);

        $mailchimp = $this->mailchimp;

        $response = $mailchimp->templates->add([
            'name' => $template_name,
            'from_email' => $this->default_sender,
            'code' => $template_html,
            'publish' => true,
        ]);
        
        return $response;

    }


    public function upd_all_templates()
    {

        $mailchimp = $this->mailchimp;

        foreach($this->default_template_types as $name) {

            $has_template = $this->has_template($name);
            $template_name = "template_{$name}";
            $template_html = template('mails.mail-' . $name);

            $args = [
                'name' => $template_name,
                'from_email' => $this->default_sender,
                'code' => $template_html,
                'publish' => true,
            ];

            if($has_template) {
                $response = $mailchimp->templates->update($args);
            } else {
                $response = $mailchimp->templates->add($args);
            }
            
        }

        return $response ? true : false;

    }


    public function send_message($args=[],$template_name='',$vars=[],$global_vars=[])
    {


        $mailchimp = $this->mailchimp; 

        $email = $args['email'];
        $subject = $args['subject'] ?: '';
        $from_name = $args['from'] ?: get_bloginfo('name');

        $template_name = "template_{$template_name}";

        try {

            $message = [
                // 'subject' => $subject,
                'from_email' => $this->$default_sender,
                'from_name'  => $from_name,
                'to'   => [
                    [
                        'email' => $email,
                    ]
                ],
            ];

            if(!empty($vars)||!empty($global_vars)) $message['merge_language'] = 'handlebars';

            if(!empty($vars)) {
                $message['merge_vars'] = [
                    [
                        'rcpt' => $email,
                        'vars' => $vars,
                    ]
                ];
            }
            if(!empty($global_vars)) {
                $message['global_merge_vars'] = $global_vars;
            }
            
            $response = $mailchimp->messages->sendTemplate([
                "template_name" => $template_name,
                "template_content" => [[
                    'name' => 'test name',
                    'content' => 'test content',
                ]],
                "message" => $message,
            ]);

            return $response;


        } catch (Error $e) {
            echo 'Error: ',  $e->getMessage(), "\n";
        }
    }

}

add_action( 'init', function() {
    if(isset($_GET['send_mail'])) {

        // $course_id = 235;

        $mailchimp = new MailChimpHandler();
        $args = [
            'email' => $_GET['email'] ?: 'jubileewinsthere@gmail.com',
            'subject' => 'test subject',
            'from' => 'test from',
        ];
        $template = $_GET['type'] ?: 'order';
        $vars = [
            [
                'name' => 'name',
                'content' => 'Artem'
            ],
            [
                'name' => 'course_title',
                'content' => 'Youga'
            ],
            [
                'name' => 'course_text',
                'content' => 'Lorem ipsum'
            ],
            [
                'name' => 'course_image',
                'content' => 'https://edfmstaging.wpengine.com/wp-content/themes/mamams/resources/assets/mails/img/img03.jpg'
            ],
            [
                'name' => 'course_link',
                'content' => 'https://edfmstaging.wpengine.com/'
            ],
            
        ];

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
            ],
            [
                "name" => "courses",
                "content" => [
                    [
                        'name' => 'course 1',
                        'text' => 'lorem ipsum',
                        'link' => 'https://edfmstaging.wpengine.com/',
                        'image' => 'https://edfmstaging.wpengine.com/wp-content/uploads/2021/04/main-page-banner1.png',
                    ],
                    [
                        'name' => 'course 2',
                        'text' => 'lorem ipsum 2',
                        'link' => 'https://edfmstaging.wpengine.com/all-courses/nos-premieres-semaines/',
                        'image' => 'https://edfmstaging.wpengine.com/wp-content/uploads/2021/04/main-page-banner2.png',
                    ],
                    [
                        'name' => 'course 3',
                        'text' => 'lorem ipsum 3',
                        'link' => 'https://edfmstaging.wpengine.com/all-courses/la-naissance-en-conscience/',
                        'image' => 'https://edfmstaging.wpengine.com/wp-content/uploads/2021/04/main-page-banner1.png',
                    ]
                ] 
            ]
        ];


        echo '<pre>';
        $response = $mailchimp->send_message($args,$template,$vars,$global_vars);
        var_dump($response);
        echo '</pre>';

    }
    if(isset($_GET['show_mail_type'])) {
        echo template('mails.mail-' . $_GET['show_mail_type']);;
    }
    // if(isset($_GET['upd_mails'])) {

    //     $mailchimp = new MailChimpHandler();
    //     $response = $mailchimp->upd_all_templates();
    // }
} );