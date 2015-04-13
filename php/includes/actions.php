<?php
/**
 * Seitenübergreifende Formularverarbeitung
 *
 * SQL:
 * SELECT * FROM Tabellenname WHERE 1
 * INSERT INTO Tabellenname (`Spalte1`, `Spalte2`, ...) VALUES ("Wert1", "Wert2", ...)
 * UPDATE Tabellenname SET `Spalte1`="Wert" WHERE 1
 * DELETE FROM Tabellenname WHERE 1
 */
// MySQLi-Verbindung: $mysqli = $GLOBALS['mysqli']



// Session starten
session_start();
if ( !isset($_SESSION['User']) ) {
	$_SESSION['User'] = false;
}


// Sonderfall: Action-Variable setzen für Logout
if ( isset($_GET['action']) && $_GET['action']=='logout' ) {
	$_POST['action'] = 'logout';
}


// Rückmeldevariable erstellen
$action = isset($_POST['action']) ? $_POST['action'] : '';
if ( isset($_POST['action']) ) {
	$announcement = array();
	$announcement['action'] = $action;
	$announcement['status'] = false;
}
function announcement_query($announcement) {
	return urldecode(http_build_query(array('announcement'=>$announcement)));
}



/**
 * Demo-Zugang (Registrierung + Login)
 */
if ( $action == 'demologin' ) {
	if ( isset($_POST['human']) && $_POST['human'] == ''
		&& isset($_POST['ip']) && $_POST['ip'] == $_SERVER['REMOTE_ADDR'] ) {

		// Original Variablen:
		$username = 'Demobenutzer';
		$email = 'user@demo';
		$password = generatePassword();
		$password_hashed = md5($password.'v3gv1s1r');
		$registercode = generatePassword(9);
		$registertime = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		// SQL Variablen:
		$sql_username = $mysqli->real_escape_string( $username );
		$sql_email = $mysqli->real_escape_string( $email );
		$sql_password_hashed = $mysqli->real_escape_string( $password_hashed );
		$sql_registercode = $mysqli->real_escape_string( $registercode );
		$sql_registertime = $registertime;
		$sql_ip = $ip;
		
		// 
		// DB-Speicherung:
		// TODO .... mach es mit prepared statements....
		$sql = 'INSERT INTO users (`status`, `username`, `password`, `email`, `registertime`, `registercode`, `ip`) VALUES ("-1", "'.$sql_username.'", "'.$sql_password_hashed.'", "'.$sql_email.'", '.$sql_registertime.', "'.$sql_registercode.'", "'.$sql_ip.'")';
		$mysqli->query($sql);
		$userid = $mysqli->insert_id; // ID des _neuen_ DB-Eintrags

		// Login...
		$_SESSION['User'] = new User( $userid ); // Benutzerdaten in Session speichern
		$announcement['status'] = true;
		header('Location: '.$_SERVER['PHP_SELF'].'?'.announcement_query($announcement));
		exit;
	}
}



/**
 * Neue Registrierung
 */
