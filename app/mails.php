<?php

namespace App;

use Sober\Controller\Controller;

class Mails extends Controller
{
    public function __construct()
    {


    }


    public function send_mail( $email='' , $subject='', $type='', $args=[] )
    {

        if(!empty($email)) {

            $mail_html = template('mails.mail-' . $type, $args);

            $subject = $subject ?: get_bloginfo('name');

            add_filter( 'wp_mail_content_type', function($content_type){
                return "text/html";
            });
    
            wp_mail( $email, $subject, $mail_html);
            
        }

        
    }


  

}

new Mails();