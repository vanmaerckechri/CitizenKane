<?php
require('./controller/routesController.php');

$session = new Session();
$admin = $session->testAdmin();

if (isset($_GET['action']))
{
    if ($_GET['action'] == 'home')
    {
        loadHome();
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
    else
    {
        loadHome();
    }
}
else
{
    loadHome();
}