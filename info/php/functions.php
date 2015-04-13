<?php

// Email Verschleierung mit HTML Entities -ah2014
function obscure_email($e) {
	$output = '';
	for ($i = 0; $i < strlen($e); $i++) {
		$output .= '&#'.ord($e[$i]).';';
	}
	return $output;
}

// Request Variable zurückliefern (nützlich damit kein isset() benötigt wird)
function req($name, $type='POST') {
	$gl = ($type=='POST') ? $_POST : $_GET;
	return isset($gl[$name]) ? $gl[$name] : '';
}

?>