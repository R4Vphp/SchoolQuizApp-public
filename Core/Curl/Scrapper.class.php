<?php

namespace Core\Curl;

use Core\Curl\Response;

class Scrapper {

    private Response $resource;

    public function setResource($response){

        $this->resource = $response;
        return $this;
    }

    public function select($attribute, $value, $index = 0){

        if(!$this->resource OR !$this->resource->valid()) return null;

        return $this->resource->getBody()->query("//*[@$attribute='$value']")[$index] ?? null;
    }
}