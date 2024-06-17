<?php

namespace Core\Utility;

abstract class Network {

    public static function client(){

        return $_SERVER["REMOTE_ADDR"];
    }

    public static function server($includePort = false){

        return getHostByName(getHostName()) . ($includePort ? ":" . $_SERVER["SERVER_PORT"] : null);
    }
}