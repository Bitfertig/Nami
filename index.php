<?php
include 'php/includes/config.php'; // Konfiguration
//include 'php/includes/classes.php'; // Klassen
include 'php/includes/functions.php'; // Funktionen
include 'php/includes/actions.php'; // Verarbeitungen



//Ausgabe
include 'php/header.php';

$mode = isset($_GET['mode']) ? $_GET['mode'] : '';


if ( $mode == 'login' ) {
	include 'php/content/login.php';
}
elseif ( $mode == 'register' ) {
	include 'php/content/register.php';
}
elseif ( $mode == 'passwort-vergessen' ) {
	include 'php/content/passwort-vergessen.php';
}
elseif ( $mode == 'passwort-zuruecksetzen' ) {
	include 'php/content/passwort-zuruecksetzen.php';
}
elseif ( $mode == 'schnittstelle' ) {
	include 'php/content/schnittstelle.php';
}



include 'php/footer.php';
?>