<?php

	// Logs an array like $we_doc to firebug etc. -ah2013
	function c_l($r) {
		echo '<script>var console=console||{"log":function(){}};console.log('.json_encode($r).');</script>';
	}

	// Email Verschleierung mit HTML Entities -ah2014
	function obscure_email($e) {
		$output = '';
		for ($i = 0; $i < strlen($e); $i++) {
			$output .= '&#'.ord($e[$i]).';';
		}
		return $output;
	}

	// Fehlendes "http://" hinzufügen -ah2014
	function addScheme($url, $scheme = 'http://') {
		return parse_url($url, PHP_URL_SCHEME) === null ? $scheme . $url : $url;
	}

	// Passwort-Generator
	function generatePassword($length = 8) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);
		
		for ($i = 0, $result = ''; $i < $length; $i++) {
			$index = rand(0, $count - 1);
			$result .= mb_substr($chars, $index, 1);
		}
		
		return $result;
	}

	// Request Variable zurückliefern (nützlich damit kein isset() benötigt wird)
	function req($name, $type='POST') {
		$gl = ($type=='POST') ? $_POST : $_GET;
		return isset($gl[$name]) ? $gl[$name] : '';
	}

?>