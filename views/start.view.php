<!DOCTYPE html>
<html>
<?php

use Core\Controllers\Start;

include_once BASE_PATH . "/components/partials/head.html.php";

?>
<body>
<form-hooks>
    <form id="start" method="post" action="/quiz-start"></form>
</form-hooks>
<?php
include_once BASE_PATH . "/components/partials/header.html.php";
include_once BASE_PATH . "/components/partials/navigation.html.php";
?>
<main>
    <section id="hub">
        <h2 class="title">Rozpocznij Quiz</h2>
        <h4 class="subtitle">Wpisz swój nick</h4>
        <hr />
        <input form="start" class="text-input" type="text" name="nickname" maxlength="<?= Start::NICKNAME_MAX_LEN[0] ?>" autocomplete="off" autofocus/>
        <p class="warning-info">Nick może zawierać tylko litery <b>(bez znaków specjalnych)</b>, cyfry i podkreślenie.</p>
    </section>    
    <button form="start" class="button" type="submit" name="quizStart" value="SUBMIT">Start</button>
</main>

<?php
include_once BASE_PATH . "/components/partials/footer.html.php";
?>
</body>
</html>