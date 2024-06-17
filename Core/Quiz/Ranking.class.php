<?php

namespace Core\Quiz;

use Core\Database\Database;
use Core\Database\SQL;
use Core\Utility\Notification;
use Core\Routing\Router;
use Core\Utility\Time;
use PDO;

class Ranking {

    const EVERYONE_FINISHED = "Wszyscy uczestnicy ukończyli QUIZ.";
    const GUEST_DISQUALIFIED = "Zdyskwalifikowano Cię.";
    const GUEST_KICKED = "Wyrzucono Cię.";

    private string $guestId;
    private string $groupId;

    public function __construct($groupId = 0, $guestId = 0){

        $this->groupId = $groupId;
        $this->guestId = $guestId;
    }

    public function loadControlPanel(){

        $stmt = Database::connect()->prepare(SQL::GET_GUESTS);
        $stmt->bindParam(":groupId", $this->groupId, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $rows = $stmt->rowCount();

        $allfinished = true;

        include_once BASE_PATH . "/components/model/admin_panel.class.html.php";
    
        if($rows AND $allfinished AND Group::isCurrent()) Notification::set(self::EVERYONE_FINISHED, Notification::TYPE_ALARM);
    }

    public function loadTop10(){

        $stmt = Database::connect()->prepare(SQL::GET_RANKING);
        $stmt->bindParam(":guestId", $this->guestId, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->rowCount();
        $result = $stmt->fetchAll();

        include_once BASE_PATH . "/components/model/ranking.class.html.php";
    }

    public function loadGroupInfo(){

        $stmt = Database::connect()->query(SQL::GET_GROUPS);
        $rows = $stmt->rowCount();
        $result = $stmt->fetchAll();

        forEach($result as $key => $r){

            $index = $key + 1;
            $groupId = $r["groupId"];
            $startTime = Time::HidmY($r["groupStart"]);
            $finishTime = Time::HidmY($r["groupEnd"]);
            $avg = round($r["groupAvgScore"], 2);
            $maxScore = $r["maxScore"];
            $totalMembers = $r["groupMembers"];
            $disqualifiedMembers = $r["disqualifiedGroupMembers"];
            $category = $r["category"];

            include BASE_PATH . "/components/model/group_card.class.html.php";
        }
    }

    private static function getVisitorsSummary(){
        $stmt = Database::connect()->query(SQL::GET_VISITORS_SUMMARY);
        $result = $stmt->fetchAll();

        return ["guestsAmount" => $result[0]["guestsAmount"], "groupsAmount" => $result[0]["groupsAmount"]];
    }
    public static function manifest(){

        $result = self::getVisitorsSummary();
        $guests = $result["guestsAmount"];
        $groups = $result["groupsAmount"];

        if($guests >= 25) return "<p>W Quizie wzięło już udział <b>$guests</b> uczestników przydzielonych do <b>$groups</b> grup</p>";
    }

    public function isDisqualified(){

        $stmt = Database::connect()->prepare(SQL::CHECK_IF_IS_DISQUALIFIED);
        $stmt->bindParam(":guestId", $this->guestId, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll()[0]["isDisqualified"] ?? "KICKED";

        if($result == "KICKED"){
            Notification::set(self::GUEST_KICKED);
            Attempt::destroy();
            Router::redirect("/start");

        }elseif($result){
            Notification::set(self::GUEST_DISQUALIFIED, Notification::TYPE_ALARM);
            return true;
        }

        return false;
    }
}