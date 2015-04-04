<?php /* Passwort vergessen? */ ?>
<p>
	Sie haben Ihr Passwort vergessen? Hier haben Sie die Möglichkeit Ihr Passwort über das Double-Optin-Verfahren zurückzusetzen.
	Geben Sie dazu Ihre E-Mail-Adresse ein, dann erhalten Sie per E-Mail einen Link, worüber Sie Ihr neues Passwort erstellen können.
</p>
<form name="lostpassword" method="post" action="">
	<input type="hidden" name="action" value="lostpassword" />
	<div>
		<label for="">E-Mail</label><br />
		<input type="text" name="Email" value="" required />
	</div><br />
	<div>
		<input type="submit" value="Senden" />
	</div>
</form>
