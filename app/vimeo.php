<?php

namespace App;
use Vimeo\Vimeo;


class VimeoHandler
{

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        
    }

    public function test()
    {

        $client_id=get_field('vimeoclientid','options')?:'ed16fc1c71657b2e5018997b467bf570f264cb05';
        $client_secret=get_field('vimeoclientsecret','options')?:'XVpZrNxU3dv6h3D8g0kA1h05byvHW6WPAJBDawROrUS27CnRRXQF6sy1eXVv6cVTLv4QzzuRRkefs/b2RXOlGsetsoiX0GQfLrhy/4Ju7I/gUzlQd9koh8n2QCIZepW6';
        $access_token=get_field('vimeoaccesstoken','options')?:'95e090802fd02c95553515a336a0a592';

        $client = new Vimeo("{$client_id}", "{$client_secret}", "{$access_token}");

        $response = $client->request('/tutorial', array(), 'GET');
        return $response;

        
    }

    private function Authenticated() {

        $client_id=get_field('vimeoclientid','options')?:'ed16fc1c71657b2e5018997b467bf570f264cb05';
        $client_secret=get_field('vimeoclientsecret','options')?:'XVpZrNxU3dv6h3D8g0kA1h05byvHW6WPAJBDawROrUS27CnRRXQF6sy1eXVv6cVTLv4QzzuRRkefs/b2RXOlGsetsoiX0GQfLrhy/4Ju7I/gUzlQd9koh8n2QCIZepW6';
        $access_token=get_field('vimeoaccesstoken','options')?:'95e090802fd02c95553515a336a0a592';

        $client = new Vimeo("{$client_id}", "{$client_secret}", "{$access_token}");

        return $client;

    }


    public function parseVimeoUrl($url = '') {
    
        $regs = array();
    
        $id = '';
    
        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
            $id = $regs[3];
        }
    
        return $id;
    
    }

    public function getVimeoVideoThumbnail($vimeo_url='') {

        if(empty($vimeo_url)) return false;

        $video_id = $this->parseVimeoUrl($vimeo_url);
        if($video_id) {

            $client = $this->Authenticated();
            $response = $client->request("/videos/{$video_id}/pictures");
            
            if($response&&!in_array('error', $response['body'])){
                
                $sizes = $response['body']['data'][0]['sizes'];
                if($sizes)
                foreach($sizes as $size) {
                    if($size["width"]>900) {
                        $url = $size['link'];
                        break;
                    }
                }
                return $url ?: false;
            }

        }

        return false;

    }

    public function getVimeoVideoDuration($vimeo_url='') {

        if(empty($vimeo_url)) return false;

        $video_id = $this->parseVimeoUrl($vimeo_url);
        if($video_id) {

            $client = $this->Authenticated();
            $response = $client->request("/videos/{$video_id}");

            if($response&&in_array('duration' ,$response['body'])){
                return $response['body']['duration'];
            }

        }

        return false;

    }
        
}