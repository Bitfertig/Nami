<?php /* Registrierung */ ?>
<h2>Registrierung</h2>
<form name="register" method="post" action="">
	<input type="hidden" name="action" value="register" />
	<div>
		<label for="">Benutzername</label><br />
		<input type="text" name="Benutzername" value="" />
	</div><br />
	<div>
		<label for="">E-Mail</label><br />
		<input type="text" name="Email" value="" />
	</div><br />
	<div>
		<input type="submit" value="Registrieren" />
	</div>
</form>
<?php


if ( isset($VVACTION_Register) ) {
	if ( $VVACTION_Register == true ) {
		echo "Email wurde verschickt.";
	}
	else{
		echo "Registrierung fehlgeschlagen.";
	}
}

?>
