<?php
if ( isset($VVAction_Login) && !$VVAction_Login ) {
	echo 'Login fehlgeschlagen.';
}
?>

<?php /* Anmelden */ ?>
<h2>Login</h2>
<form name="login" method="post" action="">
	<input type="hidden" name="action" value="login" />
	<div>
		<label for="">Benutzername</label><br />
		<input type="text" name="Benutzername" value="" required />
	</div><br />
	<div>
		<label for="">Passwort</label><br />
		<input type="password" name="Benutzerpasswort" value="" required />
	</div><br />
	<div>
		<input type="submit" value="Login" />
	</div>
</form>
<a href="<we:url id="44" />" title="Passwort vergessen?">Passwort vergessen?</a><br />
<a href="<we:url id="self" />?action=logout" title="Logout">Logout</a>
<pre><?php
print_r($_SESSION['VV']['User']);
?></pre>

<hr />

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
