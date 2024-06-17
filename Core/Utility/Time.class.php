<?php

namespace Core\Utility;

abstract class Time {

    const SECOND = 1;
    const MINUTE = 60;
    const HOUR = self::MINUTE * 60;
    const DAY = self::HOUR * 24;

    public static function HidmY($time = null){

        return date("H:i d/m/y", $time ?? time());
    }
    public static function dmY($time = null){

        return date("d/m/Y", $time ?? time());
    }
    public static function His($time = null){

        return date("H:i:s", $time ?? time());
    }
    public static function Hi($time = null){

        return date("H:i", $time ?? time());
    }
    public static function is($time = null){

        return date("i:s", $time ?? time());
    }
}