<?php /* Registrierung */ ?>
<h2>Registrierung</h2>
<form name="register" method="post" action="">
	<input type="hidden" name="action" value="register" />
	<div>
		<label for="username">Benutzername</label><br />
		<input type="text" name="username" id="username" value="" required />
	</div><br />
	<div>
		<label for="email">E-Mail</label><br />
		<input type="text" name="email" id="email" value="" required />
	</div><br />
	<div>
		<input type="submit" value="Registrieren" />
	</div>
</form>
<a href="?mode=login">Login</a>
<?php


/*if ( isset($MESSAGE = 'register') ) {
	if ( $MESSAGE Register == true ) {
		echo "Email wurde verschickt.";
	}
	else{
		echo "Registrierung fehlgeschlagen.";
	}
}*/

?>
