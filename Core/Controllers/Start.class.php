<?php

namespace Core\Controllers;

use Core\Database\Database;
use Core\Database\SQL;
use Core\Utility\Notification;
use Core\Routing\Router;
use Core\Routing\Middleware;
use Core\Quiz\Attempt;
use PDO;

class Start {

    const ALLOWED_SYMBOLS = "abcdefghijklmnopqrstuvwxyz_0123456789";
    const BANNED_WORDS = [
        "kurw", "huj", "pierdol",
        "pierdal", "jeban", "jebac",
        "kutas", "pojeb", "zjeb",
        "dziwk", "kurew", "pojeb",
        "cwel", "niger", "nigger"
    ];

    const NICKNAME_MIN_LEN = [3, "znaki"];
    const NICKNAME_MAX_LEN = [16, "znaków"];

    const NICKNAME_EMPTY = "Nick nie został wprowadzony.";
    const NICKNAME_BANNED_WORD = "Nick zawiera niedozwolone słowo.";
    const NICKNAME_BANNED_SYMBOLS = "Nick zawiera niedozwolone znaki.";
    const NICKNAME_TOO_SHORT = "Nick nie może być krótszy niż";
    const NICKNAME_TOO_LONG = "Nick nie może być dłuższy niż";
    const NICKNAME_2137 = "Nie śmiej się z papieża!";

    private string $nickname;

    public function grabInput(){

        $this->nickname = trim($_POST["nickname"] ?? "");
        
        if($this->nickname == "..") $this->nickname = "Guest".((($rand = rand(1000,9999)) == 2137) ? "0000" : $rand);
    }

    public function handleErrors(){

        if(empty($this->nickname)){
            
            Notification::set(self::NICKNAME_EMPTY);
            return false;

        }elseif($this->nickname == Management::REQUEST){
            
            Router::redirect("/admin/panel");
            return false;

        }elseif((new Middleware)->onAttemptActive()){

            Notification::set(Attempt::SESSION_ALREADY_STARTED);
            Router::redirect("/quiz");
            return false;

        }elseif(!$this->isNickValid()){
            
            Notification::set(self::NICKNAME_BANNED_SYMBOLS);
            return false;

        }elseif($this->isNickBanned()){
            
            Notification::set(self::NICKNAME_BANNED_WORD);
            return false;

        }elseif(strlen($this->nickname) > self::NICKNAME_MAX_LEN[0]){

            Notification::set(self::NICKNAME_TOO_LONG." ".implode(" ", self::NICKNAME_MAX_LEN).".");
            return false;

        }elseif(strlen($this->nickname) < self::NICKNAME_MIN_LEN[0]){

            Notification::set(self::NICKNAME_TOO_SHORT." ".implode(" ", self::NICKNAME_MIN_LEN).".");
            return false;

        }elseif(!Authorization::check() AND $this->isIpAlreadyUsed()){

            Notification::set(Attempt::SESSION_IP_LIMIT);
            return false;

        }elseif($this->is2137($this->nickname)){

            Notification::set(self::NICKNAME_2137);
            return false;

        }else{
            return $this->nickname;
        }
    }

    private function isIpAlreadyUsed(){

        $stmt = Database::connect()->prepare(SQL::CHECK_IF_IP_AVAILABLE);
        $stmt->bindParam(":ip", $_SERVER["REMOTE_ADDR"], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }

    private function isNickBanned(){

        forEach(self::BANNED_WORDS as $word) if(strpos(strtolower($this->nickname), $word) !== false) return $word;
        
        return false;
    }

    private function isNickValid(){

        forEach(str_split(strtolower($this->nickname), 1) as $symbol) if(strpos(self::ALLOWED_SYMBOLS, $symbol) === false) return false;
        
        return true;
    }

    private function is2137(){

        return (strpos($this->nickname, "2137") !== false);
    }
}