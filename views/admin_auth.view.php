<!DOCTYPE html>
<html>
<?php

include_once BASE_PATH . "/components/partials/head.html.php";

?>
<body>
<form-hooks>
    <form id="admin-login" method="post" action="/admin-login"></form>
</form-hooks>
<?php
include_once BASE_PATH . "/components/partials/header.html.php";
include_once BASE_PATH . "/components/partials/navigation.html.php";
?>
<main>
    <section id="authorization">
        <h2 class="title">Panel administratorski</h2>
        <h4 class="subtitle">Logowanie</h4>
        <hr />
        <input form="admin-login" class="password-input" type="password" name="authorizationKey" autocomplete="off" placeholder="Wpisz hasło" autofocus/>
        <p class="warning-info">Dostęp do panelu administratorskiego może zostać uzyskany <b>tylko na serwerze</b>.</p>
    </section>
    <button form="admin-login" class="button" type="submit" name="adminLogin" value="SUBMIT" >Zaloguj</button>
</main>

<?php
include_once BASE_PATH . "/components/partials/footer.html.php";
?>
</body>
</html>