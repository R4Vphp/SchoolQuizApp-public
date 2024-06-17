<?php

namespace Core\Controllers;

use Core\Database\Database;
use Core\Database\SQL;
use Core\Utility\Notification;
use PDO;

class Management {

    const TOKEN = "c5bb182d";
    const REQUEST = "/admin";

    const SUCCESS_GROUP_EXPIRED = "Akutalna sesja została zakończona.";
    const SUCCESS_GROUP_DELETED = "Grupa została usunięta.";

    const SUCCESS_GUEST_DELETED = "Uczestnik został wyrzucony.";
    const SUCCESS_GUEST_TOGGLED = "Status klasyfikacji uczestnika został zaktualizowany.";

    public function expireCurrentGroup(){

        $stmt = Database::connect()->query(SQL::EXPIRE_CURRENT_GROUP);

        if($stmt->rowCount()) Notification::set(self::SUCCESS_GROUP_EXPIRED);
    }

    public function deleteGuest($guestId){

        $stmt = Database::connect()->prepare(SQL::DELETE_GUEST);
        $stmt->bindParam(":guestId", $guestId, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount()) Notification::set(self::SUCCESS_GUEST_DELETED);
    }

    public function disqualifyGuest($guestId){

        $stmt = Database::connect()->prepare(SQL::TOGGLE_DISQUALIFICATION);
        $stmt->bindParam(":guestId", $guestId, PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount()) Notification::set(self::SUCCESS_GUEST_TOGGLED);
    }

    public function deleteGroup($groupId){

        $stmt = Database::connect()->prepare(SQL::DELETE_GROUP);
        $stmt->bindParam(":groupId", $groupId, PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount()) Notification::set(self::SUCCESS_GROUP_DELETED);
    }
}