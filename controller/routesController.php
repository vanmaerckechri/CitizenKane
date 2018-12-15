<?php

require('./model/connexion.php');

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
	if (isset($_POST))
    {
        require('./controller/cartesController.php');
    }
	$page = "restaurant";
	$cartes = new Cartes();
	$allCartes = $cartes->getCartes($page);
	$cartes = $allCartes[0];
	$cartesForOtherPages = $allCartes[1];

	cleanPost($page);

	$restoPage = 'class="active"';
	require('./view/carteView.php');
    require('./view/restaurantView.php');
}

function loadCafe($admin)
{
	if (isset($_POST))
    {
        require('./controller/cartesController.php');
    }
	$page = "cafe";
	$cartes = new Cartes();
	$allCartes = $cartes->getCartes($page);
	$cartes = $allCartes[0];
	$cartesForOtherPages = $allCartes[1];

	cleanPost($page);

	$cafePage = 'class="active"';
	require('./view/carteView.php');
    require('./view/cafeView.php');
}

function loadBeerProject($admin)
{
	if (isset($_POST))
    {
        require('./controller/beerProjectController.php');
    }
	$page = "beerProject";
	$beerProject = new BeerProject();
	$beerProjectList = $beerProject->getList();

	cleanPost($page);

	$beerProjectPage = 'class="active"';
    require('./view/beerProjectView.php');	
}

function loadAgenda($admin)
{
	if (isset($_POST))
    {
        require('./controller/beerProjectController.php');
    }
	$page = "agenda";
	$beerProject = new BeerProject();
	$beerProjectList = $beerProject->getList();

	cleanPost($page);

	$agendaPage = 'class="active"';
    require('./view/agendaView.php');	
}