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
<a href="?mode=passwort-vergessen" title="Passwort vergessen?">Passwort vergessen?</a><br />
<a href="?action=logout" title="Logout">Logout</a>
<pre><?php
print_r($_SESSION['VV']['User']);
?></pre>
