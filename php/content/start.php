<?php /* Start */ ?>

<h1>Veranstaltungen</h1>



<?php

$userid = $_SESSION['User']->get('id');


$sql = 'SELECT * FROM events WHERE userid = :userid';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt->execute();

$count = $stmt->rowCount();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    echo $row->id .' - '. $row->title .' <a href="?mode=eventedit&amp;id='.$row->id.'">[Edit]</a><br />';
}




?>