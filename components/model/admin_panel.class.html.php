<table class="table">
    <tr>
        <th>Nick#ID</th>
        <th>Adres IP</th>
        <th>Rozpoczęcie</th>
        <th>Ukończenie</th>
        <th>Czas</th>
        <th>Punkty</th>
        <th>Akcje</th>
    </tr>

<?= (!$rows ? "<tr><td colspan='7'><div class='loading'></div></td></tr>" : null) ?>

<?php
forEach($result as $key => $r){

    $allfinished = ($allfinished AND $r["isFinished"]);

    $index = $key + 1;
    $id = $r["guestID"];
    $isDisq = $r["isDisqualified"];
    $uid = "<b>".$r['username']."</b>#".substr($id, 0, 4);
?>

<tr data-index='<?= $index ?>' class='<?= ($isDisq ? "disqualified" : null) ?> <?= ((!$key AND $r["isFinished"]) ? "highlight" : null) ?>'>
    <td><?= $uid ?></td>
    <td><?= $r["ip"] ?></td>
    <td><?= date("H:i:s", $r["startTime"]) ?></td>
    <td><?= ($r["isFinished"] ? date("H:i:s", $r["finishTime"]) : "--:--:--") ?></td>
    <td><?= ($r["isFinished"] ? date("i:s", $r["attemptTime"]) : "--:--") ?></td>
    <td><?= $r["score"] ?? "?" ?></td>
    <td>
        <details>
            <summary on-action="Wyrzuć" on-decline="Anuluj" class="button micro admin"></summary>
            <article>
                <p>Czy na pewno chcesz wyrzucić uczestnika <?= $uid ?>?</p>
                <hr>
                <div class="horizontal-order">
                    <button class="button micro" type="submit" form="admin-kick" name="guestId" value="<?= $id ?>">Tak</button>
                </div>
            </article>
        </details>
        <button form='admin-disqualify' type='submit' class='button micro <?= ($isDisq ? "disabled" : null) ?>' name='guestId' value='<?= $id ?>' >Dyskwalifikuj</button>
    </td>
</tr>

<?php
}
?>

</table>