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
	$page = "restaurant";
	if (isset($_POST))
    {
        require('./controller/cartesController.php');
    }
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
	$page = "cafe";
	if (isset($_POST))
    {
        require('./controller/cartesController.php');
    }
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
	$page = "beerProject";

    require('./controller/beerProjectController.php');

	$beerProject = new BeerProject();
	$beerProjectList = $beerProject->getList($page);

	cleanPost($page);

	$beerProjectPage = 'class="active"';
    require('./view/beerProjectView.php');	
}

function loadAgenda($admin)
{
	$page = "agenda";

    require('./controller/beerProjectController.php');

	$beerProject = new BeerProject();
	$beerProjectList = $beerProject->getList($page);

	cleanPost($page);

	$agendaPage = 'class="active"';
    require('./view/agendaView.php');	
}