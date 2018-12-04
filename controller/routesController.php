<?php

require('./model/connexion.php');
require('./model/cartes.php');

function crud()
{
	if (isset($_POST["updatePlats"]) && !empty($_POST["updatePlats"]))
	{
		$updatePlats = json_decode($_POST["updatePlats"], true);
		$cartes = new Cartes();
		$cartes->updatePlats($updatePlats);
	}
	if (isset($_FILES) && !empty($_FILES) && isset($_POST["updateCarteImageCartesId"]) && !empty($_POST["updateCarteImageCartesId"]))
	{
		$cartesId = json_decode($_POST["updateCarteImageCartesId"], true);
		$cartes = new Cartes();
		$oldImgDir = "oldCartes/";
		$oldFileNameList = $cartes->getImgSrc($cartesId);
		$fileNameList = $cartes->uploadImg($oldImgDir, $oldFileNameList);
		$cartes->updateImg($cartesId, $fileNameList);
		exit;
	}
	if (isset($_POST["updatePlatsOrder"]) && !empty($_POST["updatePlatsOrder"]))
	{
		$updatePlatsOrder = json_decode($_POST["updatePlatsOrder"], true);
		$cartes = new Cartes();
		$cartes->updatePlatsOrder($updatePlatsOrder);
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
	$restoPage = 'class="active"';

    require('./view/restaurantView.php');
}