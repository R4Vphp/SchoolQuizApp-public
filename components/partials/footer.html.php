<?php

use Core\Controllers\Rating;
use Core\Quiz\Ranking;
use Core\Utility\Details;
use Core\Utility\Notification;
use Core\Utility\Resource;
use Core\Utility\Network;

Notification::listen();

?>
<footer>
    <hr />
    <p><img src="<?= Resource::load("/images/logo.png") ?>" width="25px" /><b>Zespół Szkół Nr 1</b> w Piekarach Śląskich</p>
    <p>Dni otwarte <b>2023</b></p>
    <p>Stronę wykonał <b><?= Details::AUTHOR ?></b></p>
    <p>Wersja <b><?= Details::VERSION ?></b></p>
    <?= Ranking::manifest() ?>
    <?= Rating::manifest() ?>
    <p>Witryna używa plików <b>cookies</b></p>
    <p>Adres stanowiska: <b><?= Network::client() ?></b></p>
    <p>Adres serwera: <b><?= Network::server(true) ?></b></p>
    <hr>
    <p><b>PHP</b> <?= phpversion() ?></p>
</footer>