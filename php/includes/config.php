<?php

// Datenbank Einstellung
define('DBHOST', 'localhost');
define('DBPORT', 8889);
define('DBNAME', 'nami');
define('DBUSER', 'root');
define('DBPASS', 'root');


// PHP-Fehlerausgabe aktivieren
ini_set('display_errors', '1');
error_reporting(E_ALL);// & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);


// MySQLi Verbindung aufbauen
$GLOBALS['mysqli'] = $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// PDO Verbindung aufbauen
$GLOBALS['pdo'] = $pdo = new PDO('mysql:host='.DBHOST.';port='.DBPORT.';dbname='.DBNAME, DBUSER, DBPASS, array( PDO::ATTR_PERSISTENT => false));


?>