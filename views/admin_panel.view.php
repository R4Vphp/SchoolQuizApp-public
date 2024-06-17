<!DOCTYPE html>
<html>
<?php

use Core\Quiz\Ranking;
use Core\Quiz\Group;

include_once BASE_PATH . "/components/partials/head.html.php";

if(Group::isCurrent()) include_once BASE_PATH . "/components/partials/refresh.html.php";

$groupId = Group::get();

?>
<body>
<form-hooks>
    <form id="admin-kick" method="post" action="/admin-kick"></form>
    <form id="admin-disqualify" method="post" action="/admin-disqualify"></form>
    <form id="admin-restart" method="post" action="/admin-restart"></form>
    <form id="admin-logout" method="post" action="/admin-logout"></form>
</form-hooks>
<?php
include_once BASE_PATH . "/components/partials/header.html.php";
include_once BASE_PATH . "/components/partials/navigation.html.php";
?>
<main>
    <div class="horizontal-order">
    <?php
    if(Group::isCurrent()){
    ?>
    <details>
        <summary on-action="Zakończ" on-decline="Anuluj" class="button admin"></summary>
        <article>
            <p>Czy na pewno chcesz zakończyć aktualną sesję?</p>
            <hr>
            <div class="horizontal-order">
                <button class="button micro" type="submit" form="admin-restart" name="resetQuiz" value="SUBMIT">Tak</button>
            </div>
        </article>
    </details>
    
    <?php
    }
    ?>
    <button form="admin-logout" class="button" type="submit" name="adminLogout" value="SUBMIT">Wyloguj</button>
    </div>
    <section id="panel">
        <h2 class="title">Grupa <b><?= $groupId ?></b></h2>
        <h4 class="subtitle">Panel kontrolny:</h4>
        <hr />
        <?php
        (new Ranking($groupId))->loadControlPanel();
        ?>
    </section>
</main>
<?php
include_once BASE_PATH . "/components/partials/footer.html.php";
?>
</body>
</html>