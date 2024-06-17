<?php

namespace Core\Quiz;

use Core\Database\Database;

class Answer {

    const CORRECT = "correct";
    const INCORRECT = "incorrect";
    
    const SELECTED = "checked";
    const UNSELECTED = "";

    private string $text;
    private string $hash;
    private string $mark;
    private string $selected;

    public function __construct($text){

        $this->text = $text;
        $this->hash = Database::uniqueId();
        $this->mark = self::UNSELECTED;
        $this->selected = self::UNSELECTED;
    }

    public function getText(){
        return $this->text;
    }
    public function getHash(){
        return $this->hash;
    }

    public function getMark(){
        return $this->mark;
    }
    public function setMark($set){
        $this->mark = $set;
    }

    public function getSelected(){
        return $this->selected;
    }
    public function setSelected($set){
        $this->selected = $set;
    }
}