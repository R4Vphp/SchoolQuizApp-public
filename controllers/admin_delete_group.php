<?php

use Core\Controllers\Management;
use Core\Routing\Router;

(new Management)->deleteGroup($_POST["groupId"] ?? 0);

Router::redirect();