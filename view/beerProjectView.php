<?php 
$headDescription = 'Découvrez des bières belges avec le Beer Discovery Project.';
$headTitle = 'Restaurant & Café-Bar Citizen Kane - Beer Discovery Project';

ob_start(); ?>
<div id="main" class="main">
	<section class="beerproject-intro">
		<img class="bg-image" src="assets/img/beerproject_home_small.jpg" alt="photo de la terrasse du Citizen Kane">
   		<div>
			<h1>Beer Discovery Project</h1>
			<p>Depuis décembre 2017, le Citizen Kane vous propose le Beer Discovery Project.</p>
			<p>L’objectif ? Découvrir chaque mois des bières locales et/ou de (micro-)brasseries belges. Pendant un mois, nous mettons à l’honneur une brasserie en proposant certaines de ses bières en suggestion. Mieux encore, lors de ce mois dédié, nous proposons une soirée découverte où le brasseur vient à la rencontre des clients !</p>
			<p>Découvrez aussi notre <a href="cafe.html#carteBoissons">carte complète de bières ici.</a></p>
		</div>
	</section>
	<section class="beerproject-editions">
		<h2>Éditions</h2>
		<?php
		$currentDate = date('Y-m-d');
		$beerProjectPastList = [];
		$beerProjectSoonList = [];

		foreach ($beerProjectList as $key => $beerProject)
		{
			if($beerProjectList[$key]["date"] < $currentDate)
			{
				array_push($beerProjectPastList, $beerProjectList[$key]);
			}
			else
			{
				array_push($beerProjectSoonList, $beerProjectList[$key]);
			}
		}
		// -- ADMIN --
		if ($admin === true)
		{
		?>	
			<div class="newBrasserie-container">
				<h3>Ajouter un Événement</h3>
				<div class="beerproject-brasserie newBrasserie">
					<input class="brasserieImgInput" type="file" accept="image/png, image/jpeg">
					<img src="assets/img/test/carte_empty.png" alt="logo de la brasserie">
					<div class="aboveline">
						<input class="h4 brasserieTitle" type="text" placeholder="Titre de l'édition" autocomplete="off">
						<p><b>Soirée découverte</b> : <input class="brasserieDate" type="date" autocomplete="off"></p>
						<p><b>Bières à découvrir</b> : <input class="brasserieBeers" type="text" placeholder="Les bières..." autocomplete="off"> </p>
						<p><b>Site</b> : <input class="brasserieUrl" type="text" placeholder="url..." autocomplete="off"></p>
					</div>
					<button class="btn btn_addNewBrasserie">valider</button>
				</div>	
			</div>
			<div>
				<h3>à Venir</h3>
			<?php
			foreach ($beerProjectSoonList as $key => $beerProjectSoon)
			{
			?>
				<div id="beerProjectId__<?= htmlspecialchars($beerProjectSoon["id"]) ?>" class="beerproject-brasserie brasseriesFromDb">
					<button class="btn_carteDelete">X</button>
					<input class="brasserieImgInput" type="file" accept="image/png, image/jpeg">
					<?php
					if (isset($beerProjectSoon["imgSrc"]) && !empty($beerProjectSoon["imgSrc"]))
					{
					?>
						<img src="assets/img/test2/<?= htmlspecialchars($beerProjectSoon["imgSrc"]) ?>" alt="logo de la brasserie">
					<?php
					}
					else
					{
					?>
						<img src="assets/img/test/carte_empty.png" alt="logo de la brasserie">
					<?php
					}
					?>
					<div class="aboveline">
						<input class="h4 brasserieTitle" type="text" value="<?= htmlspecialchars($beerProjectSoon["title"]) ?>" autocomplete="off">
						<p><b>Soirée découverte</b> : <input class="brasserieDate" type="date" value="<?= htmlspecialchars($beerProjectSoon["date"]) ?>" autocomplete="off"></p>
						<p><b>Bières à découvrir</b> : <input class="brasserieBeers" type="text" value="<?= htmlspecialchars($beerProjectSoon["beers"]) ?>" autocomplete="off"> </p>
						<?php
						if (!empty($beerProjectSoon["link"]))
						{
						?>
							<p><b>Site</b> : <input class="brasserieUrl" type="text" value="<?= htmlspecialchars($beerProjectSoon['link']) ?>" autocomplete="off"></p>
						<?php
						}
						?>
					</div>
				</div>		
			<?php
			}
			?>
			</div>
			<div>
				<h3>Passées</h3>
			<?php
			foreach ($beerProjectPastList as $key => $beerProjectPast)
			{
			?>
				<div id="beerProjectId__<?= htmlspecialchars($beerProjectPast["id"]) ?>" class="beerproject-brasserie brasseriesFromDb">
					<button class="btn_carteDelete">X</button>
					<input class="brasserieImgInput" type="file" accept="image/png, image/jpeg">
					<?php
					if (isset($beerProjectPast["imgSrc"]) && !empty($beerProjectPast["imgSrc"]))
					{
					?>
						<img src="assets/img/test2/<?= htmlspecialchars($beerProjectPast["imgSrc"]) ?>" alt="logo de la brasserie">
					<?php
					}
					else
					{
					?>
						<img src="assets/img/test/carte_empty.png" alt="logo de la brasserie">
					<?php
					}
					?>					
					<div class="aboveline">
						<input class="h4 brasserieTitle" type="text" value="<?= htmlspecialchars($beerProjectPast["title"]) ?>" autocomplete="off">
						<p><b>Soirée découverte</b> : <input class="brasserieDate" type="date" value="<?= htmlspecialchars($beerProjectPast["date"]) ?>" autocomplete="off"></p>
						<p><b>Bières à découvrir</b> : <input class="brasserieBeers" type="text" value="<?= htmlspecialchars($beerProjectPast["beers"]) ?>" autocomplete="off"> </p>
						<?php
						if (!empty($beerProjectPast["link"]))
						{
						?>
							<p><b>Site</b> : <input class="brasserieUrl" type="text" value="<?= htmlspecialchars($beerProjectPast['link']) ?>" autocomplete="off"></p>
						<?php
						}
						?>
					</div>
				</div>		
			<?php
			}
			?>
			</div>
		<?php
		// -- CLIENTS --	
		}
		else
		{
		?>	
			<div>
				<h3>à Venir</h3>
			<?php
			foreach ($beerProjectSoonList as $key => $beerProjectSoon)
			{
			?>
				<div class="beerproject-brasserie">
					<img src="assets/img/<?= htmlspecialchars($beerProjectSoon["imgSrc"]) ?>" alt="logo de la brasserie de Jandrain-Jandrenouille">
					<div class="aboveline">
						<h4><?= htmlspecialchars($beerProjectSoon["title"]) ?></h4>
						<p><b>Soirée découverte</b> : <?= htmlspecialchars($beerProjectSoon["date"]) ?></p>
						<p><b>Bières à découvrir</b> : <?= htmlspecialchars($beerProjectSoon["beers"]) ?></p>
						<?php
						if (!empty($beerProjectSoon["link"]))
						{
						?>
							<p><b>Site</b> : <a href="<?= htmlspecialchars($beerProjectSoon['link']) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($beerProjectSoon['link']) ?></a></p>
						<?php
						}
						?>
					</div>
				</div>		
			<?php
			}
			?>
			</div>
			<div>
				<h3>Passées</h3>
			<?php
			foreach ($beerProjectPastList as $key => $beerProjectPast)
			{
			?>
				<div class="beerproject-brasserie">
					<img src="assets/img/<?= htmlspecialchars($beerProjectPast["imgSrc"]) ?>" alt="logo de la brasserie de Jandrain-Jandrenouille">
					<div class="aboveline">
						<h4><?= htmlspecialchars($beerProjectPast["title"]) ?></h4>
						<p><b>Soirée découverte</b> : <?= htmlspecialchars($beerProjectPast["date"]) ?></p>
						<p><b>Bières à découvrir</b> : <?= htmlspecialchars($beerProjectPast["beers"]) ?></p>
						<?php
						if (!empty($beerProjectPast["link"]))
						{
						?>
							<p><b>Site</b> : <a href="<?= htmlspecialchars($beerProjectPast['link']) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($beerProjectPast['link']) ?></a></p>
						<?php
						}
						?>
					</div>
				</div>		
			<?php
			}
			?>
			</div>
		<?php
		}
		?>
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
		let page = <?= json_encode($page); ?>;
	</script>
	<script type="text/javascript" src="assets/js/tools.js"></script>
	<script type="text/javascript" src="assets/js/admin_beerproject.js"></script>
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
<?php $javascript = ob_get_clean(); ?>

<?php require('template.php'); ?>