<div class="sidebar">


	<?php if ( isset($_GET['dev']) ) { echo '<pre>'; print_r($_SESSION['User']); echo '</pre>'; } ?>
	<div class="user">
		<?=$_SESSION['User']->get('username')?> <a href="?action=logout">Logout</a><br />
		<a href="?mode=userconfig">Einstellungen</a>
	</div>


	<nav>
		<ul>
			<li><a href="?mode=start">Veranstaltungen</a>
			<!-- Version 2.0.0: <li><a href="?mode=aggregat">Aggregat</a></li> -->
			<li><a href="?mode=schnittstelle">Schnittstelle</a></li>
		</ul>
	</nav>


</div>