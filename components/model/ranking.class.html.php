<table class="table" >
    <tr>
        <th>Nick#ID</th>
        <th>Punkty</th>
        <th>Czas</th>
    </tr>
    
<?php
forEach($result as $key => $r){

    $placement = $r["placement"];
    $id = $r["guestID"];
    $uid = "<b>".$r["username"]."</b>#".substr($id, 0, 4);
    $score = $r["score"];
    $time = date("i:s", $r["attemptTime"]);
?>

<?= ($placement > 10 ? "<tr class='spaced'><td colspan=3><h4 class='subtitle'>•••</h4></td></tr>" : null)?>

<tr class='<?= ($this->guestId == $id ? "highlight" : null) ?>' data-index='<?= $placement ?>'><td><?= $uid ?></td><td><?= $score ?></td><td><?= $time ?></td></tr>

<?php
}
?>

</table>
<h4 class="subtitle">TOP <?= min(10, $rows) ?></h4>