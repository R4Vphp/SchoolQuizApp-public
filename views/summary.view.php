<!DOCTYPE html>
<html>
<?php

use Core\Controllers\Rating;
use Core\Quiz\Ranking;
use Core\Quiz\Attempt;
use Core\Quiz\Grade;
use Core\Quiz\Group;
use Core\Utility\Time;

include_once BASE_PATH . "/components/partials/head.html.php";

$session = Attempt::get();
$ranking = new Ranking(Group::CURRENT, $session->getGuest()->getId());

$isDisq = $ranking->isDisqualified();

$guestScore = $session->getGuestScore();
$maxScore = $session->getMaxScore();

?>
<body>
<form-hooks>
	<form id="exit" method="post" action="quiz-reset"></form>
</form-hooks>
<?php
include_once BASE_PATH . "/components/partials/header.html.php";
include_once BASE_PATH . "/components/partials/navigation.html.php";
?>
<main>
	<section id="results">
		<h2 class="title">UKOŃCZONO</h2>
		<h4 class="subtitle">Twój wynik to:</h4>
		<hr />
		<div class="grade"><?= (new Grade($guestScore, $maxScore))->calculate() ?></div>
		<h2 class="title">
			<span><?= $guestScore ?></span>/<?= $maxScore ?>
		</h2>
		<h4 class="subtitle">Czas: <?= Time::is($session->getDuration()) ?></h4>
	</section>

<?php
if(($guestScore != $maxScore) AND !$isDisq AND $guestScore){
?>
<section class="no-pointer" id="mistakes">
	<h2 class="title">Podgląd</h2>
	<h4 class="subtitle">Błędne odpowiedzi:</h4>
	<hr />
	<a href='#ranking' class='button fixed micro'>Pomiń</a>
<?php $session->print(); ?>
</section>
<?php
}
?>

<section id="ranking">
	<h2 class="title">Ranking</h2>
	<h4 class="subtitle">Najwyższe wyniki:</h4>
	<hr />
	<?php
	$ranking->loadTop10();
	?>
	<br /><p class="warning-info">Aby odświeżyć ranking kliknij <b>F5</b>.</p>
</section>
<button form="exit" class="button" type="submit" name="quizReset" value="SUBMIT" >Powrót</button>

<?php
if(!$isDisq AND $guestScore){
?>
	<section id="rating">
		<h2 class="title">Ostatnie pytanie</h2>
		<h4 class="subtitle">Jak Ci się podobało?</h4>
		<hr>
		<div class="horizontal-order star-point-selection">
			<?php
			Rating::options();
			?>
		</div>
		<h4 class="subtitle star-point-description" data-vote-0="Wstrzymuję się" data-vote-1="Fatalnie" data-vote-2="Słabo" data-vote-3="Średnio" data-vote-4="Fajnie" data-vote-5="Super"></h4>
	</section>
<?php
}
?>
</main>
<?php
include_once BASE_PATH . "/components/partials/footer.html.php";
?>
</body>
</html>