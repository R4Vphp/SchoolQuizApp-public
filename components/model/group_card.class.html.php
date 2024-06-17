<div class='question' id='<?= $groupId ?>'>
    <h4 class="subtitle"><?= $index ?>. Grupa <span><?= $groupId ?></span></h4>
        <ul class="no-pointer">
            <li class='text-content answer'>Aktywna od <b><?= $startTime ?></b> do <b><?= $finishTime ?></b></li>
            <li class='text-content answer'>Ilość uczestników: <b><?= $totalMembers ?></b><?= ($disqualifiedMembers ? " (w tym zdyskwalifikowano: <b>$disqualifiedMembers</b>)</li>" : null) ?>
            <li class='text-content answer'>Średni wynik: <b><?= $avg ?>/<?= $maxScore ?></b> (<?= $category ?>)</li>
        </ul>
    <div class='horizontal-order'>
        <a class='button micro' href='/admin/panel?<?= Core\Quiz\Group::GET_KEY ?>=<?= $groupId ?>'>Szczegóły</a>
        <details>
            <summary on-action="Usuń" on-decline="Anuluj" class="button micro admin"></summary>
            <article>
                <p>Czy na pewno chcesz usunąć grupę <b><?= $groupId ?></b>?</p>
                <hr>
                <div class="horizontal-order">
                    <button class="button micro" type="submit" form="admin-delete-group" name="groupId" value="<?= $groupId ?>">Tak</button>
                </div>
            </article>
        </details>
    </div>
</div>