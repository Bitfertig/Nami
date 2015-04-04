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

// MySQLi-Verbindung: $VV_DB = $GLOBALS['VV_DB']

// Session Variable erstellen
if ( !isset($_SESSION['VV']) ) {
	$_SESSION['VV'] = array();
}

// Action-Variable setzen
$_ACTION = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');



/**
 * Neue Registrierung
 */
if ( $_ACTION == 'register' ) {
	if ( !empty($_POST['Benutzername']) && !empty($_POST['Email']) && filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL) ) { // Überprüfe Eingaben
		
		// Original Variablen:
		$nickname = $_POST['Benutzername'];
		$email = $_POST['Email'];
		$password = generatePassword();
		$password_hashed = md5($password.'v3gv1s1r');
		$code = generatePassword(9);
		$register = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		// SQL Variablen:
		$sql_nickname = $GLOBALS['VV_DB']->real_escape_string( $nickname );
		$sql_email = $GLOBALS['VV_DB']->real_escape_string( $email );
		$sql_password_hashed = $GLOBALS['VV_DB']->real_escape_string( $password_hashed );
		$sql_code = $GLOBALS['VV_DB']->real_escape_string( $code );
		$sql_register = $register;
		$sql_ip = $ip;
		
		// Nickname und Email müssen neu sein:
		$sql = 'SELECT ID FROM vvUsers WHERE `Nickname` LIKE '.$sql_nickname.' OR `Email` LIKE '.$sql_email.'"';
		$result = $GLOBALS['VV_DB']->query($sql);
		$affected_rows = $GLOBALS['VV_DB']->affected_rows; // Anzahl veränderter Datensätze
		if ( $affected_rows < 1 ) {
		
			// DB-Speicherung:
			$sql = 'INSERT INTO vvUsers (`Nickname`, `Password`, `Email`, `Register`, `Code`, `IP`) VALUES ("'.$sql_nickname.'", "'.$sql_password_hashed.'", "'.$sql_email.'", '.$sql_register.', "'.$sql_code.'", "'.$sql_ip.'")';
			$GLOBALS['VV_DB']->query($sql);
			$userid = $GLOBALS['VV_DB']->insert_id; // ID des _neuen_ DB-Eintrags
			
			// Bestätigungs-Email versenden:
			$nachricht = "Willkommen, ".$nickname."!\n"
				."Ihr Passwort lautet: ".$password."\n\n"
				."Aktivierungslink:\n"
				."http://".$_SERVER["SERVER_NAME"].id_to_path(39)."?action=register_doi&userid=".$userid."&code=".$code;
			$mail = mail($_POST['Email'], 'Ihre Registrierung', $nachricht);
		}
	}
	$VVAction_Register = false;
}



/**
 * Doubleoptin-Registrierung (doi)
 * Bei Aufruf des Bestätigungslink in der Email, wird der Benutzer aktiviert.
 */
if ( $_ACTION == 'register_doi' ) {
	if ( !empty($_GET['code']) && !empty($_GET['userid']) ) {
		
		// Original Variablen:
		$userid = (int) $_GET['userid'];
		$code = $_GET['code'];
		
		// SQL Variablen:
		$sql_userid = (int) $userid;
		$sql_code = $GLOBALS['VV_DB']->real_escape_string( $code );
		
		// Benutzer freischalten/aktivieren:
		$sql = 'UPDATE vvUsers SET `Status`=1 WHERE ID='.$sql_userid.' AND Code="'.$sql_code.'"';
		$GLOBALS['VV_DB']->query($sql);
		
		// Variable für die Ausgabe:
		$affected_rows = $GLOBALS['VV_DB']->affected_rows; // Anzahl veränderter Datensätze
		if ( $affected_rows > 0 ) {
			header('Location: '.$_SERVER['PHP_SELF']); // Weiterleitung
		}
	}
	$VVAction_Registerdoi = false;
}



/**
 * Login (Authentifizierung)
 */
