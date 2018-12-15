<?php

require('./model/cartes.php');

$newCartesId;

if (isset($_POST["inputUpdate"]) && !empty($_POST["inputUpdate"]))
{
	$updateList = json_decode($_POST["inputUpdate"], true);
	$beerProject = new BeerProject();
	$beerProject->update($updateList);
}

if (isset($_POST["brasserieToDelete"]) && !empty($_POST["brasserieToDelete"]))
{
	$deleteList = json_decode($_POST["brasserieToDelete"], true);
	$beerProject = new BeerProject();
	$beerProject->delete($deleteList);
}

if (isset($_POST["insertNewBrasserie"]) && !empty($_POST["insertNewBrasserie"]))
{
	$newBrasserieList = json_decode($_POST["insertNewBrasserie"], true);
	$beerProject = new BeerProject();
	$beerProject->insert($newBrasserieList);
}