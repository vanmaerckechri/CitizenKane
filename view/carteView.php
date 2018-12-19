<?php ob_start();

foreach ($cartes as $keyFam => $family)
{
	if ($admin === true)
	{
		$idsFam = implode("_", $family["idsFam"]);
	?>
		<div id="familyContainer__<?= htmlspecialchars($idsFam) ?>" class="familyContainer">
			<input id="familyId__<?= htmlspecialchars($idsFam) ?>" class="familyTitle h3" type="text" value="<?= htmlspecialchars($keyFam) ?>" placeholder="Famille de Cartes Sans Titre" autocomplete="off">
	<?php
	}
	else
	{
	?>
		<div>
			<h3><?= htmlspecialchars($keyFam) ?></h3>
	<?php
	}
	foreach ($family as $keyCarte => $carte)
	{
		if ($keyCarte != "idsFam")
		{
			$description = $carte["description"];
			?>
			<div class="readMore-container">
				<?php
				if ($description["style"] == "fold")
				{
				?>
					<input class="openCarteButton" type="checkbox" aria-label="afficher la carte des <?= htmlspecialchars($description["title"]) ?>">
					<?php
					if (!empty($description["imgSrc"]))
					{
					?>
						<img src="assets/img/upload/<?= htmlspecialchars($description["imgSrc"]) ?>" alt="photo représentant la carte des <?= htmlspecialchars($description["title"]) ?>">
					<?php
					}
					else
					{
					?>
						<img src="assets/img/upload/carte_empty.png" alt="photo représentant la carte des <?= htmlspecialchars($description["title"]) ?>">
					<?php
					}
				}
				elseif ($description["style"] == "link")
				{
					if (!empty($description["imgSrc"]))
					{
					?>
						<a href="./assets/pdf/<?= htmlspecialchars($description["link"]) ?>" target="_blank" rel="noopener"><img src="assets/img/upload/<?= htmlspecialchars($description["imgSrc"]) ?>" alt="photo représentant la carte des <?= htmlspecialchars($description["title"]) ?>"></a>
					<?php
					}
					else
					{
					?>
						<a href="./assets/pdf/<?= htmlspecialchars($description["link"]) ?>" target="_blank" rel="noopener"><img src="assets/img/upload/carte_empty.png" alt="photo représentant la carte des <?= htmlspecialchars($description["title"]) ?>"></a>
					<?php
					}
				}
				if ($admin === true)
				{
				?>
					<input id="carteImg__<?= htmlspecialchars($keyCarte) ?>" class="carteImg" name="carteImg__<?= $keyCarte ?>" type="file" accept="image/png, image/jpeg">
					<button id="deleteCarte__<?= htmlspecialchars($keyCarte) ?>" class="btn_carteDelete">X</button>
				<?php
				}
				if ($description["style"] == "fold")
				{
					?>
					<div class="readMore-content">
						<?php
						if ($admin === true)
						{
						?>
							<input id="carteTitle__<?= htmlspecialchars($keyCarte) ?>" class="carteTitle h4" type="text" value="<?= htmlspecialchars($description["title"]) ?>" placeholder="Carte Sans Titre" autocomplete="off">
						<?php
						}
						else
						{
							if (isset($description["title"]) && !empty($description["title"]))
							{
							?>
								<h4><?= htmlspecialchars($description["title"]) ?></h4>
							<?php
							}
						}
						?>
						<ul id="carte__<?= htmlspecialchars($keyCarte) ?>">
						<?php
						if (isset($carte["plats"]) && !empty($carte["plats"]))
						{
							foreach ($carte["plats"] as $keyPlat => $plat)
							{
								if ($admin === true)
								{
								?>
									<li id="plats__<?= htmlspecialchars($keyPlat) ?>">
										<button class="moveOrderButton">MOVE</button>
										<input class="plat" type="text" placeholder="Titre du Plat" value="<?= htmlspecialchars($plat['name']) ?>" autocomplete="off">
										<input class="prix" type="number" min="0" step="0.1" placeholder="Prix du Plat" value="<?= htmlspecialchars($plat['price']) ?>" autocomplete="off">
										<button class="btn_platDelete">X</button>
										<input class="platCompo" type="text" placeholder="Composition du Plat" value="<?= htmlspecialchars($plat['compo']) ?>" autocomplete="off">
									</li>
								<?php			
								}
								else
								{
								?>
									<li>
										<span class="plat"><?= htmlspecialchars($plat['name']) ?></span>
										<span class="dots"></span>
										<span class="prix"><?= number_format(htmlspecialchars($plat['price']), 2, ',', ' ') ?></span>
										<span class="platCompo"><?= htmlspecialchars($plat['compo']) ?></span>
									</li>
								<?php
								}
							}
						}
						if ($admin === true)
						{
						?>
							<li><button id="addPlat__<?= htmlspecialchars($keyCarte) ?>" class="addPlat btn btn_add">ajouter un plat</button></li>
						<?php
						}
						?>
						</ul>
					</div>
				<?php
				}
				elseif ($description["style"] == "link")
				{
				?>
					<div class="readMore-content cartePdf-content">
						<div class="uploadPdf-container">
							<p>PDF: </p>
							<input id="cartePdf__<?= htmlspecialchars($keyCarte) ?>" class="uploadPdf" name="cartePdf__<?= $keyCarte ?>" type="file" accept="application/pdf">
						</div>
						<?php
						if ($admin === true)
						{
						?>
							<input id="carteTitle__<?= htmlspecialchars($keyCarte) ?>" class="carteTitle h4" type="text" value="<?= htmlspecialchars($description["title"]) ?>" placeholder="Carte Sans Titre" autocomplete="off">
						<?php
						}
						?>
					</div>
				<?php
				}
				?>
			</div>
		<?php
		}
	}
	if ($admin === true)
	{
	?>
		<div class="addCarte_btnContainer">
			<button id="addCarte__<?= htmlspecialchars($idsFam) ?>" class="btn addCarte">ajouter une carte</button>
			<div class="radio radioFolder_container radio_selected">
				<span>
					<span class="radioFolder">
					</span>
				</span>
				<p>carte dépliable</p>
			</div>
			<div class="radio radioLink_container">
				<span>
					<span class="radioLink">
					</span>
				</span>
				<p>carte vers un lien pdf</p>
			</div>
		</div>
		<div class="importCarte_btnContainer">
			<button class="btn btn_import">Importer une Carte Provenant d'une Autre Page</button>
			<select class="carteForOtherPage">
				<?php
					$unknowFamIndex = 0;
					foreach ($cartesForOtherPages as $famTitle => $fam) 
					{
						$unknowCarteIndex = 0;
						$currentFamTitle = $famTitle;
						if (empty($currentFamTitle))
						{
							$unknowFamIndex += 1;
							$currentFamTitle = "Famille de Cartes Sans Titre " . $unknowFamIndex;
						}
						foreach ($fam as $key => $cartes) 
						{
							$indexCurrentCarteTitle = 1;
							if ($key != "idsFam")
							{
								$currentCarteTitle = $cartes["description"]["title"];

								if (empty($currentCarteTitle))
								{
									$unknowCarteIndex += 1;
									$currentCarteTitle = 'Carte Sans Titre ' . $unknowCarteIndex . ' de la famille: "' . $currentFamTitle . '"';
								?>
									<option value="importId__<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($currentCarteTitle) ?></option>
  								<?php
								}
								else
								{
								?>
  									<option value="importId__<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($cartes["description"]["title"]) ?></option>
  								<?php
								}
							}
						}
					}
				?>
			</select>
		</div>
	<?php
	}
	?>
	</div>
<?php
}
if ($admin === true)
{
?>
	<button id="addFamCarte" class="btn btn_addFam">créer une nouvelle famille de cartes</button>
	<div class="importCarte_btnContainer displayNone">
		<button class="btn btn_import">Importer une Carte Provenant d'une Autre Page</button>
		<select class="carteForOtherPage">
			<?php
				$unknowFamIndex = 0;
				foreach ($cartesForOtherPages as $famTitle => $fam) 
				{
					$unknowCarteIndex = 0;
					$currentFamTitle = $famTitle;
					if (empty($currentFamTitle))
					{
						$unknowFamIndex += 1;
						$currentFamTitle = "Famille de Cartes Sans Titre " . $unknowFamIndex;
					}
					foreach ($fam as $key => $cartes) 
					{
						$indexCurrentCarteTitle = 1;
						if ($key != "idsFam")
						{
							$currentCarteTitle = $cartes["description"]["title"];

							if (empty($currentCarteTitle))
							{
								$unknowCarteIndex += 1;
								$currentCarteTitle = 'Carte Sans Titre ' . $unknowCarteIndex . ' de la famille: "' . $currentFamTitle . '"';
							?>
								<option value="importId__<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($currentCarteTitle) ?></option>
								<?php
							}
							else
							{
							?>
									<option value="importId__<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($cartes["description"]["title"]) ?></option>
								<?php
							}
						}
					}
				}
			?>
		</select>
	</div>
<?php
}

$carteView = ob_get_clean(); ?>
