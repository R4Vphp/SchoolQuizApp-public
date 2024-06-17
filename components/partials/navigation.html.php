<?php

use Core\Controllers\Authorization;
use Core\Database\Database;
use Core\Quiz\Attempt;
use Core\Utility\Network;
use Core\Utility\Resource;

?>

<nav>

<?php
if($session = Attempt::get()){
?>

<p class="nav-element user-info"><img src="<?= Resource::load("/images/guest.svg") ?>" width="15em" /> <?= $session->getGuest()->getNickname() ?><span>#<?= substr($session->getGuest()->getId(), 0, 4) ?></span></p>

<?php
}
if($admin = Authorization::check()){
?>

<p class="nav-element user-info admin">Administrator</p>
<a class="nav-element redirect" href="http://<?= Network::server() ?>/phpmyadmin/?db=<?= Database::DB_NAME ?>" target="_blank">PhpMyAdmin</a>
<a class="nav-element redirect" href="/admin/testing">Testowanie</a>
<a class="nav-element redirect" href="/admin/archive">Archiwum</a>
<a class="nav-element redirect" href="/admin/panel">Panel</a>

<?php
}
if(!$admin AND !$session){
?>

<p class="nav-element user-info">Użytkownik</p>

<?php
}
?>

</nav>