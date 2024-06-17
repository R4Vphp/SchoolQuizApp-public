<?php

use Core\Quiz\Attempt;
use Core\Routing\Router;
use Core\Utility\Notification;
use Core\Controllers\Management;

$session = Attempt::get();

$session->summarize();
$session->finish();

if($session->isExpired()){

    Notification::set(Attempt::SESSION_EXPIRED);
    (new Management)->deleteGuest($session->getGuest()->getId());
    Attempt::destroy();
    Router::redirect("/start");

}else{

    Router::redirect("/summary");
}