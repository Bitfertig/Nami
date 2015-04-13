<h1>Medien</h1>



<?php

$userid = $_SESSION['User']->get('id');


$sql = 'SELECT * FROM eventfiles WHERE userid = :userid';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    echo $row->id .' '. $row->filename .' '. $row->extension .'<br />';
}


?>