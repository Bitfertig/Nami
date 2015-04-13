<?php

// Rückmeldevariable erstellen
if ( isset($_POST['action']) ) {
	$_GET['announcement'] = array();
}


// Kontaktformular
if ( isset($_POST['action']) && $_POST['action']=='contact' ) {
	$_GET['announcement']['type'] = 'contact';
	if ( empty($_POST['author'])
		&& !empty($_POST['name'])
		&& !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
		&& !empty($_POST['text'])
	) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$text = $_POST['text'];
		$header = 'From: '.$email;
		$m = mail('org@vegvisir.de', 'Anfrage von '.$name, $text, $header);
		if ( $m ) {
			$_GET['announcement']['status'] = 1; // ✓
			header('Location: '.$_SERVER['PHP_SELF'].'?'. urldecode(http_build_query(array('announcement'=>$_GET['announcement']))) .'#kontakt');
			exit;
		}
	}
	$_GET['announcement']['status'] = 0;
}


/*$_GET['announcement'] = array();
$_GET['announcement']['type'] = 'contact';
$_GET['announcement']['status'] = 0;
echo urldecode(http_build_query(array('announcement'=>$_GET['announcement'])));
*/
?>