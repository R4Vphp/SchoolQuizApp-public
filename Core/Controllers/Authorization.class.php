<?php

namespace Core\Controllers;

use Core\Database\Database;
use Core\Utility\Notification;
use Core\Utility\Network;
use Core\Utility\Time;

class Authorization {

    const ACCESS_DENIED = "Odmowa dostępu.";
    const PASSWORD_NULL = "Hasło nie zostało wprowadzone.";
    const PASSWORD_INCORRECT = "Nieprawidłowe hasło.";

    const SUCCESS_LOGIN = "Zalogowano pomyślnie.";
    const SUCCESS_LOGOUT = "Wylogowano pomyślnie.";

    private ?string $input;
    private bool $verification;

    public function grabInput(){

        $this->input = $_POST["authorizationKey"] ?? null;
        $this->verification = $this->verifyPassword();
    }

    public function handleErrors(){

        if(Network::client() != Network::server()){
            Notification::set(self::ACCESS_DENIED);
            return false;
        }elseif(!$this->input){
            Notification::set(self::PASSWORD_NULL);
            return false;
        }elseif(!$this->verification){
            Notification::set(self::PASSWORD_INCORRECT);
            return false;
        }else{
            return true;
        }
    }

    public static function login(){
        
        $_SESSION[__CLASS__] = true;
    }
    public static function logout(){

        unset($_SESSION[__CLASS__]);
    }
    public static function check(){

        return $_SESSION[__CLASS__] ?? false;
    }

    private function verifyPassword(){

        return (hash(Database::HASH_METHOD, $this->input) == Management::TOKEN);
    }
}