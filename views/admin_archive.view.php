<!DOCTYPE html>
<html>
<?php

use Core\Quiz\Ranking;

include_once BASE_PATH . "/components/partials/head.html.php";

?>
<body>
<form-hooks>
    <form id="admin-logout" method="post" action="/admin-logout"></form>
    <form id="admin-delete-group" method="post" action="/admin-delete-group"></form>
</form-hooks>
<?php
include_once BASE_PATH . "/components/partials/header.html.php";
include_once BASE_PATH . "/components/partials/navigation.html.php";
?>
<main>
    <button form="admin-logout" class="button" type="submit" name="adminLogout" value="SUBMIT">Wyloguj</button>
    <section id="archive">
        <h2 class="title">Statystyki grupowe</h2>
        <h4 class="subtitle">Zakończone sesje:</h4>
        <hr />
        <?php
        (new Ranking)->loadGroupInfo();
        ?>
    </section>
</main>
<?php
include_once BASE_PATH . "/components/partials/footer.html.php";
?>
</body>
</html>