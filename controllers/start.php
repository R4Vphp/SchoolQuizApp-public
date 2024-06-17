<?php

use Core\Controllers\Start;
use Core\Quiz\Attempt;
use Core\Quiz\Guest;
use Core\Routing\Router;

$controler = new Start;
$controler->grabInput();

if($nickname = $controler->handleErrors()){
    
    Attempt::start(new Guest($nickname));
    Router::redirect("/quiz");

}else{

    Router::redirect("/start");
}