<?php

namespace Core\Quiz;

use Core\Utility\Resource;

class Question {

    const SINGLE_CHOICE = "radio";
    const MULTI_CHOICE = "checkbox";

    const IMAGE_PATH = "/images/questions/";

    private string $id;
    private int $index;
    private string $contents;
    private array $answers;
    private array $correctHashes;
    private ?string $image;

    public function __construct($id, $index, $contents, $answers, $correctHashes, $image){

        $this->id = $id;
        $this->index = $index;
        $this->contents = $contents;
        $this->answers = $answers;
        $this->correctHashes = $correctHashes;
        $this->image = $image;

        shuffle($this->answers);
    }

    public function getId(){
        return $this->id;
    }
    public function getContents(){
        return $this->contents;
    }
    public function getAnswers(){
        return $this->answers;
    }
    public function getCorrectHashes(){
        return $this->correctHashes;
    }
    public function getCorrectAnswersAmount(){
        return count($this->correctHashes ?? []);
    }
    public function getImage(){
        return $this->image;
    }
    public function getType(){
        return ($this->getCorrectAnswersAmount() > 1 ? self::MULTI_CHOICE : self::SINGLE_CHOICE);
    }

    public function __toString(){

        $type = $this->getType();
        
        $path = Resource::load(self::IMAGE_PATH.$this->image);

        return include BASE_PATH . "/components/model/question.class.html.php";
    }
}