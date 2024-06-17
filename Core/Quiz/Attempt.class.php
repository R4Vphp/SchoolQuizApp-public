<?php

namespace Core\Quiz;

use Core\Database\Database;
use Core\Database\SQL;
use Core\Routing\Router;
use Core\Utility\Time;
use Core\Utility\Notification;
use Core\Utility\Network;
use PDO;

class Attempt {

    const STATE_ACTIVE = 0;
    const STATE_FINISHED = 1;

    const QUESTIONS_CATEGORY = "INF_easy";

    const SESSION_IP_LIMIT = "Wykorzystano limit podejść.";
    const SESSION_ALREADY_STARTED = "Sesja jest już aktywna.";
    const SESSION_EXPIRED = "Przekroczono dozwolony czas.";

    private Guest $guest;
    private string $ip;

    private int $state;
    private int $startTime;
    private int $finishTime;
    
    private int $guestScore;
    private int $maxScore;

    private string $category;
    private array $questions;

    private function __construct(Guest $guest){

        $this->state = self::STATE_ACTIVE;
        $this->guest = $guest;
        $this->guestScore = 0;
        $this->startTime = time();
        $this->ip = Network::client();

        $this->category = self::QUESTIONS_CATEGORY;
        $this->load();

        $stmt = Database::connect()->prepare(SQL::INIT_SCOREBOARD);
        $stmt->bindParam(":guestId", $this->guest->getId(), PDO::PARAM_STR);
        $stmt->bindParam(":nickname", $this->guest->getNickname(), PDO::PARAM_STR);
        $stmt->bindParam(":ip", $this->ip, PDO::PARAM_STR);
        $stmt->bindParam(":startTime", $this->startTime, PDO::PARAM_INT);
        $stmt->bindParam(":maxScore", $this->maxScore, PDO::PARAM_INT);
        $stmt->bindParam(":category", $this->category, PDO::PARAM_STR);

        try{
            $stmt->execute();
        }catch(PDOException $e){
            
            Notification::set(Notification::GENERAL_ERROR);
            Router::redirect("/start");
        }
    }
    
    private function load(){

        $stmt = Database::connect()->prepare(SQL::GET_QUESTIONS);
        $stmt->bindParam(":category", $this->category, PDO::PARAM_STR);
        $stmt->execute();
        
        $this->questions = $stmt->fetchAll();
        $this->maxScore = 0;

        forEach($this->questions as $key => $question){

            $this->maxScore += $question["correctAnswers"];
            $answers = [
                $question["answer1"] ?? null,
                $question["answer2"] ?? null,
                $question["answer3"] ?? null,
                $question["answer4"] ?? null,
                $question["answer5"] ?? null,
                $question["answer6"] ?? null
            ];
            $answers = array_filter($answers);

            $correctHashes = [];
            forEach($answers as $k => $a){
                $answers[$k] = new Answer($a);
                $correctHashes[] = $answers[$k]->getHash();
            }
            $correctHashes = array_splice($correctHashes, 0, $question["correctAnswers"]);

            $this->questions[$key] = new Question(
                Database::uniqueId(),
                $key + 1,
                $question["contents"],
                $answers,
                $correctHashes,
                $question["image"]
            );
        }
    }
    public static function start($guest){

        $_SESSION[__CLASS__] = new self($guest);
    }

    public static function destroy(){

        if($_SESSION[__CLASS__] ?? false) unset($_SESSION[__CLASS__]);
    }

    public static function get(){

        return $_SESSION[__CLASS__] ?? false;
    }

    public function getGuest(){
        return $this->guest;
    }
    public function getIp(){
        return $this->ip;
    }
    public function getState(){
        return $this->state;
    }
    public function getMaxScore(){
        return $this->maxScore;
    }
    public function getGuestScore(){
        return $this->guestScore;
    }
    public function getQuestionAmount(){
        return count($this->questions ?? []);
    }
    public function getDuration(){
        return ($this->finishTime - $this->startTime);
    }
    public function isExpired(){
        return ($this->getDuration() > Time::HOUR);
    }

    public function print(){

        return implode($this->questions);
    }

    public function finish(){

        $this->finishTime = time();
        $this->state = self::STATE_FINISHED;
        $this->save();
    }

    public function summarize(){

        forEach($this->questions as $key => $q){

            $answers = $q->getAnswers();
            $hashes = $q->getCorrectHashes();
            $guess = $_POST[$q->getId()] ?? [];
            sort($guess);
            sort($hashes);

            if($hashes === $guess){
                $this->guestScore += $q->getCorrectAnswersAmount();
                unset($this->questions[$key]);
                continue;
            }

            $pointsForQuestion = 0;
            forEach($answers as $k => $a){

                $answerHash = $a->getHash();

                if(in_array($answerHash, $guess) AND in_array($answerHash, $hashes)) $pointsForQuestion++;
                
                if(in_array($answerHash, $guess)) $a->setSelected(Answer::SELECTED);
                
                if(in_array($answerHash, $hashes)){
                    $a->setMark(Answer::CORRECT);
                }elseif($a->getSelected()){
                    $a->setMark(Answer::INCORRECT);
                    $pointsForQuestion--;
                }
            }
            
            $this->guestScore += $pointsForQuestion * ($pointsForQuestion > 0);
        }

        $this->guestScore = min(max($this->guestScore, 0), $this->maxScore);
    }
    private function save(){

        $stmt = Database::connect()->prepare(SQL::UPDATE_SCOREBOARD);
        $stmt->bindParam(":score", $this->guestScore, PDO::PARAM_INT);
        $stmt->bindParam(":finishTime", $this->finishTime, PDO::PARAM_INT);
        $stmt->bindParam(":guestId", $this->guest->getId(), PDO::PARAM_STR);
        $stmt->execute();
    }
}