<?php 
$headDescription = 'Café-Bar à Wavre. Voici la carte de toutes nos boissons dont une grande variété de bières.';
$headTitle = 'Restaurant & Café-Bar Citizen Kane - Le Café-Bar';

ob_start();
?>
<div id="main" class="main">
	<section class="restaurant-intro cafe-intro">
		<div id="carousel" class="carousel-container">
   			<img src="assets/img/cafe_illu_small.jpg" alt="photo de la peinture murale pop culture se trouvant sur le mur interieur du café">
   			<button class="displayNone"><<</button>
   			<button class="displayNone">>></button>
	   		<div class="carousel-nav">
	   		</div>
   		</div>
   		<div>
			<h1>Le Café-Bar, c'Est Quoi ?</h1>
			<p>Le Café-Bar est le lieu original de création du Citizen Kane. Un endroit authentique où règnent convivialité, bonne humeur et décontraction. L’occasion de siroter un bon thé glacé maison, l’une des 50 bières à la carte, de profiter d’un bon apéro entre amis ou en famille.</p>
			<p>Véritable institution, le Citizen Kane se veut un bar de Wavre unique et original qui ne vous laissera pas indifférent.</p>
			<h2>Nos Heures d'Ouverture</h2>
			<p>Le Café est ouvert 7/7 jours y compris les jours fériés (à l’exception du 25 décembre).
				<ul>
					<li>Du lundi au jeudi de 8h à 1h</li>
					<li>Vendredi et samedi de 8h à 2h</li>
					<li>Dimanche de 10h à 23h</li>
				</ul>
			</p>
		</div>
	</section>
	<section id="carteBoissons" class="restaurant-cartes cafe-cartes">
		<h2>Nos Cartes</h2>

		<?= $carteView ?>

		<div id="chouffes" class="cafe-chouffes">
			<h3>Découvrez nos ROUTES DE CHOUFFE, Uniques au Monde !</h3>
			<div>
				<p>Le Citizen Kane propose de (re)découvrir la Brasserie d’Achouffe avec ses <b>ROUTES DE CHOUFFE</b> !</p>
				<p>Les routes de Chouffe sont disponibles en deux formats : 4×12,5 cl (8€) ou 4×25 cl (14€).</p>
				<p>Seul ou entre amis, pour l’apéro ou en dégustation, les routes de Chouffe sont composées de la traditionnelle <b>Chouffe</b>, de la <b>Mc Chouffe</b>, de la <b>Houblon Chouffe</b> et de la <b>Chouffe Soleil</b>.</p>
			</div>
			<img src="assets/img/cafe_chouffe_small.jpg" alt="photo de plusieurs verres de bière Chouffe">
		</div>
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
		path: "assets/img/",
		fileName: ["cafe_illu.jpg", "cafe_terrasse.jpg", "cafe_interieur01.jpg" , "cartecafe_boissons.jpg", "cafe_interieur02.jpg"],
		imgAlt: ["photo de la peinture murale pop culture se trouvant sur le mur interieur du café", "photo de la terrasse", "photo des tables à l'intérieur du café", "photo d'un cocktail", "photo de l'intérieur du café"]
	}
	let carouselList = [carousel];
</script>
<script type="text/javascript" src="assets/js/cvm_alertcookies.js"></script>
<script type="text/javascript" src="assets/js/cvm_optimg.js"></script>
<script type="text/javascript" src="assets/js/cvm_carousel.js"></script>
<?php $javascript = ob_get_clean(); ?>

<?php require('template.php'); ?>