<?php

namespace Core\Utility;

abstract class Resource {

    public static function load($resource){

        return "http://".Network::server(true).$resource;
    }
}