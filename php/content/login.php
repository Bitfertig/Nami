<?php
/*if ( $MESSAGE == 'login-failed' ) {
	echo 'Login fehlgeschlagen.';
}*/
?>

<?php /* Anmelden */ ?>
<h2>Login</h2>
<form name="login" method="post" action="">
	<input type="hidden" name="action" value="login" />
	<div>
		<label for="username">Benutzername</label><br />
		<input type="text" name="username" id="username" value="" required />
	</div><br />
	<div>
		<label for="password">Passwort</label><br />
		<input type="password" name="password" id="password" value="" required />
	</div><br />
	<div>
		<input type="submit" value="Login" />
	</div>
</form>
<a href="?mode=lostpassword" title="Passwort vergessen?">Passwort vergessen?</a><br />
<a href="?mode=register" title="Registrieren">Jetzt Registrieren</a> oder <a href="?mode=demo" title="Demo">Demo</a><br />


