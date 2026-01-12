<?php

require_once __DIR__ . "/helpers.php";

$product = [
    "name" => "Produit rétro",
    "priceHT" => 100,
    "vat" => 20,
    "discount" => 10,
    "stock" => 3,
    "dateAdded" => date("Y-m-d", strtotime("-5 days"))
];

$ttc = calculateIncludingTax($product["priceHT"], $product["vat"]);
$finalPrice = calculateDiscount($ttc, $product["discount"]);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Test helpers</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 24px; }
        .badge { color: #fff; padding: 4px 10px; border-radius: 6px; }
    </style>
</head>
<body>

    <h1><?= htmlspecialchars($product["name"]) ?></h1>

    <p>Prix HT : <?= formatPrice($product["priceHT"]) ?></p>
    <p>Prix TTC : <?= formatPrice($ttc) ?></p>
    <p>Prix final : <?= displayPrice($ttc, $product["discount"]) ?></p>

    <p>Stock : <?= displayStock($product["stock"]) ?></p>

    <p>Nouveau :
        <?= isNew($product["dateAdded"]) ? "oui" : "non" ?>
    </p>

    <p>Commande possible (2) :
        <?= canOrder($product["stock"], 2) ? "oui" : "non" ?>
    </p>

</body>
</html>
