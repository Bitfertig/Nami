<?php /* Registrierung */ ?>
<h2>Registrierung</h2>
<form name="register" method="post" action="">
	<input type="hidden" name="action" value="register" />
	<div>
		<input type="text" name="username" id="username" value="" placeholder="Benutzername" required />
	</div><br />
	<div>
		<input type="text" name="email" id="email" value="" placeholder="E-Mail" required />
	</div><br />
	<div class="table">
		<div class="table-cell">
			<a href="?mode=login">Zurück zum Login</a>
		</div>
		<div class="table-cell right">
			<input type="submit" value="Registrieren" />
		</div>
	</div>
</form>

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
