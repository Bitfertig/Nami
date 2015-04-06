<?php /* Passwort zurücksetzen */ ?>
<p>
	Bitte geben Sie Ihr neues Passwort ein.
</p>
<form name="resetpassword" method="post" action="">
	<input type="hidden" name="action" value="resetpassword" />
	<input type="hidden" name="userid" value="<?=req('userid', 'GET')?>" />
	<input type="hidden" name="resetcode" value="<?=req('resetcode', 'GET')?>" />
	<div class >
		<input type="password" name="newpassword" id="newpassword" value="" placeholder="Neues Passwort" required />
	</div><br />
	<div class="button">
		<input type="submit" value="Senden" />
	</div>
</form>
