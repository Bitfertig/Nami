<?php /* Passwort zurücksetzen */ ?>
<p>
	Bitte geben Sie Ihr neues Passwort ein.
</p>
<form name="resetpassword" method="post" action="">
	<input type="hidden" name="action" value="resetpassword" />
	<input type="hidden" name="userid" value="<?=retvar('userid', 'GET')?>" />
	<input type="hidden" name="resetcode" value="<?=retvar('resetcode', 'GET')?>" />
	<div>
		<label for="">Neues Passwort</label><br />
		<input type="password" name="PasswordNew" value="" required />
	</div><br />
	<div>
		<input type="submit" value="Senden" />
	</div>
</form>
