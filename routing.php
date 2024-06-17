<?php

use Core\Routing\Router;

session_start();

$router = new Router;

$router->get("/", "start");
$router->get("/start", "start");
$router->get("/quiz", "quiz")->only("onAttemptActive");
$router->get("/summary", "summary")->only("onAttemptFinished");

$router->post("/quiz-start", "start");
$router->post("/quiz-finish", "finish")->only("onAttemptActive");
$router->post("/quiz-reset", "reset")->only("onAttemptFinished");

$router->get("/admin/authorization", "admin_auth");
$router->get("/admin/panel", "admin_panel")->only("onLogin");
$router->get("/admin/archive", "admin_archive")->only("onLogin");
$router->get("/admin/testing", "test")->only("onLogin");

$router->post("/admin-login", "admin_login");
$router->post("/admin-logout", "admin_logout")->only("onLogin");
$router->post("/admin-kick", "admin_kick")->only("onLogin");
$router->post("/admin-disqualify", "admin_disq")->only("onLogin");
$router->post("/admin-restart", "admin_restart")->only("onLogin");
$router->post("/admin-delete-group", "admin_delete_group")->only("onLogin");

$router->route();