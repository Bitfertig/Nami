<?php
include "res/php/config.php";
include "res/php/functions.php";
include "res/php/actions.php";

//Ausgabe
include "res/header.php";

$mode = isset($_GET["mode"]) ? $_GET["mode"] : "";

if( $mode == "register"){
	include "res/php/register.php";
}
elseif( $mode == "login"){
	include "res/php/login.php";
}

include "res/footer.php";


?>