<h1>Medien</h1>


	<form enctype="multipart/form-data" action="?mode=medien" method="post">
		<input type="hidden" name="action" value="mediaupload" />
	    <input name="userfile" type="file" />
	    <input class="media-list" type="submit" value="Datei abschicken" />
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


/* lightbox gallery */

	echo '<form action="?mode=medien" method="post">';
	echo 	'<input type="hidden" name="action" value="mediadelete" />';
	echo 	'<input name="id" id="mediaid" type="hidden" value="" />';



echo '<div class="popup-gallery"><table class="media-list">';
while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    echo '<tr>'
    		.'<td><a href="/media/'. $row->id .'-'. $row->name .'"><img src="/thumbnail/'. thumbnail($row->id .'-'. $row->name) .'" alt="" width="30" /></a></td>'
    		.'<td>'. $row->name .'</td>'
    		.'<td class="media-list">Verwendet in</td>'
    		.'<td class="media-list"><input class="mediadelete" type="button" data-id="'.$row->id.'" value="Löschen" /></td>'
    	  .'</tr>';
}
echo '</table></div>';
echo '</form>';


?>




<script>
$(document).ready(function() {

	$('.mediadelete').on('click',function(){
		$('#mediaid').val( $(this).data('id') );
		$('.mediadelete').submit();
	});


/* lightbox gallery */

	$('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
		}
	});

});
</script>

