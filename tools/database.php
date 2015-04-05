<?php

include 'database.func.php';

define('DBHOST', 'localhost');
define('DBNAME', 'nami');
define('DBUSER', 'root');
define('DBPASS', 'root');


// backup & import
$dir = dirname(file).'/backups'; // directory files
$name = 'backup'; // name sql backup



$MODE = isset($_GET['mode']) ? $_GET['mode'] : '';

// Default
if ( $MODE == '' ) {
	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Datenbank Backup &amp; Import</title>
		<style>
			* { box-sizing:border-box; }
			body { font:12px/120% Arial, sans-serif; }
			.container { max-width:; margin:0 auto; }
			.row {}
			.col { width:; }
		</style>
	</head>
	<body>
	
		<div class="container">

			<h1>Datenbank Backup &amp; Import</h1>

			<div class="row">
				<div class="col">
					<form method="get" action="?mode=backup">
						<input type="submit" value="Backup..." />
					</form>
				</div>
				<div class="col">
					<form method="get" action="?mode=import">
						<input type="submit" value="Import..." />
					</form>
				</div>
			</div>

		</div>

	</body>
	</html>

	<?php
}
// Backup
elseif( $MODE == 'backup' ) {
	print_r( backup_database( $dir, $name, DBHOST, DBUSER, DBPASS, DBNAME) ); // execute backup
} 
// Import
elseif ( $MODE == 'import' ) {
	$file = dirname(FILE).'/backups/'.$name.'.sql'; // sql data file
	$args = file_get_contents($file); // get contents
	print_r( mysqli_import_sql( $args, DBHOST, DBUSER, DBPASS, DBNAME) ); // execute import
}

?>