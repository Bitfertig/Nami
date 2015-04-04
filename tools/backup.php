<?php

include 'database.func.php';


// backup
$dir = dirname(file); // directory files
$name = 'backup'; // name sql backup

define('DBHOST', 'localhost');
define('DBNAME', 'nami');
define('DBUSER', 'root');
define('DBPASS', 'root');

print_r( backup_database( $dir, $name, DBHOST, DBUSER, DBPASS, DBNAME) ); // execute

?>