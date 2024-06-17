<!DOCTYPE html>
<html>
<?php

use Core\Utility\Network;

include_once BASE_PATH . "/components/partials/head.html.php";

?>
<body>
<form-hooks>
    <form id="test" method="post" action="/admin/testing"></form> 
</form-hooks>
<?php
include_once BASE_PATH . "/components/partials/header.html.php";
include_once BASE_PATH . "/components/partials/navigation.html.php";
?>
<main>
    <section>
        <h2 class="title">Sandbox</h2>
        <h4 class="subtitle">test.view.php</h4>
        <hr />
        <button class="button admin" popovertarget="reset-warning" popovertargetaction="show">Zakończ</button>
        <div popover class="question" id="reset-warning">
            <h4 class="subtitle">Ostrzeżenie</h4>
            <div class="text-content large">Czy na pewno chcesz zakończyć akutalną sesję?</div>
            <div class="horizontal-order">
                    <button class="button micro" type="submit" form="test" name="runTest" value="SUBMIT">Tak</button>
                    <button class="button micro" popovertarget="reset-warning" popovertargetaction="hide">Nie</button>
            </div>
        </div>
        <datalist id="datas">
            <option value="Never"></option>
            <option value="Gonna"></option>
            <option value="Give"></option>
            <option value="You"></option>
            <option value="Up"></option>
        </datalist>

        <?php
        ?>

        <input class="text-input micro" form="test" list="datas" type="text" name="cmd">
        <pre>
            
        </pre>
    </section>
    <input type="checkbox" class="checkbox-answer missingAnswer" draggable="true">
    <button form="test" class="button missingAnswers" type="submit" name="runTest" value="SUBMIT" data-counter-info="0">Test</button>
</main>
<?php
include_once BASE_PATH . "/components/partials/footer.html.php";
?>
</body>
</html>