<?php
$product = [
    "name" => "GeForce 4 MX 440",
    "description" => "Une carte pour les plus de 40 ans",
    "price" => 999.99,
    "category" => "Carte graphique",
    "brand" => "Nvidia",
];

$product["dateAdded"] = date("Y-m-d");
$product["price"] = $product["price"] * 0.9;
$priceFormatted = number_format($product["price"], 2, ",", " ") . " €";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $product["name"] ?></title>
</head>
<body>

<div class="produit">
    <h2><?= $product["name"] ?></h2>

    <p class="description">
        <?= $product["description"] ?>
    </p>

    <p class="prix">
        Prix : <?= $priceFormatted ?>
    </p>

    <p class="categorie">
        Catégorie : <?= $product["category"] ?>
    </p>

    <p class="marque">
        Marque : <?= $product["brand"] ?>
    </p>

    <p class="date">
        Ajouté le : <?= $product["dateAdded"] ?>
    </p>
</div>

</body>
</html>
