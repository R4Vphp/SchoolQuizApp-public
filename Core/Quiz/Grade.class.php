<?php

namespace Core\Quiz;

class Grade {

    const STAGES = [
        100 => "6",
        95 => "5+",
        90 => "5",
        85 => "5-",
        80 => "4+",
        75 => "4",
        70 => "4-",
        65 => "3+",
        50 => "3",
        45 => "3-",
        40 => "2+",
        30 => "2",
        25 => "2-",
        20 => "2=",
        15 => "1+",
        5 => "1",
        0 => "xD"
    ];

    private int $score;
    private int $maxScore;

    public function __construct($score, $maxScore){

        $this->score = $score;
        $this->maxScore = $maxScore;
    }

    public function calculate(){

        $percentage = $this->score / $this->maxScore * 100;

        forEach(self::STAGES as $key => $grade) if($percentage >= $key) return $grade;
        
        return "!?";
    }
}