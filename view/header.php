<?php ob_start(); ?>
<header>
	<nav>
		<img src="assets/img/logo.png" alt="le logo de l'établissement en noir et blanc">
		<div class="menu-burger">
			<input type="checkbox" aria-label="déplier le menu">
			<span></span>
			<span></span>
			<span></span>
			<ul>
				<li><a <?= $homePage ?? '' ?> href="index.php?action=home">Accueil</a></li>
				<li><a <?= $restoPage ?? '' ?> href="index.php?action=restaurant">Le Restaurant</a></li>
				<li><a href="cafe.html">Le Café-Bar</a></li>
				<li><a href="beer-discovery-project.html">Beer Discovery Project</a></li>
				<li><a href="brunch.html">Le Brunch</a></li>
				<li><a href="agenda.html">Agenda</a></li>
				<li><a href="contact.html">Infos & contact</a></li>
				<li><a class="btn" href="" target="_blank" rel="noopener">Je réserve !</a></li>
			</ul>
		</div>
	</nav>
</header>
<?php $header = ob_get_clean(); ?>