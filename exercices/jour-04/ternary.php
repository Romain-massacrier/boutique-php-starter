<?php
$products = [
    [
        "name" => "Playdia",
        "price" => 49.99,
        "stock" => 10,
        "onSale" => true,
    ],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue</title>
    <style>
        .grille {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .rupture {
            color: red;
        }
        .en-stock {
            color: green;
        }
        .badge {
            background-color: red;
            color: white;
            padding: 5px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
        }
        .prix-barre {
            text-decoration: line-through;
            color: gray;
        }
    </style>
</head>
<body>

<div class="grille">
    <?php foreach ($products as $product): ?>
        <div class="produit">

            <h2>
                <?= $product["name"] ?>
                <?= $product["onSale"] && $product["stock"] > 0 ? "🔥 PROMO" : "" ?>
            </h2>

            <p class="<?= $product["stock"] > 0 ? "en-stock" : "rupture" ?>">
                <?= $product["stock"] > 0 ? "En stock" : "Rupture de stock" ?>
            </p>

            <?php if ($product["onSale"] && $product["stock"] > 0): ?>
                <p class="prix-barre"><?= $product["price"] ?> €</p>
                <p><?= number_format($product["price"] * 0.8, 2) ?> €</p>
            <?php else: ?>
                <p><?= $product["price"] ?> €</p>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
