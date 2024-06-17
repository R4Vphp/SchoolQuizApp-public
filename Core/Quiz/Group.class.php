<?php

namespace Core\Quiz;

abstract class Group {

    const CURRENT = "#CURRENT";
    const GET_KEY = "GROUP";

    public static function isCurrent(){

        return (self::get() == self::CURRENT);
    }

    public static function get(){

        return filter_var($_GET[self::GET_KEY] ?? self::CURRENT, FILTER_SANITIZE_STRING);
    }
}