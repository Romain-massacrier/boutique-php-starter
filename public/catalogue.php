<?php
// starter-project/public/catalogue.php

session_start();

require_once __DIR__ . "/../app/data.php";     // $products
require_once __DIR__ . "/../app/helpers.php";  // helpers

// Initialisation panier
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Ajout panier
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_to_cart"])) {
    $index = (int)($_POST["index"] ?? -1);

    if (isset($products[$index])) {
        $p = $products[$index];

        $_SESSION["cart"][] = [
            "name" => (string)$p["name"],
            "price" => (float)$p["price"],
            "discount" => (float)($p["discount"] ?? 0),
            "vat" => 20.0
        ];
    }

    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

// Stats
$inStock = 0;
$onSale = 0;
$outOfStock = 0;

foreach ($products as $product) {
    $discount = (float)($product["discount"] ?? 0);
    $stock = (int)($product["stock"] ?? 0);

    if ($stock > 0) $inStock++;
    if ($discount > 0) $onSale++;
    if ($stock === 0) $outOfStock++;
}

// Total panier
$cartTotal = 0.0;
foreach ($_SESSION["cart"] as $item) {
    $ttc = calculateIncludingTax((float)$item["price"], (float)$item["vat"]);
    $final = ((float)$item["discount"] > 0) ? calculateDiscount($ttc, (float)$item["discount"]) : $ttc;
    $cartTotal += $final;
}

// Vider le panier
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["clear_cart"])) {
    $_SESSION["cart"] = [];

    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 24px; }
        .topbar { display:flex; justify-content:space-between; align-items:flex-start; gap: 16px; }
        .stats { margin: 8px 0 20px; opacity: .85; }
        .cart { border:1px solid #ddd; border-radius:10px; padding:12px; min-width: 260px; }
        .cart h2 { margin: 0 0 8px; font-size: 18px; }
        .cart ul { margin: 0; padding-left: 18px; }
        .cart small { opacity: .8; }
        .grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .produit { border:1px solid #ddd; padding:12px; border-radius:10px; display:flex; gap: 12px; }
        .produit img { width: 140px; height: 120px; object-fit: contain; background:#f7f7f7; border-radius: 8px; }
        .content { flex: 1; }
        .badges { margin: 6px 0 10px; }
        .badge { display:inline-block; padding: 4px 10px; border-radius: 999px; color:#fff; font-size: 12px; font-weight: 700; }
        .badge-new { background: #1565c0; }
        .badge-sale { background: #6a1b9a; }
        .desc { margin: 8px 0 10px; opacity: .9; }
        .price { font-weight: 800; }
        .price-old { text-decoration: line-through; opacity: .6; }
        .price-new { font-weight: 900; }
        .stock { margin-top: 8px; }
        .stock.en-stock { color: green; font-weight: 800; }
        .stock.faible { color: orange; font-weight: 800; }
        .stock.rupture { color: red; font-weight: 800; }
        .actions { margin-top: 10px; }
        button { padding: 8px 10px; border-radius: 8px; border: 1px solid #ccc; background: #fff; cursor: pointer; }
        button:disabled { opacity: .5; cursor: not-allowed; }
    </style>
</head>
<body>

<div class="topbar">
    <div>
        <h1>Catalogue</h1>
        <div class="stats">
            En stock: <?= $inStock ?> | En promo: <?= $onSale ?> | Rupture: <?= $outOfStock ?>
        </div>
    </div>

    <div class="cart">
    <h2>Panier (<?= count($_SESSION["cart"]) ?>)</h2>

    <?php if (count($_SESSION["cart"]) === 0): ?>
        <p><small>Panier vide</small></p>
    <?php else: ?>
        <ul>
            <?php foreach ($_SESSION["cart"] as $item): ?>
                <li>
                    <?= htmlspecialchars($item["name"]) ?>
                    <small>(<?= formatPrice(calculateIncludingTax((float)$item["price"])) ?>)</small>
                </li>
            <?php endforeach; ?>
        </ul>

        <p><strong>Total:</strong> <?= formatPrice($cartTotal) ?></p>

        <!-- BOUTON ICI -->
        <form method="post" style="margin-top:10px;">
            <button type="submit" name="clear_cart">
                Vider le panier
            </button>
        </form>
    <?php endif; ?>
</div>


<div class="grid">
<?php foreach ($products as $i => $product): ?>
    <div class="produit">
        <img src="<?= htmlspecialchars($product["image"]) ?>" alt="<?= htmlspecialchars($product["name"]) ?>">

        <div class="content">
            <h2><?= htmlspecialchars($product["name"]) ?></h2>

            <div class="badges">
                <?= displayBadges($product) ?>
            </div>

            <p class="desc"><?= htmlspecialchars($product["description"]) ?></p>

            <p class="prix">
                <?= displayPriceTTC((float)$product["price"], 20, (float)($product["discount"] ?? 0)) ?>
            </p>

            <?= displayStockStatus((int)$product["stock"]) ?>

            <div class="actions">
                <form method="post" style="margin:0;">
                    <input type="hidden" name="index" value="<?= (int)$i ?>">
                    <button type="submit" name="add_to_cart" <?= ((int)$product["stock"] <= 0) ? "disabled" : "" ?>>
                        Ajouter au panier
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>
