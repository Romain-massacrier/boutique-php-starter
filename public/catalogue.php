<?php
// starter-project/public/catalogue.php
require_once __DIR__ . '/../app/data.php';
// $products est maintenant disponible
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue</title>
</head>
<body>

<h1>Catalogue</h1>

<div class="produit">
    <h2><?= $products[0]["name"] ?></h2>
    <p class="prix"><?= $products[0]["price"] ?> €</p>
    <p class="stock">Stock : <?= $products[0]["stock"] ?></p>
</div>

<div class="produit">
    <h2><?= $products[1]["name"] ?></h2>
    <p class="prix"><?= $products[1]["price"] ?> €</p>
    <p class="stock">Stock : <?= $products[1]["stock"] ?></p>
</div>

<div class="produit">
    <h2><?= $products[2]["name"] ?></h2>
    <p class="prix"><?= $products[2]["price"] ?> €</p>
    <p class="stock">Stock : <?= $products[2]["stock"] ?></p>
</div>

<div class="produit">
    <h2><?= $products[3]["name"] ?></h2>
    <p class="prix"><?= $products[3]["price"] ?> €</p>
    <p class="stock">Stock : <?= $products[3]["stock"] ?></p>
</div>

<div class="produit">
    <h2><?= $products[4]["name"] ?></h2>
    <p class="prix"><?= $products[4]["price"] ?> €</p>
    <p class="stock">Stock : <?= $products[4]["stock"] ?></p>
</div>

<div class="produit">
    <h2><?= $products[5]["name"] ?></h2>
    <p class="prix"><?= $products[5]["price"] ?> €</p>
    <p class="stock">Stock : <?= $products[5]["stock"] ?></p>
</div>

</body>
</html>
