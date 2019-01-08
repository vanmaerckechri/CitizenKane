<?php
session_start();

require('./controller/routesController.php');

$connexion = new Connexion();
$admin = false;

$_SESSION["nickname"] = "test";
$_SESSION["password"] = hash('sha1', "test", true);

//0xa94a8fe5ccb19ba61c4c0873d391e987982fbbd3

if (isset($_SESSION["nickname"]) && !empty($_SESSION["nickname"]) && isset($_SESSION["password"]) && !empty($_SESSION["password"]))
{
    $admin = $connexion->checkConnexion($_SESSION["nickname"], $_SESSION["password"]);
}

if (isset($_GET['action']))
{
    if ($_GET['action'] == 'home')
    {
        loadHome($admin);
    }
    elseif ($_GET['action'] == 'restaurant')
    {
        loadRestaurant($admin);
    }
    elseif ($_GET['action'] == 'cafe')
    {
        loadCafe($admin);
    }
    elseif ($_GET['action'] == 'beerProject')
    {
        loadBeerProject($admin);
    }
    elseif ($_GET['action'] == 'agenda')
    {
        loadAgenda($admin);
    }
    elseif ($_GET['action'] == 'brunch')
    {
        loadBrunch($admin);
    }
    elseif ($_GET['action'] == 'contact')
    {
        loadContact($admin);
    }
    elseif ($_GET['action'] == 'admin')
    {
        loadAdmin($admin);
    }
    elseif ($_GET['action'] == 'resetPwd')
    {
        loadAdminReset($admin, "resetPwd");
    }
    elseif ($_GET['action'] == 'resetMail')
    {
        loadAdminReset($admin, "resetMail");
    }
    else
    {
        loadHome($admin);
    }
}
else
{
    loadHome($admin);
}