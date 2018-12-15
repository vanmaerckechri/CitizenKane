<?php

require('./model/beerproject.php');

if (isset($_POST["inputUpdate"]) && !empty($_POST["inputUpdate"]))
{
	$updateList = json_decode($_POST["inputUpdate"], true);
	$beerProject = new BeerProject();
	$beerProject->update($updateList, $page);
}

if (isset($_POST["brasserieToDelete"]) && !empty($_POST["brasserieToDelete"]))
{
	$deleteList = json_decode($_POST["brasserieToDelete"], true);
	$beerProject = new BeerProject();
	$beerProject->delete($deleteList, $page);
}

if (isset($_FILES) && !empty($_FILES) && isset($_POST["brasserieImgInputId"]) && !empty($_POST["brasserieImgInputId"]))
{
	$brasserieImgInputId = json_decode($_POST["brasserieImgInputId"], true);
	$beerProject = new BeerProject();
	$imgSrcAndId = $beerProject->uploadImg("onAlreadyExistBrasserie", $brasserieImgInputId, $page);
	$imgSrcList = $imgSrcAndId[0];
	$imgIdList = $imgSrcAndId[1];
	$beerProject->updateImg($imgSrcList, $imgIdList, $page);
}

if (isset($_POST["insertNewBrasserie"]) && !empty($_POST["insertNewBrasserie"]))
{
	$newBrasserieList = json_decode($_POST["insertNewBrasserie"], true);
	$beerProject = new BeerProject();
	$idList = $beerProject->insert($newBrasserieList, $page);
	// img
	if (isset($_FILES) && !empty($_FILES))
	{
		$imgSrcAndId = $beerProject->uploadImg("onNewBrasserie", $idList, $page);
		$imgSrcList = $imgSrcAndId[0];
		$imgIdList = $imgSrcAndId[1];
		$beerProject->updateImg($imgSrcList, $imgIdList, $page);
	}
}