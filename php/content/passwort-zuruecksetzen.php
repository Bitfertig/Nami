<?php /* Passwort zurücksetzen */ ?>
<p>
	Bitte geben Sie Ihr neues Passwort ein.
</p>
<form name="resetpassword" method="post" action="">
	<input type="hidden" name="action" value="resetpassword" />
	<input type="hidden" name="userid" value="<?=req('userid', 'GET')?>" />
	<input type="hidden" name="resetcode" value="<?=req('resetcode', 'GET')?>" />
	<div>
		<label for="newpassword">Neues Passwort</label><br />
		<input type="password" name="newpassword" id="newpassword" value="" required />
	</div><br />
	<div>
		<input type="submit" value="Senden" />
	</div>
</form>
