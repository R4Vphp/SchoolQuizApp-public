<?php

use Core\Controllers\Management;
use Core\Routing\Router;

(new Management)->expireCurrentGroup();

Router::redirect();