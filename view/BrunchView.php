<?php 
$headDescription = "Restaurant à Wavre. Voici la carte du p'tit déj ainsi que celle des brunchs.";
$headTitle = 'Restaurant & Café-Bar Citizen Kane - Le Brunch';

ob_start(); ?>
<div id="main" class="main">
	<section class="restaurant-intro cafe-intro">
		<div id="carousel" class="carousel-container">
   			<img src="assets/img/brunch_oeufsbacon_small.jpg" alt="photo d'une assiette avec divers aliments dont des oeufs et du bacon">
   			<button class="displayNone"><<</button>
   			<button class="displayNone">>></button>
	   		<div class="carousel-nav">
	   		</div>
   		</div>
   		<div>
			<h1>P’tits déjs & Brunchs</h1>
			<p>Le Citizen Kane vous accueille pour le p’tit déj tous les jours & pour le brunch tous les dimanches et les jours fériés.</p>
			<h2>Quand Profiter du P'tit Déj ?</h2>
			<ul>
				<li>Du lundi au samedi de 8h30 à 11h</li>
				<li>Dimanche & jours fériés de 10h à 14h</li>
			</ul>
			<h2>Quand Profiter du Brunch ?</h2>
			<ul>
				<li>Dimanche & jours fériés de 10h à 14h</li>
			</ul>
		</div>
	</section>
	<section id="carteResto" class="restaurant-cartes">
		<h2>Nos Cartes</h2>

		<?= $carteView ?>

		<a class="btn" href="">Réserver une Table</a>
	</section>
	<section class="home_form">
		<a href="https://fr.tripadvisor.be/Restaurant_Review-g188643-d7221922-Reviews-Citizen_Kane-Wavre_Walloon_Brabant_Province_Wallonia.html" target="_blank" rel="noopener"><img src="assets/img/logo_tripadvisor.svg" alt="le logo de tripadvisor"></a>
		<form method="post" action="">
			<fieldset>
    			<legend class="underline">Inscrivez-vous à notre newsletter !</legend>
       			<label for="email">Adresse Mail*</label>
       			<input id="email" type="email" name="email" required>
       			<label for="name">Nom</label>
       			<input id="name" type="text" name="name">
       			<label for="firstName">Prénom</label>
       			<input id="firstName" type="text" name="firstName">
       			<p>* = required field</p>
       			<input class="btn" type="submit" value="inscription">
       		</fieldset>
		</form>
	</section>
	<?php 
	if ($admin === true)
	{
	?>
		 <div class="recordChangesContainer">
			<button id="recordChanges" class="btn displayNone btn_recordChanges">Enregistrer les Modifiactions</button>
		</div>
	<?php
	}
	?>
</div>
<?php $content = ob_get_clean(); ?>

<?php ob_start(); 
if ($admin === true)
{
?>
	<script type="text/javascript">
		let cartesForOtherPages = <?= json_encode($cartesForOtherPages); ?>;
		let page = <?= json_encode($page); ?>;
	</script>
	<script type="text/javascript" src="assets/js/tools.js"></script>
	<script type="text/javascript" src="assets/js/admin_cartes.js"></script>
<?php
}
?>
<script type="text/javascript">
    let carousel = 
    {
    	id: "carousel",
		path : "assets/img/",
		fileName : ["brunch_oeufsbacon.jpg", "brunch_saumon.jpg"],
		imgAlt : ["photo d'une assiette avec divers aliments dont des oeufs et du bacon", "photo d'une assiette avec divers aliments dont du saumon et du fromage frais"]
	}
	let carouselList = [carousel];
</script>
<script type="text/javascript" src="assets/js/cvm_alertcookies.js"></script>
<script type="text/javascript" src="assets/js/cvm_optimg.js"></script>
<script type="text/javascript" src="assets/js/cvm_carousel.js"></script>
<?php $javascript = ob_get_clean(); ?>

<?php require('template.php'); ?>