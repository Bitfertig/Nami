<?php

// Datenbank Einstellung
define('DBHOST', 'localhost');
define('DBNAME', 'nami');
define('DBUSER', 'root');
define('DBPASS', 'root');


// PHP-Fehlerausgabe aktivieren
ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);


// MySQLi verbindung aufbauen
$GLOBALS['mysqli'] = $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);



?>