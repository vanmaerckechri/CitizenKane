<?php 
$headDescription = 'Restaurant à Wavre. Voici ce que vous pouvez trouver au menu';
$headTitle = 'Restaurant & Café-Bar Citizen Kane - Le Restaurant';

ob_start(); ?>
<div id="main" class="main">
	<section class="restaurant-intro">
		<div id="carousel" class="carousel-container">
   			<img src="assets/img/restaurant_facade_small.jpg" alt="photo de la facade">
   			<button class="displayNone"><<</button>
   			<button class="displayNone">>></button>
	   		<div class="carousel-nav">
	   		</div>
   		</div>
   		<div>
			<h1>Le Restaurant, c'Est Quoi ?</h1>
			<p>Le restaurant du Citizen Kane est une salle annexe au Café. Son cadre convivial et posé est idéal pour les repas en amoureux et les dîners d’affaires. Au menu : plats belges, salades, hamburgers maison, formules lunch et de nombreuses suggestions qui varient chaque semaine.</p>
			<h2>Nos Heures d'Ouverture</h2>
			<p>Tous les jours de 11h à 22h.</p>
		</div>
	</section>
	<section id="carteResto" class="restaurant-cartes">
		<h2>Nos Cartes</h2>

		<?= $carteView ?>

		<div>
			<h3>Allergènes</h3>
			<p>Nous vous informons que certains plats de notre restaurant peuvent contenir des allergènes. Si vous présentez un risque d’allergie, merci d’interpeller un de nos serveurs pour plus d’informations.</p>
		</div>
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
			<button id="recordChanges" class="btn displayNone btn_recordChanges">Enregistrer les Modifiactions</button>
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
		path: "assets/img/",
		fileName: ["restaurant_facade.jpg", "restaurant_interieur01.jpg", "restaurant_plat01.jpg", "terrasse.jpg" , "restaurant_interieur02.jpg", "restaurant_plat02.jpg", "restaurant_deco.jpg"],
		imgAlt: ["photo de la facade", "photo de l'intérieur", "photo de roulades de légumes", "photo de la terrasse", "photo de l'intérieur", "photo d'un plat à base de viande", "photo de la décoration d'intérieur"]
	}
	let carouselList = [carousel];
</script>
<script type="text/javascript" src="assets/js/cvm_alertcookies.js"></script>
<script type="text/javascript" src="assets/js/cvm_optimg.js"></script>
<script type="text/javascript" src="assets/js/cvm_carousel.js"></script>
<?php $javascript = ob_get_clean(); ?>

<?php require('template.php'); ?>