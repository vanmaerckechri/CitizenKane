<?php $headDescription = 'Restaurant à Wavre. Voici ce que vous pouvez trouver au menu'; ?>
<?php $headTitle = 'Restaurant & Café-Bar Citizen Kane - Le Restaurant'; ?>

<?php ob_start(); ?>
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
		<?php
		foreach ($cartes as $keyFam => $family)
		{
		?>
		<div>
			<h3><?= htmlspecialchars($keyFam) ?></h3>
		<?php
		foreach ($family as $keyCarte => $carte)
		{
			$description = $carte["description"];
		?>		
			<div class="readMore-container">
				<input class="openCarteButton" type="checkbox" aria-label="<?= htmlspecialchars($description["buttonDescription"]) ?>">
				<img src="assets/img/<?= $description["imgSrc"] ?>" alt="<?= htmlspecialchars($description["imgAlt"]) ?>">
				<span></span>
				<div class="readMore-content">
				<?php
				if ($admin === true)
				{
				?>
					<button id="deleteCarte" class="btn">effacer la carte "<?= htmlspecialchars($description["title"]) ?>"</button>
					<input class="h4" type="text" value="<?= htmlspecialchars($description["title"]) ?>">
				<?php
				}
				else
				{
				?>
					<h4><?= htmlspecialchars($description["title"]) ?></h4>
				<?php
				}
				?>
					<ul id="carte__<?= htmlspecialchars($keyCarte) ?>">
					<?php
					foreach ($carte["plats"] as $keyPlat => $plat)
					{
						if ($admin === true)
						{
						?>
							<li id="plats__<?= htmlspecialchars($keyPlat) ?>">
								<button class="moveOrderButton">MOVE</button>
								<input class="plat" type="text" placeholder="Titre du Plat" value="<?= htmlspecialchars($plat['name']) ?>" autocomplete="off">
								<input class="prix" type="number" min="0" step="0.1" placeholder="Prix du Plat" value="<?= htmlspecialchars($plat['price']) ?>" autocomplete="off">
								<input class="platCompo" type="text" placeholder="Composition du Plat" value="<?= htmlspecialchars($plat['compo']) ?>" autocomplete="off">
							</li>
						<?php			
						}
						else
						{
						?>
							<li>
								<span class="plat"><?= $plat['name'] ?></span>
								<span class="dots"></span>
								<span class="prix"><?= $plat['price'] ?></span>
								<span class="platCompo"><?= $plat['compo'] ?></span>
							</li>
						<?php
						}
					}
					if ($admin === true)
					{
					?>
						<li><button id="addPlat" class="btn">ajouter un plat à "<?= htmlspecialchars($description["title"]) ?>"</button></li>
					<?php
					}
					?>
					</ul>
				</div>
			</div>
		<?php
		}
		?>
		</div>
		<button id="addCarte" class="btn">ajouter une carte à "<?= htmlspecialchars($keyFam) ?>"</button>
		<?php
		}
		?>
		<button id="addFamCarte" class="btn">ajouter une famille de cartes</button>
		<div>
			<h3>La Carte Boissons</h3>
			<a href="assets/pdf/boissons.pdf" target="_blank" rel="noopener"><img src="assets/img/cartecafe_boissons_small.jpg" alt="photo d'un cocktail"></a>
		</div>
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
			<button id="recordChanges" class="btn" style="position: fixed; left: 0; bottom:0; z-index: 10">Enregistrer les Modifiactions</button>
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
	let pageOldInfos = <?php echo json_encode($cartes); ?>;
	let pageInfos = <?php echo json_encode($cartes); ?>;
	let page = <?php echo json_encode($page); ?>;
	</script>
	<script type="text/javascript" src="assets/js/cvm_createdomelem.js"></script>
	<script type="text/javascript" src="assets/js/admin.js"></script>
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