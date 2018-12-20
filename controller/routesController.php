<?php

require('./model/connexion.php');

function cleanPost($page)
{
	if ($_POST)
	{
		header("Location: ./index.php?action=" . $page);
	}
	else
	{
		$nick = $_SESSION["nickname"] ?? '';
		$pwd = $_SESSION["password"] ?? '';

		$_SESSION = array();

		$_SESSION["nickname"] = $nick;
		$_SESSION["password"] = $pwd;
	}
}

function loadHome($admin)
{
	$page = "home";

	cleanPost($page);

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

    cleanPost($page);

	$cartes = new Cartes();
	$allCartes = $cartes->getCartes($page);
	$cartes = $allCartes[0];
	$cartesForOtherPages = $allCartes[1];

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

    cleanPost($page);

	$cartes = new Cartes();
	$allCartes = $cartes->getCartes($page);
	$cartes = $allCartes[0];
	$cartesForOtherPages = $allCartes[1];

	$cafePage = 'class="active"';
	require('./view/carteView.php');
    require('./view/cafeView.php');
}

function loadBrunch($admin)
{
	$page = "brunch";

	if (isset($_POST))
    {
        require('./controller/cartesController.php');
    }

    cleanPost($page);

	$cartes = new Cartes();
	$allCartes = $cartes->getCartes($page);
	$cartes = $allCartes[0];
	$cartesForOtherPages = $allCartes[1];

	$brunchPage = 'class="active"';
	require('./view/carteView.php');
    require('./view/brunchView.php');
}

function loadBeerProject($admin)
{
	$page = "beerProject";

    require('./controller/beerProjectController.php');

    cleanPost($page);

	$beerProject = new BeerProject();
	$beerProjectList = $beerProject->getList($page);

	$beerProjectPage = 'class="active"';
    require('./view/beerProjectView.php');	
}

function loadAgenda($admin)
{
	$page = "agenda";

    require('./controller/beerProjectController.php');

    cleanPost($page);

	$beerProject = new BeerProject();
	$beerProjectList = $beerProject->getList($page);

	$agendaPage = 'class="active"';
    require('./view/agendaView.php');	
}

function loadContact($admin)
{
	$page = "contact";

	cleanPost($page);

	$contactPage = 'class="active"';
    require('./view/contactView.php');
}

function loadAdmin($admin)
{
	$page = "admin";

/* POUR LA MISE EN LIGNE REMPLACER LE PROCHAIN IF PAR CELUI-CI=>
if (isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"]) && Connexion::checkCaptcha() === true && isset($_POST["email"]) && isset($_POST["pwd"]))
*/
	// check connexion infos
	if (isset($_POST["email"]) && isset($_POST["pwd"]))
	{
		$connexion = new Connexion();
		$coResult = $connexion->checkConnexion($_POST["email"], $_POST["pwd"]);

		$_SESSION["alertSms"] = $coResult === false ? '<p class="alertSms">Les informations que vous avez entrées sont incorrectes !</p>' : "";
	}
	else if (isset($_POST["changePwd"]))
	{
		$connexion = new Connexion();
		$connexion->sendResetCode("resetPwd");
	}

	$alertSms = $_SESSION["alertSms"] ?? '';

	cleanPost($page);

	require('./view/adminView.php');
}

