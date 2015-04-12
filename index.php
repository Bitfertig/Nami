<?php
include 'php/includes/config.php'; // Konfiguration
include 'php/includes/classes.php'; // Klassen
include 'php/includes/functions.php'; // Funktionen
include 'php/includes/actions.php'; // Verarbeitungen






$mode = isset($_GET['mode']) ? $_GET['mode'] : '';


// Nicht eingeloggt:
if ( !$_SESSION['User'] ) {

	//Ausgabe
	include 'php/header.php';
	/* echo '<a href="/info" title="Infoseite">Infoseite</a><br />'; */
	
	/* Curl */
	echo '<a href="/info" class="linkcurl" title="Infoseite">';
	echo '<div class="curl">';
    echo 	'<div class="curlcut"></div>';
    echo 	'<div class="curltext">'; 
    echo  		'Hier gelangen Sie zur Infoseite!';
    echo 	'</div>';
  	echo '</div>';
  	echo '</a>';
	
	echo '<div class="content">';
	echo '<a href="/" title="Zur Startseite" id="logolink"><img src="res/img/logo.png" alt="Logo" /></a>';

	if ( $mode == 'register' ) {
		include 'php/content/register.php';
	}
	elseif ( $mode == 'lostpassword' ) {
		include 'php/content/passwort-vergessen.php';
	}
	elseif ( $mode == 'resetpassword_doi' ) {
		include 'php/content/passwort-zuruecksetzen.php';
	}
	else {
		include 'php/content/login.php';
	}

	echo '</div>';
	include 'php/footer.php';
}
// Wenn eingeloggt:
else {

	//Ausgabe
	include 'php/header.php';
	include 'php/sidebar.php';
	echo '<div class="content">';

	if ( $mode == 'start' || $mode == '' ) {
		include 'php/content/start.php';
	}
	elseif ( $mode == 'userconfig' ) {
		include 'php/content/userconfig.php';
	}
	elseif ( $mode == 'schnittstelle' ) {
		include 'php/content/schnittstelle.php';
	}
	else {
		include 'php/content/404.php';
	}

	echo '</div>';
	include 'php/footer.php';
}



?>