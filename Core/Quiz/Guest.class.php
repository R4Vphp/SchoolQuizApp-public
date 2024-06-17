<?php

namespace Core\Quiz;

use Core\Database\Database;

class Guest {

    private string $id;
    private string $nickname;

    public function __construct($nickname){

        $this->nickname = $nickname;
        $this->id = Database::uniqueId();
    }

    public function getNickname(){
        return $this->nickname;
    }
    public function getId(){
        return $this->id;
    }
}