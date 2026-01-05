<?php

$name = "Clavier mécanique";
$price = 129.99;
$stock = true;//true=en stock, false=rupture
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title><?=$name ?></title>
</head>
<body>
<h1><?=$name ?></h1>
<p>Prix :<?=$price ?>€</p>
<span>
<?=$stock ? "En stock" : "Rupture" ?>
</span>
</body>
</html>
