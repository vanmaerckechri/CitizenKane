<?php

require('./model/connexion.php');
require('./model/cartes.php');

function crud()
{
	$newCartesId;

	if (isset($_POST["newCartes"]) && !empty($_POST["newCartes"]))
	{
		$newCartes = json_decode($_POST["newCartes"], true);
		$cartes = new Cartes();
		$newCartesId = $cartes->insertCartes($newCartes);

		// img in new carte
		$newImages = $cartes->uploadImg("onNewCarte");
		$cartes->updateCartes($newCartesId, $newImages);

		// img in new carte
		$newPdf = $cartes->uploadPdf("pdfOnNewCarte");

		$cartes->updateCartes($newCartesId, $newPdf, "link");
	}

	if (isset($_POST["newPlats"]) && !empty($_POST["newPlats"]))
	{
		$newPlats = json_decode($_POST["newPlats"], true);
		$cartes = new Cartes();
		$cartes->insertPlats($newPlats);
	}

	if (isset($_FILES) && !empty($_FILES) && isset($_POST["updateCarteImageCartesId"]) && !empty($_POST["updateCarteImageCartesId"]))
	{
		$cartesId = json_decode($_POST["updateCarteImageCartesId"], true);
		$cartes = new Cartes();
		//$oldImgDir = "oldCartes/";
		//$oldFileNameList = $cartes->getImgSrc($cartesId);
		//$fileNameList = $cartes->uploadImg($oldImgDir, $oldFileNameList);
		$fileNameList = $cartes->uploadImg("onAlreadyExistCarte");
		$cartes->updateCartes($cartesId, $fileNameList);
	}

	if (isset($_FILES) && !empty($_FILES) && isset($_POST["updateCartePdfId"]) && !empty($_POST["updateCartePdfId"]))
	{
		$cartesId = json_decode($_POST["updateCartePdfId"], true);
		$cartes = new Cartes();

		$fileNameList = $cartes->uploadPdf("pdfOnAlreadyExistCarte");

		$cartes->updateCartes($cartesId, $fileNameList, "link");
	}

	if (isset($_POST["familyCarteTitle"]) && !empty($_POST["familyCarteTitle"]))
	{
		$familyCarteTitle = json_decode($_POST["familyCarteTitle"], true);
		$cartes = new Cartes();
		$cartes->updateFamilyCarteTitle($familyCarteTitle);
	}

	if (isset($_POST["updateCartesTitle"]) && !empty($_POST["updateCartesTitle"]))
	{
		$updateCartesTitle = json_decode($_POST["updateCartesTitle"], true);
		$cartes = new Cartes();
		$cartes->updateCartesTitle($updateCartesTitle);
	}

	if (isset($_POST["updatePlats"]) && !empty($_POST["updatePlats"]))
	{
		$updatePlats = json_decode($_POST["updatePlats"], true);
		$cartes = new Cartes();
		$cartes->updatePlats($updatePlats);
	}

	if (isset($_POST["updatePlatsOrder"]) && !empty($_POST["updatePlatsOrder"]))
	{
		$updatePlatsOrder = json_decode($_POST["updatePlatsOrder"], true);
		$cartes = new Cartes();
		$cartes->updatePlatsOrder($updatePlatsOrder);
	}

	if (isset($_POST["deletePlatsList"]) && !empty($_POST["deletePlatsList"]))
	{
		$deletePlatsList = json_decode($_POST["deletePlatsList"], true);
		$cartes = new Cartes();
		$cartes->deletePlats($deletePlatsList);
	}	

	if (isset($_POST["deleteCartesList"]) && !empty($_POST["deleteCartesList"]))
	{
		$deleteCartesList = json_decode($_POST["deleteCartesList"], true);
		$cartes = new Cartes();
		$cartes->deleteCartes($deleteCartesList);
	}

	if (isset($_POST["deleteFamList"]) && !empty($_POST["deleteFamList"]))
	{
		$deleteFamList = json_decode($_POST["deleteFamList"], true);
		$cartes = new Cartes();
		$cartes->deleteFam($deleteFamList);
	}	
}

function cleanPost($page)
{
	if ($_POST)
	{
		header("Location: ./index.php?action=" . $page);
	}
}

function loadHome()
{
	$homePage = 'class="active"';
    require('./view/homeView.php');
}
function loadRestaurant($admin)
{
	$page = "restaurant";
	$cartes = new Cartes();
	$cartes = $cartes->getCartes($page);
	cleanPost($page);

	$restoPage = 'class="active"';
    require('./view/restaurantView.php');
}