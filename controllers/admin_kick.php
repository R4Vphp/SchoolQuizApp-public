<?php

use Core\Controllers\Management;
use Core\Routing\Router;

(new Management)->deleteGuest($_POST["guestId"] ?? 0);

Router::redirect();