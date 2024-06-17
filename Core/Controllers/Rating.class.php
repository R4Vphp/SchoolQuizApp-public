<?php

namespace Core\Controllers;

use Core\Database\Database;
use Core\Database\SQL;
use Core\Quiz\Attempt;
use PDO;

class Rating {

    const STAR_POINTS = [
        1 => "Słaby",
        2 => "Średni",
        3 => "Dobry",
        4 => "Bardzo dobry",
        5 => "Doskonały"
    ];

    private int $guestRate = 0;

    public function grabInput(){

        $input = $_POST["starPoint"] ?? 0;
        $this->guestRate = ((is_numeric($input)) ? $input : 0);
    }

    public function save(){

        if(!$this->guestRate) return;
        
        $rate = $this->minMax($this->guestRate);
        $guestId = Attempt::get()->getGuest()->getId();
        $stmt = Database::connect()->prepare(SQL::RATING_ADD);
        $stmt->bindParam(":rating", $rate, PDO::PARAM_INT);
        $stmt->bindParam(":guestId", $guestId, PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function options(){

        forEach(self::STAR_POINTS as $key => $point) echo "<input form='exit' type='radio' class='star-point' name='starPoint' value='$key' />";
    }

    private function minMax($value, $min = 1, $max = 5){
        return min(max($value, $min), $max);
    }
    public static function getAvgRating(){
        $stmt = Database::connect()->query(SQL::GET_AVG_RATING);
        return round($stmt->fetchAll()[0]["rating"], 1);
    }

    public static function manifest(){

        if(($rate = self::getAvgRating()) >= 3) return "<p>Quiz został oceniony przez uczestników na <b>$rate/5</b> gwiazdek</p>";
    }
}