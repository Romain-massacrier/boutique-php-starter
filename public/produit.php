<?php
$name = "Clavier mécanique";
$priceHT = 100;
$vat = 20;
$stock = true;

$priceTTC = $priceHT + ($priceHT * $vat / 100);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $name ?></title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }
        h1 {
            margin-top: 0;
        }
        .price {
            font-size: 22px;
            font-weight: bold;
        }
        .stock {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 14px;
            color: #fff;
            background: <?= $stock ? "#2ecc71" : "#e74c3c" ?>;
        }
    </style>
</head>
<body>

<h1><?= $name ?></h1>

<p>Prix HT : <?= number_format($priceHT, 2, ",", " ") ?> €</p>
<p>TVA : <?= $vat ?> %</p>

<p class="price">
    Prix TTC : <?= number_format($priceTTC, 2, ",", " ") ?> €
</p>

<span class="stock">
    <?= $stock ? "En stock" : "Rupture" ?>
</span>

</body>
</html>
