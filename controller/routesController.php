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