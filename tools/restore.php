<?php

include 'database.func.php';


// import
$name = 'backup'; // name sql backup
$file = dirname(FILE).'/'.$name.'.sql'; // sql data file
$args = file_get_contents($file); // get contents

define('DBHOST', 'localhost');
define('DBNAME', 'nami');
define('DBUSER', 'root');
define('DBPASS', 'root');

print_r( mysqli_import_sql( $args, DBHOST, DBUSER, DBPASS, DBNAME) ); // execute

?>