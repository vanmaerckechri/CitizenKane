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
	$connexion = new Connexion();

	if ($admin === true)
	{
		// send mail for new pwd
		if (isset($_POST["changePwd"]))
		{
			$connexion->sendResetCode("resetPwd", $_SESSION["nickname"]);
			$_SESSION["alertSms"] = '<p class="alertSms">Un mail avec lien vous permettant de modifier votre mot de passe vient de vous être envoyé !</p>';
		}
		// send mail for new mail
		if (isset($_POST["changeMail"]))
		{
			$connexion->sendResetCode("resetMail", $_SESSION["nickname"]);
			$_SESSION["alertSms"] = '<p class="alertSms">Un mail avec lien vous permettant de modifier votre adresse mail vient de vous être envoyé !</p>';
		}
		// update new pwd
		else if (isset($_POST["newPwd"]) && !empty($_POST["newPwd"]) && isset($_POST["resetCode"]) && !empty($_POST["resetCode"]))
		{
			$updBool = $connexion->updatePwdOrMail($_POST["newPwd"], "pwd", $_POST["resetCode"]);
			if ($updBool === true)
			{
				$_SESSION["alertSms"] = '<p class="alertSms">Mot de passe changé avec succès !</p>';
			}
			else
			{
				$_SESSION["alertSms"] = '<p class="alertSms">Le lien à expiré !</p>';				
			}
		}
		// update new mail
		else if (isset($_POST["newMail"]) && !empty($_POST["newMail"]) && isset($_POST["resetCode"]) && !empty($_POST["resetCode"]))
		{
			if (filter_var($_POST["newMail"], FILTER_VALIDATE_EMAIL))
			{
				$updBool = $connexion->updatePwdOrMail($_POST["newMail"], "mail", $_POST["resetCode"]);
				if ($updBool === true)
				{
					$_SESSION["alertSms"] = '<p class="alertSms">Adresse mail changée avec succès !</p>';
				}
				else
				{
					$_SESSION["alertSms"] = '<p class="alertSms">Le lien à expiré !</p>';				
				}
			}
			else
			{
					$_SESSION["alertSms"] = '<p class="alertSms">Adresse mail invalide !</p>';								
			}
		}
	}
	else
	{
		if (isset($_POST["g-recaptcha-response"]) && !empty($_POST["g-recaptcha-response"]) && Connexion::checkCaptcha() === true)
		{
			// check connexion infos
			if (isset($_POST["email"]) && isset($_POST["pwd"]))
			{
				$coResult = $connexion->checkConnexion($_POST["email"], $_POST["pwd"], true);

				$_SESSION["alertSms"] = $coResult === false ? '<p class="alertSms">Les informations que vous avez entrées sont incorrectes !</p>' : "";
			}
			// send mail for lost pwd
			else if (isset($_POST["mailForChangePwd"]) && !empty($_POST["mailForChangePwd"]))
			{
				if (filter_var($_POST["mailForChangePwd"], FILTER_VALIDATE_EMAIL))
				{
					$connexion->sendResetCode("resetPwd", $_POST["mailForChangePwd"]);
					$_SESSION["alertSms"] = '<p class="alertSms">Un mail avec lien vous permettant de modifier votre mot de passe vient de vous être envoyé !</p>';
				}
				else
				{
						$_SESSION["alertSms"] = '<p class="alertSms">Adresse mail invalide !</p>';								
				}
			}		
			// update new pwd for lost pwd
			else if (isset($_POST["newPwd"]) && !empty($_POST["newPwd"]) && isset($_POST["resetCode"]) && !empty($_POST["resetCode"]))
			{

			}
		}
	}

	$alertSms = $_SESSION["alertSms"] ?? '';

	cleanPost($page);

	require('./view/adminView.php');
}

function loadAdminReset($admin, $pwdOrMail)
{
	$page = "adminReset";

	if (isset($_GET["code"]) && !empty($_GET["code"]))
	{
		$connexion = new Connexion();
		$codeResultBool = $connexion->checkResetCode($_GET["code"], $pwdOrMail);
		if ($codeResultBool === true)
		{
			require('./view/adminResetView.php');
		}
		else
		{
			$_SESSION["alertSms"] = '<p class="alertSms">Le lien a expiré !</p>';

			header("Location: ./index.php?action=admin");
		}
	}
	else
	{
		header("Location: ./index.php?action=admin");
	}
}

