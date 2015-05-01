<h1>Medien</h1>

<form enctype="multipart/form-data" action="?mode=medien" method="post">
	<input type="hidden" name="action" value="mediaupload" />
    <input name="userfile" type="file" />
    <input type="submit" value="Datei abschicken" />
</form>



<?php
// Datei hochladen


if( !isset( $_POST['action'] ) ){
	$_POST['action'] = '';
}
$action = $_POST['action'];

if( $action == 'mediaupload' ){


	$whitelist = array(
		'image/gif',
		'image/jpeg',
		'image/png',
		'image/svg+xml'
	);
	$extensions = array(
		'gif',
		'jpeg',
		'jpg',
		'png',
		'svg'
	);

	// Dateiendung
	$path_parts = pathinfo( $_FILES['userfile']['name'] );
	$extension = $path_parts['extension'];

$errors = array();

	if( !in_array($_FILES['userfile']['type'], $whitelist) ){
		$errors[] = 'mimetype';
	}
	if( !in_array( $extension, $extensions ) ){
		$errors[] = 'extension';
	}
	if( $_FILES['userfile']['size'] > 5*1024*1024 ){    // 5mb Dateigröße
		$errors[] = 'size';
	}

	// Bedingungen erfüllt, Datei wird gespeichert
	if( count($errors) == 0 ){
		//Datenbankeintrag
		$sql = 'INSERT INTO eventfiles (userid, name) VALUES (:userid, :name)';
		$stmt = $pdo->prepare($sql);
		$userid = $_SESSION['User']->get('id');
		$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
		$stmt->bindParam(':name', $_FILES['userfile']['name'], PDO::PARAM_STR);
		$stmt->execute();
		$lastId = $pdo->lastInsertId();

		//Datei erstellen/verschieben
		move_uploaded_file ( $_FILES['userfile']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/media/'
			.$lastId.'-'.$_FILES['userfile']['name'] );
	}

	





	echo $_FILES['userfile']['name'];

	echo $_FILES['userfile']['tmp_name'];

	// $_FILES['userfile']['error']
}


?>

<?php


$userid = $_SESSION['User']->get('id');


$sql = 'SELECT * FROM eventfiles WHERE userid = :userid';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt->execute();



echo '<ul>';
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    echo '<li>'.$row->id .' '. $row->name .'</li>';
}
echo '</ul>';


?>









