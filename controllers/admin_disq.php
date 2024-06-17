<?php

use Core\Controllers\Management;
use Core\Routing\Router;

(new Management)->disqualifyGuest($_POST["guestId"] ?? 0);

Router::redirect();