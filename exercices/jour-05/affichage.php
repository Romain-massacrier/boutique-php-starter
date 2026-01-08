<?php

function displayBadge(string $text, string $color): string {
    $text = htmlspecialchars($text);
    $color = htmlspecialchars($color);

    return '<span class="badge" style="background: ' . $color . ';">' . $text . '</span>';
}

function displayPrice(float $price, float $discount = 0): string {
    if ($discount > 0) {
        $discountedPrice = $price * (1 - $discount / 100);

        return
            '<span class="original-price" style="text-decoration: line-through;">'
            . number_format($price, 2, ",", " ") . ' €</span> '
            . '<span class="discounted-price">'
            . number_format($discountedPrice, 2, ",", " ") . ' €</span>';
    }

    return '<span class="price">' . number_format($price, 2, ",", " ") . ' €</span>';
}

function displayStock(int $quantity): string {
    if ($quantity > 10) {
        return displayBadge("En stock", "green");
    }
    if ($quantity > 0) {
        return displayBadge("Derniers articles", "orange");
    }
    return displayBadge("Rupture de stock", "red");
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Affichage Produit</title>
    <style>
        .badge {
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
            font-weight: 600;
        }
        .original-price {
            color: #777;
        }
        .discounted-price {
            color: #c62828;
            font-weight: bold;
        }
        .price {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Produit Rétro</h1>

    <p>Prix : <?= displayPrice(49.99, 20) ?></p>
    <p>Stock : <?= displayStock(100) ?></p>
</body>
</html>
