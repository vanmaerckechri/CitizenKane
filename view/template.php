<?php 
require('header.php');
require('footer.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?= htmlspecialchars($headDescription) ?>">
    <link rel="icon" type="image/png" href="icon_citizen.png">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700|Montserrat:700" rel="stylesheet"> 
    <link rel="stylesheet" href="assets/css/style.css">
    <title><?= htmlspecialchars($headTitle) ?></title>
</head>
<body>
	<?= $header ?>
	<?= $content ?>
	<?= $footer ?>
	<?= $javascript ?>
</body>
</html>