<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Vegvisir Nami - Die Veranstaltungsverwaltung</title>
	<link type="text/css" rel="stylesheet" href="res/css/main.css" />
	<script src="res/js/jquery-2.1.3.min.js"></script>
	<script src="res/js/main.js"></script>
</head>
<body>

	<header>
		<div class="container">

			<div class="logo"><a href="" title="Zur Startseite"><img src="res/img/logo-vertikal.png" alt="" /></a></div>
			
			<nav>
				<ul>
					<li><a href="#info">Angebot</a></li>
					<li><a href="#ueberuns">Über uns</a></li>
					<li><a href="#kontakt">Kontakt</a></li>
				</ul>
			</nav>

			<a href="/" title="Zur Veranstaltungsverwaltung..." class="login-btn">Zur Verwaltung</a>

		</div>
	</header>


	<main>
		<div class="container">

			<section class="s1">
				<div><h1>Veranstaltungs<br />verwaltung</h1></div>
				<div class="claim">Weniger ist Trumpf.</div>
			</section>

			<a id="info"></a>
			<section class="s2">
				<h2>Das Angebot</h2>
				...Vorteile......
				...Mantis...
			</section>

			<a id="ueberuns"></a>
			<section class="s3">
				<h2>Wir sind...</h2>
				<div class="grid">
					<div class="grid-col person">
						<div class="foto img-protect">
							<img src="res/img/foto-aurel.jpg" alt="" />
						</div>
						<div class="info">
							<div class="name">Aurel Hermand</div>
							<div class="descr">Entwickler</div>
						</div>
					</div>
					<div class="grid-col person">
						<div class="foto img-protect">
							<img src="res/img/foto-benjamin.jpg" alt="" />
						</div>
						<div class="info">
							<div class="name">Benjamin Hermand</div>
							<div class="descr">Entwickler</div>
						</div>
					</div>
				</div>
			</section>

			<a id="kontakt"></a>
			<section class="s4">
				<h2>Kontaktiere uns</h2>
				<form method="post" action="">
					<input type="hidden" name="action" value="contact" />
					<input type="text" class="human" name="author" value="" />
					<div class="control">
						<input type="text" name="name" value="" placeholder="Ihr Name" required />
					</div>
					<div class="control">
						<input type="email" name="email" value="" placeholder="Ihre E-Mail" required /><br />
					</div>
					<div class="control">
						<textarea name="text" required>Hallo Team Nami,<?="\n\n"?></textarea>
					</div>
					<div class="control-submit">
						<input type="submit" value="E-Mail senden" />
					</div>
				</form>
			</section>
		</div>
	</main>


	<footer>
		<div class="container">

			<div class="fnav">
				<a href="#" title="Impressum" class="open-lightbox" data-id="lb-impressum">Impressum</a>
				<a href="#" title="Datenschutz" class="open-lightbox" data-id="lb-datenschutz">Datenschutz</a>
				<a href="#" title="Allgemeine Geschäftsbedingungen" class="open-lightbox" data-id="lb-agb">AGB</a>
			</div>

			<div class="copyright">&copy; seit 2015 Vegvisir</div>

		</div>
	</footer>


	<div style="display:none;" id="lb-impressum"><h2>Impressum</h2>...</div>
	<div style="display:none;" id="lb-datenschutz"><h2>Datenschutz</h2>...</div>
	<div style="display:none;" id="lb-agb"><h2>Allgemeine Geschäftsbedingungen</h2>...</div>

</body>
</html>