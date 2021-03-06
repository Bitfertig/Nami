<?php

// Funktion um eine Request oder Global Variable zurückzuliefern
function reqorglob($reqname) {
	if ( isset($_POST['action']) ) {
		return req($reqname);
	}
	return isset($GLOBALS[$reqname]) ? $GLOBALS[$reqname] : '';
}



$userid = $_SESSION['User']->get('id');
$eventid = req('id', 'GET');



if ( !empty($eventid) ) {
	$sql = 'SELECT * FROM events WHERE userid = :userid AND id = :eventid';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
	$stmt->bindParam(':eventid', $eventid, PDO::PARAM_INT);
	$stmt->execute();

	$count = $stmt->rowCount();

	if ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$GLOBALS['id'] = $row->id;
		$GLOBALS['title'] = $row->title;
		$GLOBALS['description'] = $row->description;
		$GLOBALS['keywords'] = $row->keywords;
		$GLOBALS['status'] = $row->keywords;
	}

}
?>



<form name="demologin" id="eventedit" method="post" action="">
	<input type="hidden" name="action" value="eventedit" />
	<input type="hidden" name="id" value="<?=req('id', 'GET')?>" />



	<h1>Veranstaltung editieren</h1>


	<h2>Veranstaltung</h2>
	<div>
		<input type="text" name="title" maxlength="255" required placeholder="Titel" value="<?=htmlspecialchars(reqorglob('title'))?>" />
	</div><br />
	<div>
		<textarea name="description" maxlength="1023" placeholder="Beschreibung..."><?=htmlspecialchars(reqorglob('description'))?></textarea>
	</div><br />
	<div>
		<input type="text" name="keywords" maxlength="1023" placeholder="Schlüsselwort A, Schlüsselwort B,..." value="<?=htmlspecialchars(reqorglob('keywords'))?>" />
	</div><br />
	<div>
		Bild
	</div></br>


	<!-- Dates -->
	<h2>Veranstaltung-Dates</h2>
	...

<?php
/*
http://www.nncron.ru/help/EN/working/cron-format.htm

* * * * * *
| | | | | | 
| | | | | +-- Year              (range: 1900-3000)
| | | | +---- Day of the Week   (range: 1-7, 1 standing for Monday)
| | | +------ Month of the Year (range: 1-12)
| | +-------- Day of the Month  (range: 1-31)
| +---------- Hour              (range: 0-23)
+------------ Minute            (range: 0-59)

List: 0,1,2
Range: 1-5
Interval: *./4 0-23/2
*/

function cronTimestampGenerator($cron, $max=10) { // iterator? yield in php?
	$timestamps = array();
	$cron = explode(' ', $cron);
	$data = array(
		'minute' => $cron[0],
		'hour' => $cron[1],
		'day_of_month' => $cron[2],
		'month' => $cron[3],
		'day_of_week' => $cron[4],
		'year' => $cron[5]
	);

	// 1. Umwandeln von minutes in Sekunden
	$_m = explode(',', $data['minute']);
	$minutes = array();
	foreach ($_m as $m) {
		if ( $_m == '*' ) { // Asterisk ("every")
			array_push($minutes, range(0, 59));
		} elseif ( strpos($_m, '-') !== false ) { // Range: 1-5
			$split = explode('-', $_m);
			$from = $split[0];
			$from = $split[1];
			array_push($minutes, range($from, $to));
		} elseif ( strpos($_m, '/') !== false ) { // Interval: 1/5

		} else {
			$minutes[] = 0;
		}

		yield $minutes;
	}


	//return $data; // Timestamp
}


if ( !empty($eventid) ) {

	$sql = 'SELECT * FROM eventdates WHERE eventid = :eventid';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':eventid', $eventid, PDO::PARAM_INT);
	$stmt->execute();

	$count = $stmt->rowCount();

	while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$GLOBALS['id'] = $row->id;
		echo $GLOBALS['startdate'] = $row->startdate;
		echo $GLOBALS['duration'] = $row->duration;
		echo '<br />'. print_r(cronTimestampGenerator($GLOBALS['startdate']), true). '<br /><hr /><br /><br />';
	}

}

?>


	<div>
		<input type="button" class="demo" value="Löschen" />
		<input type="button" class="demo" value="Parken" />
		<input type="submit" class="demo" value="Veröffentlichen" />
	</div>
</form>
