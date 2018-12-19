<?php 
$headDescription = 'Découvrez les événements à venir.';
$headTitle = 'Restaurant & Café-Bar Citizen Kane - Agenda';

ob_start(); ?>
<div id="main" class="main">
	<section class="beerproject-intro">
		<img class="bg-image" src="assets/img/agenda_home_small.jpg" alt="photo de la terrasse du Citizen Kane">
   		<div>
			<h1>Agenda</h1>
		</div>
	</section>
	<section class="beerproject-editions">
		<h2>Événements</h2>
		<?php
		$currentDate = date('Y-m-d');
		$beerProjectPastList = [];
		$beerProjectSoonList = [];

		foreach ($beerProjectList as $key => $beerProject)
		{
			if($beerProjectList[$key]["date_close"] < $currentDate)
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
					<img src="assets/img/upload/carte_empty.png" alt="logo de l'événement">
					<div class="aboveline">
						<input class="h4 brasserieTitle" type="text" placeholder="Titre de l'édition" autocomplete="off">
						<p><b>date d'ouverture</b> (yyyy-mm-jj hh:mm:ss) : <input class="brasserieDate_open" type="datetime-local" autocomplete="off"></p>
						<p><b>date de fin</b> (yyyy-mm-jj hh:mm:ss) : <input class="brasserieDate_close" type="datetime-local" autocomplete="off"></p>
						<p><b>En Résumé</b> : <textarea class="summary" autocomplete="off"></textarea></p>
					</div>
					<button class="btn btn_addNewBrasserie">valider</button>
				</div>	
			</div>
			<div id="waitingRecord" class="displayNone">
				<h3>En Attente d'Enregistrement</h3>
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
							<img src="assets/img/upload/<?= htmlspecialchars($beerProjectSoon["imgSrc"]) ?>" alt="logo de l'événement">
						<?php
						}
						else
						{
						?>
							<img src="assets/img/upload/carte_empty.png" alt="logo de la brasserie">
						<?php
						}
						?>
						<div class="aboveline">
							<input class="h4 brasserieTitle" type="text" value="<?= htmlspecialchars($beerProjectSoon["title"]) ?>" autocomplete="off">
							<p><b>date d'ouverture</b> (yyyy-mm-jj hh:mm:ss) : <input class="brasserieDate_open" type="datetime-local" value="<?= htmlspecialchars($beerProjectSoon["date_open"]) ?>" autocomplete="off"></p>
							<p><b>date de fin</b> (yyyy-mm-jj hh:mm:ss) : <input class="brasserieDate_close" type="datetime-local" value="<?= htmlspecialchars($beerProjectSoon["date_close"]) ?>" autocomplete="off"></p>
							<p><b>En Résumé</b> : <textarea class="summary" autocomplete="off"><?= htmlspecialchars($beerProjectSoon["summary"]) ?></textarea> </p>
						</div>
					</div>		
				<?php
				}
				?>
			</div>
			<div>
				<h3>Passés</h3>
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
							<img src="assets/img/upload/<?= htmlspecialchars($beerProjectPast["imgSrc"]) ?>" alt="logo de l'événement">
						<?php
						}
						else
						{
						?>
							<img src="assets/img/upload/carte_empty.png" alt="logo de la brasserie">
						<?php
						}
						?>
						<div class="aboveline">
							<input class="h4 brasserieTitle" type="text" value="<?= htmlspecialchars($beerProjectPast["title"]) ?>" autocomplete="off">
							<p><b>date d'ouverture</b> (yyyy-mm-jj hh:mm:ss) : <input class="brasserieDate_open" type="datetime-local" value="<?= htmlspecialchars($beerProjectPast["date_open"]) ?>" autocomplete="off"></p>
							<p><b>date de fin</b> (yyyy-mm-jj hh:mm:ss) : <input class="brasserieDate_close" type="datetime-local" value="<?= htmlspecialchars($beerProjectPast["date_close"]) ?>" autocomplete="off"></p>
							<p><b>En Résumé</b> : <textarea class="summary" autocomplete="off"><?= htmlspecialchars($beerProjectPast["summary"]) ?></textarea></p>
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
					$dateNewFormat = DateManage::translateDateTime($beerProjectSoon["date_open"], $beerProjectSoon["date_close"]);
				?>
					<div class="beerproject-brasserie brasseriesFromDb">
						<?php
						if (isset($beerProjectSoon["imgSrc"]) && !empty($beerProjectSoon["imgSrc"]))
						{
						?>
							<img src="assets/img/upload/<?= htmlspecialchars($beerProjectSoon["imgSrc"]) ?>" alt="logo de l'événement">
						<?php
						}
						else
						{
						?>
							<img src="assets/img/upload/carte_empty.png" alt="logo de la brasserie">
						<?php
						}
						?>
						<div class="aboveline">
							<h4 class="brasserieTitle"><?= htmlspecialchars($beerProjectSoon["title"]) ?></h4>
							<p><b>Date</b> : <?= $dateNewFormat ?></p>
							<p><b>En Résumé</b> : <?= htmlspecialchars($beerProjectSoon["summary"]) ?></p>
						</div>
					</div>		
				<?php
				}
				?>
			</div>
			<div>
				<h3>Passés</h3>
				<?php
				foreach ($beerProjectPastList as $key => $beerProjectPast)
				{
					$dateNewFormat = DateManage::translateDateTime($beerProjectPast["date_open"], $beerProjectPast["date_close"]);
				?>
					<div id="beerProjectId__<?= htmlspecialchars($beerProjectPast["id"]) ?>" class="beerproject-brasserie brasseriesFromDb">
						<?php
						if (isset($beerProjectPast["imgSrc"]) && !empty($beerProjectPast["imgSrc"]))
						{
						?>
							<img src="assets/img/upload/<?= htmlspecialchars($beerProjectPast["imgSrc"]) ?>" alt="logo de l'événement">
						<?php
						}
						else
						{
						?>
							<img src="assets/img/upload/carte_empty.png" alt="logo de la brasserie">
						<?php
						}
						?>
						<div class="aboveline">
							<h4 class="brasserieTitle"><?= htmlspecialchars($beerProjectPast["title"]) ?></h4>
							<p><b>Date</b> : <?= $dateNewFormat ?></p>
							<p><b>En Résumé</b> : <?= htmlspecialchars($beerProjectPast["summary"]) ?></p>
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
<script type="text/javascript" src="assets/js/cvm_alertcookies.js"></script>
<script type="text/javascript" src="assets/js/cvm_optimg.js"></script>
<?php $javascript = ob_get_clean(); ?>

<?php require('template.php'); ?>