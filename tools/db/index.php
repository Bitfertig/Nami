<?php

include 'database.func.php';

define('DBHOST', 'localhost');
define('DBNAME', 'nami');
define('DBUSER', 'root');
define('DBPASS', 'root');


// backup & import
$dir = dirname(__FILE__).'/backups'; // directory files
$name = 'backup'; // name sql backup
$tables_whitelist = 'all'; // Alle DB-Tabellen komplett sichern/löschen/ersetzen
//$tables_whitelist = array('users', 'events', 'eventdates', 'eventfiles'); // Tabellen die gesichert/ersetzt werden sollen



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
			.container { max-width:900px; margin:0 auto; padding:15px; }
			.row { display:table; table-layout:fixed; width:100%; }
			.col { display:table-cell; }
		</style>
	</head>
	<body>
	
		<div class="container">

			<h1>Datenbank</h1>

			<div class="row">
				<div class="col">
					<h2>Backup</h2>
					<form method="get" action="">
						<input type="hidden" name="mode" value="backup" />
						<input type="submit" value="Backup..." />
					</form>
				</div>
				<div class="col">
					<h2>Import</h2>
					<form method="get" action="">
						<input type="hidden" name="mode" value="import" />
						<select name="filename">
							<?php
							$files = array_reverse(glob($dir."/*.sql"));
							foreach ($files as $filename) {
								$f = pathinfo($filename);
								$t = explode('_', $f['filename']);
								$t = explode('-', $t[1]);
								$t = date('d.m.Y H:i:s', strtotime($t[2].'-'.$t[1].'-'.$t[0].' '.$t[3].':'.$t[4].':'.$t[5])) . ' Uhr';
							    echo '<option value="'.$f['filename'].'">Backup '.$t.'</option>';
							}
							?>
						</select>
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
	print_r( database_backup( $dir, $name, $tables_whitelist, DBHOST, DBUSER, DBPASS, DBNAME) ); // execute backup
} 
// Import
elseif ( $MODE == 'import' ) {
	$name = isset($_GET['filename']) ? $_GET['filename'] : $name;
	$file = $dir.'/'.$name.'.sql'; // sql data file
	$args = file_get_contents($file); // get contents
	print_r( database_import( $args, $tables_whitelist, DBHOST, DBUSER, DBPASS, DBNAME) ); // execute import
}

?>
