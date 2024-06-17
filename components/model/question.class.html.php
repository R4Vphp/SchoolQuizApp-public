<div class='question' id='<?= $this->index ?>'>
    <h4 class="subtitle"><?= $this->index ?>. <span>(<?= $this->getCorrectAnswersAmount() ?>pkt)</span></h4>

<?php
if($this->image){
?>

<center>
    <label>
        <input type='checkbox' class='zoom-trigger' />
        <img class='zoomable' src='<?= $path ?>' alt='MISSING IMAGE: <?= $path ?>'/>
    </label>
</center>

<?php
}
?>

<p class='text-content large'><?= $this->contents ?></p>
<hr />
<ul>

<?php
forEach($this->answers as $a){
?>

<label>
    <li class='text-content answer <?= $a->getMark() ?>'>
        <input
            form='quiz'
            class='<?= $type ?>-answer'
            type='<?= $type ?>'
            name='<?= $this->id ?>[]'
            value='<?= $a->getHash() ?>'
            <?= $a->getSelected() ?>
        />
        <?= $a->getText() ?>
    </li>
</label>

<?php
}
?>

</ul>

<?= ($type === self::MULTI_CHOICE ? "<p class='warning-info'>Pytanie <b>wielokrotnego</b> wyboru.</p>" : null) ?>

</div>