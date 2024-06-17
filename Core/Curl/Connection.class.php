<?php

namespace Core\Curl;

use DOMDocument;
use DOMXPath;
use CurlHandle;

class Connection {

    private CurlHandle $ch;
    private string $url;

    public function __construct($url){

        $this->ch = curl_init();
        $this->url = $url;
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
    }

    public function bindProxy($ip, $port){

        curl_setopt($this->ch, CURLOPT_PROXY, $ip);
        curl_setopt($this->ch, CURLOPT_PROXYPORT, $port);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);

        return $this;
    }

    public function getCh(){

        return $this->ch;
    }
    public function getUrl(){

        return $this->url;
    }

    public function response(){

        if(empty($html = curl_exec($this->ch))) return new Response(404);

        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);

        return new Response(
                curl_getinfo($this->ch, CURLINFO_HTTP_CODE),
                new DOMXPath($dom)
        );
    }

    public function __destruct(){

        curl_close($this->ch);
    }
}