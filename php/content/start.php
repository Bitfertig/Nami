<?php /* Start */ ?>

<h1>Veranstaltungen</h1>



<?php

$userid = $_SESSION['User']->get('id');


$sql = 'SELECT * FROM events WHERE userid = :userid';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt->execute();

$count = $stmt->rowCount();

echo '<table class="table-styled">';
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
?>
	<tr>
		<td style="width:50px;min-width:50px;max-width:50px;" title="ID <?=$row->id?>"><?=$row->status?></td>
		<td class="nopadding"><a href="?mode=eventedit&amp;id=<?=$row->id?>" title="<?=plaintext($row->title)?>" class="fill"><?=plaintext($row->title)?></a></td>
    </tr>
<?php
}
echo '</table>';




?>