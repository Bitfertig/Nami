<?php
include 'php/includes/config.php'; // Konfiguration
include 'php/includes/classes.php'; // Klassen
include 'php/includes/functions.php'; // Funktionen
include 'php/includes/actions.php'; // Verarbeitungen



//Ausgabe
include 'php/header.php';


$mode = isset($_GET['mode']) ? $_GET['mode'] : '';


// Nicht eingeloggt:
if ( !$_SESSION['User'] ) {

	if ( $mode == 'login' || $mode == '' ) {
		include 'php/content/login.php';
	}
	elseif ( $mode == 'register' ) {
		include 'php/content/register.php';
	}
	elseif ( $mode == 'lostpassword' ) {
		include 'php/content/passwort-vergessen.php';
	}
	elseif ( $mode == 'resetpassword_doi' ) {
		include 'php/content/passwort-zuruecksetzen.php';
	}

}
// Wenn eingeloggt:
else {

	include 'php/sidebar.php';

	if ( $mode == 'start' || $mode == '' ) {
		include 'php/content/start.php';
	}
	elseif ( $mode == 'schnittstelle' ) {
		include 'php/content/schnittstelle.php';
	}
}


include 'php/footer.php';
?>