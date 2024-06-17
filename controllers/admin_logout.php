<?php

use Core\Controllers\Authorization;
use Core\Routing\Router;
use Core\Utility\Notification;

Authorization::logout();
Notification::set(Authorization::SUCCESS_LOGOUT);

Router::redirect("/admin/authorization");