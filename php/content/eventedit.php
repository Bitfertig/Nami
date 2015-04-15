
<form name="demologin" id="eventedit" method="post" action="">
	<input type="hidden" name="action" value="eventedit" />
	<input type="hidden" name="id" value="<?=req('id')?>" />

	<h1>Veranstaltung editieren</h1>


	<h2>Veranstaltung</h2>
	<div>
		<input type="text" name="title" maxlength="255" required placeholder="Titel" value="" />
	</div><br />
	<div>
		<textarea name="description" maxlength="1023" placeholder="Beschreibung..."></textarea>
	</div><br />
	<div>
		<input type="text" name="keywords" maxlength="1023" placeholder="keyword A, keyword B,..." value="" />
	</div><br />
	<div>
		<select>
			
		</select>
	</div></br>


	<!-- Dates -->
	<h2>Veranstaltung-Dates</h2>
	...


	<div>
		<input type="button" class="demo" value="Löschen" />
		<input type="button" class="demo" value="Parken" />
		<input type="submit" class="demo" value="Veröffentlichen" />
	</div>
</form>
