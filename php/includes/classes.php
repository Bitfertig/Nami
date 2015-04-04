<?php

/**
 * VVUser
 * Instanziiert einen Benutzer
 *
 * @author Aurelian Hermand - ah - aurel@hermand.de
 * @version 1.0.0 - 28.03.2015 - ah - Initiale Version
 */
class VVUser {
	
	private $data;
	
	/**
	 * Konstruktor
	 * @param ID Benutzer-ID
	 * @return $this
	 */
	function VVUser($id) {
		
		$mysqli = $GLOBALS['VV_DB'];
		$stmt = $mysqli->prepare("SELECT * FROM vvUsers WHERE ID=?");
		if ( $stmt ) {
			$stmt->bind_param('i', $id); // Fragezeichen (?) ersetzen
			$stmt->execute(); // SQL-Query ausführen
			
			// Alle Felder auslesen:
			$meta = $stmt->result_metadata();
			while ($field = $meta->fetch_field()) {
				$parameters[] = &$row[$field->name];
			}
			call_user_func_array(array($stmt, 'bind_result'), $parameters);
			while ($stmt->fetch()) {
				foreach($row as $key => $val) {
					$x[$key] = $val;
				}
				$results[] = $x;
			}
			
			// Daten als Eigenschaft ablegen:
			$this->data = $results[0];
			
			return $this;
		}
		
		return false;
	}
	function get($key) { return $this->data[$key]; }
	function set($key, $val) { $this->data[$key] = $val; }
}
/*
$VVUser = new VVUser(1);
echo $VVUser->get('Nickname');
$VVUser->set('Birthday', 3333);
echo $VVUser->get('Birthday');
*/


?>