if ( $action == 'register' ) {
	if ( !empty($_POST['username']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) { // Überprüfe Eingaben
		
		// Original Variablen:
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = generatePassword();
		$password_hashed = md5($password.'v3gv1s1r');
		$registercode = generatePassword(9);
		$registertime = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		// SQL Variablen:
		$sql_username = $mysqli->real_escape_string( $username );
		$sql_email = $mysqli->real_escape_string( $email );
		$sql_password_hashed = $mysqli->real_escape_string( $password_hashed );
		$sql_registercode = $mysqli->real_escape_string( $registercode );
		$sql_registertime = $registertime;
		$sql_ip = $ip;
		
		// Nickname und Email müssen neu sein:
		// .... TODO .... mach es prepared statements....
		$sql = 'SELECT id FROM users WHERE `username` LIKE '.$sql_username.' OR `email` LIKE '.$sql_email.'"';
		$result = $mysqli->query($sql);
		$affected_rows = $mysqli->affected_rows; // Anzahl veränderter Datensätze
		if ( $affected_rows < 1 ) {
		
			// DB-Speicherung:
			// TODO .... mach es mit prepared statements....
			$sql = 'INSERT INTO users (`username`, `password`, `email`, `registertime`, `registercode`, `ip`) VALUES ("'.$sql_username.'", "'.$sql_password_hashed.'", "'.$sql_email.'", '.$sql_registertime.', "'.$sql_registercode.'", "'.$sql_ip.'")';
			$mysqli->query($sql);
			$userid = $mysqli->insert_id; // ID des _neuen_ DB-Eintrags
			
			// Bestätigungs-Email versenden:
			$nachricht = "Willkommen, ".$username."!\n"
				."Ihr Passwort lautet: ".$password."\n\n"
				."Aktivierungslink:\n"
				."http://".$_SERVER["SERVER_NAME"]."?action=register_doi&userid=".$userid."&code=".$registercode;
			$mail = mail($email, 'Ihre Registrierung', $nachricht);
			$announcement['status'] = true;
			header('Location: '.$_SERVER['PHP_SELF'].'?'.announcement_query($announcement));
			exit;
		}
	}
}



/**
 * Doubleoptin-Registrierung (doi)
 * Bei Aufruf des Bestätigungslink in der Email, wird der Benutzer aktiviert.
 */
if ( $action == 'register_doi' ) {
	if ( !empty($_GET['code']) && !empty($_GET['userid']) ) {
		
		// Original Variablen:
		$userid = (int) $_GET['userid'];
		$registercode = $_GET['code'];
		
		// SQL Variablen:
		$sql_userid = (int) $userid;
		$sql_registercode = $mysqli->real_escape_string( $registercode );
		
		// Benutzer freischalten/aktivieren:
		$sql = 'UPDATE users SET `status`=1 WHERE id='.$sql_userid.' AND registercode="'.$sql_registercode.'"';
		$mysqli->query($sql);
		
		// Variable für die Ausgabe:
		$affected_rows = $mysqli->affected_rows; // Anzahl veränderter Datensätze
		if ( $affected_rows > 0 ) {
			$announcement['status'] = true;
			header('Location: '.$_SERVER['PHP_SELF'].'?'.announcement_query($announcement)); // Weiterleitung
			exit;
		}
	}
}



/**
 * Login (Authentifizierung)
 */
if ( $action == 'login' ) {
	if ( !empty($_POST['username']) && !empty($_POST['password']) ) {
		
		// Original Variablen:
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password_hashed = md5($password.'v3gv1s1r');
		
		// SQL-Prepared Variablen:
		$sqlp_username = $username;
		$sqlp_password = $password_hashed;
		
		// DB-Benutzer selektieren/auswählen:
		$stmt = $mysqli->prepare("SELECT id, status FROM users WHERE username=? AND password=?");
		if ( $stmt ) {
			$stmt->bind_param('ss', $username, $password_hashed); // bind parameters for markers
			$stmt->execute(); // execute query
			$stmt->bind_result($userid, $status); // bind result variables
			$stmt->fetch(); // fetch value
			$stmt->close(); // close statement
			
			// Benutzer gefunden:
			if ( $userid > 0 ) {
				
				// Status noch 0 => Status auf 1 setzen
				if ( $status == 0 ) {
					$sql = 'UPDATE users SET `status`=1 WHERE id='.$userid;
					$mysqli->query($sql);
				}
				
				$_SESSION['User'] = new User( $userid ); // Benutzerdaten in Session speichern
				$announcement['status'] = true;
				header('Location: '.$_SERVER['PHP_SELF']);
				exit;
			}
		}
	}
}



/**
 * Logout
 */
if ( $action == 'logout' ) {
	
	$_SESSION['User'] = false; // Benutzerdaten in Session speichern
	$announcement['status'] = true;
	header('Location: '.$_SERVER['PHP_SELF'].'?'.announcement_query($announcement));
	exit;
}



/**
 * "Passwort vergessen?"
 */
if ( $action == 'lostpassword' ) {
	if ( !empty( $_POST['email'] ) ) {
		
		// Original Variablen:
		$email = $_POST['email'];
		$resetcode = generatePassword(9);
		
		// SQL Variablen:
		$sql_email = $mysqli->real_escape_string( $email );
		$sql_resetcode = $mysqli->real_escape_string( $resetcode );
		
		// DB-Abfrage:
		$sql = 'SELECT id, username FROM users WHERE `email`="'.$sql_email.'"';
		$result = $mysqli->query($sql);
		if ( $row = $result->fetch_object() ) { // Eintrag existiert:
			$userid = $row->id;
			$username = $row->username;
			
			// ResetCode speichern:
			$sql = 'UPDATE users SET `resetcode`="'.$sql_resetcode.'" WHERE id='.$userid;
			$mysqli->query($sql);
			
			// Passwortreset-Email versenden:
			$nachricht = "Guten Tag ".$username."!\n"
				."Bitte klicken Sie auf diesen Link, dann können Sie Ihr Passwort zurücksetzen: \n\n"
				."http://".$_SERVER["SERVER_NAME"]."?action=resetpassword_doi&userid=".$userid."&resetcode=".$resetcode;
			// Weitere Vorlage und Dokument erstellen
			$mail = mail($email, 'Passwort zurücksetzen', $nachricht);
			$announcement['status'] = true;
			header('Location: '.$_SERVER['PHP_SELF'].'?'.announcement_query($announcement));
			exit;
		}
	}
}



/**
 * Passwort zurücksetzen
 */
if ( $action == 'resetpassword' ) {
	if ( !empty($_POST['newpassword']) && !empty($_POST['userid']) && !empty($_POST['resetcode']) ) {
		
		// Original Variablen:
		$userid = (int) $_POST['userid'];
		$resetcode = $_POST['resetcode'];
		$newpassword = $_POST['newpassword'];
		$newpassword_hashed = md5($newpassword.'v3gv1s1r');
		
		// SQL-Prepared Variablen:
		$sql_userid = (int) $userid;
		$sql_newpassword_hashed = $mysqli->real_escape_string( $newpassword_hashed );
		$sql_resetcode = $mysqli->real_escape_string( $resetcode );
		
		// DB-Benutzer selektieren/auswählen:
		$sql = 'UPDATE users SET `password`="'.$sql_newpassword_hashed.'", `resetcode`="" WHERE `id`='.$sql_userid.' AND `resetcode`="'.$sql_resetcode.'"';
		$mysqli->query($sql);
		$affected_rows = $mysqli->affected_rows; // Anzahl veränderter Datensätze
		if ( $affected_rows > 0 ) {
			$_SESSION['User'] = new User( $userid ); // Benutzerdaten in Session speichern
			$announcement['status'] = true;
			header('Location: '.$_SERVER['PHP_SELF'].'?'.announcement_query($announcement));
			exit;
		}
	}
}



if ( isset($_POST['action']) ) {
	$_GET['announcement'] = $announcement;
	unset($announcement);
}
?>