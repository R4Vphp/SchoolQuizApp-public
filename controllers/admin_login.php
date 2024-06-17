<?php

use Core\Controllers\Authorization;
use Core\Routing\Router;
use Core\Utility\Notification;

$controler = new Authorization;
$controler->grabInput();

if(Authorization::check() OR $controler->handleErrors()){
    
    Authorization::login();
    Notification::set(Authorization::SUCCESS_LOGIN);
    Router::redirect("/admin/panel");

}else{

    Router::redirect("/admin/authorization");
}