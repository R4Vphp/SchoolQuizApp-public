<!DOCTYPE html>
<html>
<?php

use Core\Quiz\Attempt;

include_once BASE_PATH . "/components/partials/head.html.php";

$session = Attempt::get();
?>
<body>
<form-hooks>
	<form id="quiz" method="post" action="quiz-finish"></form>
</form-hooks>
<?php
include_once BASE_PATH . "/components/partials/header.html.php";
include_once BASE_PATH . "/components/partials/navigation.html.php";
?>
<main>
	<section id="intro">
		<h2 class="title">Powodzenia</h2>
		<h4 class="subtitle">Do zdobycia łącznie <span><?= $session->getMaxScore() ?></span> pkt z <span><?= $session->getQuestionAmount() ?></span> pytań.</h4>
	</section>
	<?php $session->print() ?>
	<button form="quiz" class="button" type="submit" name="quizFinish" value="SUBMIT">Sprawdź</button>
</main>

<?php
include_once BASE_PATH . "/components/partials/footer.html.php";
?>
</body>
</html>