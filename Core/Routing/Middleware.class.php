<?php

namespace Core\Routing;

use Core\Controllers\Authorization;
use Core\Quiz\Attempt;

class Middleware {

    public function onLogin(){

        if(!Authorization::check()) Router::redirect("/admin/authorization");
        return true;
    }

    public function onAttemptActive(){

        return (Attempt::get() AND Attempt::get()->getState() == Attempt::STATE_ACTIVE);
    }

    public function onAttemptFinished(){

        return (Attempt::get() AND Attempt::get()->getState() == Attempt::STATE_FINISHED);
    }
}