if ( $_ACTION == 'login' ) {
	if ( !empty($_POST['Benutzername']) && !empty($_POST['Benutzerpasswort']) ) {
		
		// Original Variablen:
		$nickname = $_POST['Benutzername'];
		$password = $_POST['Benutzerpasswort'];
		$password_hashed = md5($password.'v3gv1s1r');
		
		// SQL-Prepared Variablen:
		$sqlp_nickname = $nickname;
		$sqlp_password = $password_hashed;
		
		// DB-Benutzer selektieren/auswählen:
		$stmt = $GLOBALS['VV_DB']->prepare("SELECT ID, Status FROM vvUsers WHERE Nickname=? AND Password=?");
		if ( $stmt ) {
			$stmt->bind_param('ss', $nickname, $password_hashed); // bind parameters for markers
			$stmt->execute(); // execute query
			$stmt->bind_result($userid, $status); // bind result variables
			$stmt->fetch(); // fetch value
			$stmt->close(); // close statement
			
			// Benutzer gefunden:
			if ( $userid > 0 ) {
				
				// Status noch 0 => Status auf 1 setzen
				if ( $status == 0 ) {
					$sql = 'UPDATE vvUsers SET `Status`=1 WHERE ID='.$userid;
					$GLOBALS['VV_DB']->query($sql);
				}
				
				$_SESSION['VV']['User'] = new VVUser( $userid ); // Benutzerdaten in Session speichern
				header('Location: '.$_SERVER['PHP_SELF']); // Weiterleitung
			}
		}
	}
	$VVAction_Login = false; // Login fehlgeschlagen
}



/**
 * Logout
 */
if ( $_ACTION == 'logout' ) {
	
	$_SESSION['VV']['User'] = array(); // Benutzerdaten in Session speichern
	header('Location: '.$_SERVER['PHP_SELF']); // Weiterleitung
	
}



/**
 * "Passwort vergessen?"
 */
if ( $_ACTION == 'lostpassword' ) {
	if ( !empty( $_POST['Email'] ) ) {
		
		// Original Variablen:
		$email = $_POST['Email'];
		$resetcode = generatePassword(9);
		
		// SQL Variablen:
		$sql_email = $GLOBALS['VV_DB']->real_escape_string( $email );
		$sql_resetcode = $GLOBALS['VV_DB']->real_escape_string( $resetcode );
		
		// DB-Abfrage:
		$sql = 'SELECT ID, Nickname FROM vvUsers WHERE `Email`="'.$sql_email.'"';
		$result = $GLOBALS['VV_DB']->query($sql);
		if ( $row = $result->fetch_object() ) { // Eintrag existiert:
			$userid = $row->ID;
			$nickname = $row->Nickname;
			
			// ResetCode speichern:
			$sql = 'UPDATE vvUsers SET `ResetCode`="'.$sql_resetcode.'" WHERE ID='.$userid;
			$GLOBALS['VV_DB']->query($sql);
			
			// Passwortreset-Email versenden:
			$nachricht = "Guten Tag ".$nickname."!\n"
				."Bitte klicken Sie auf diesen Link, dann können Sie Ihr Passwort zurücksetzen: \n\n"
				."http://".$_SERVER["SERVER_NAME"].id_to_path(45)."?action=resetpassword_doi&userid=".$userid."&resetcode=".$resetcode;
			// Weitere Vorlage und Dokument erstellen
			$mail = mail($_POST['Email'], 'Passwort zurücksetzen', $nachricht);
			header('Location: '.$_SERVER['PHP_SELF']); // Weiterleitung
		}
	}
	$VVAction_Lostpassword = false;
}



/**
 * Passwort zurücksetzen
 */
if ( $_ACTION == 'resetpassword' ) {
	if ( !empty($_POST['PasswordNew']) && !empty($_POST['userid']) && !empty($_POST['resetcode']) ) {
		
		// Original Variablen:
		$userid = (int) $_POST['userid'];
		$resetcode = $_POST['resetcode'];
		$password = $_POST['PasswordNew'];
		$password_hashed = md5($password.'v3gv1s1r');
		
		// SQL-Prepared Variablen:
		$sql_userid = (int) $userid;
		$sql_password_hashed = $GLOBALS['VV_DB']->real_escape_string( $password_hashed );
		$sql_resetcode = $GLOBALS['VV_DB']->real_escape_string( $resetcode );
		
		// DB-Benutzer selektieren/auswählen:
		$sql = 'UPDATE vvUsers SET `Password`="'.$sql_password_hashed.'", `ResetCode`="" WHERE `ID`='.$sql_userid.' AND `ResetCode`="'.$sql_resetcode.'"';
		$GLOBALS['VV_DB']->query($sql);
		$affected_rows = $GLOBALS['VV_DB']->affected_rows; // Anzahl veränderter Datensätze
		if ( $affected_rows > 0 ) {
			$_SESSION['VV']['User'] = new VVUser( $userid ); // Benutzerdaten in Session speichern
			header('Location: '.$_SERVER['PHP_SELF']); // Weiterleitung
		}
	}
	$VVAction_Resetpassword = false;
}

?>