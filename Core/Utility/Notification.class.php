<?php

namespace Core\Utility;

abstract class Notification {

    const TYPE_INFO = "info-alert";
    const TYPE_ALARM = "alarm-alert";

    const GENERAL_ERROR = "Coś poszło nie tak - spróbuj ponownie.";

    public static function listen(){

        if(!($_SESSION[__CLASS__] ?? false)) return;

        forEach($_SESSION[__CLASS__] as $type => $message) self::popOut($message, $type);
        
        unset($_SESSION[__CLASS__]);
    }

    public static function set($message, $type = self::TYPE_INFO){

        $_SESSION[__CLASS__][$type] = $message;
    }

    private static function popOut($message, $type){

        echo "<div class='notification $type'><p>$message</p></div>";
    }
}