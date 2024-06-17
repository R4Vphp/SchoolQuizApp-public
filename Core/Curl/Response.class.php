<?php

namespace Core\Curl;

use DOMXPath;

class Response {

    private int $code;
    private ?DOMXPath $body;

    public function __construct($code, $body = null){
        $this->code = $code;
        $this->body = $body;
    }

    public function valid(){
        
        return !($this->code == 404);
    }

    public function getCode(){
        return $this->code;
    }

    public function getBody(){
        return $this->body;
    }
}