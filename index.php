<?php
session_start();

require('./controller/routesController.php');

$connexion = new Connexion();
$admin = false;

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
    else
    {
        loadHome($admin);
    }
}
else
{
    loadHome($admin);
}