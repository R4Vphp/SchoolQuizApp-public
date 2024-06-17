<?php

use Core\Controllers\Rating;
use Core\Quiz\Attempt;
use Core\Routing\Router;

$rating = new Rating;

$rating->grabInput();
$rating->save();

Attempt::destroy();
session_regenerate_id();

Router::redirect("/start");