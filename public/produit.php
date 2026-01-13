<?php
require_once __DIR__ . '/../app/data.php';
require_once __DIR__ . '/../app/helpers.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === null || $id === false) {
    http_response_code(400);
    echo "ID invalide";
    exit;
}

// Recherche du produit par son vrai id
$product = null;
foreach ($products as $p) {
    if ((int)$p['id'] === (int)$id) {
        $product = $p;
        break;
    }
}

if (!$product) {
    http_response_code(404);
    echo "Produit non trouvé";
    exit;
}

// Sécurisation des champs
$name = $product['name'] ?? 'Produit';
$image = $product['image'] ?? 'https://via.placeholder.com/520x520?text=No+Image';
$desc = $product['description'] ?? '';
$price = $product['price'] ?? 0;
$stock = $product['stock'] ?? 0;
$discount = $product['discount'] ?? 0;
$vat = 20;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($name); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1><?php echo htmlspecialchars($name); ?></h1>
    <nav>
        <a href="catalogue.php">Retour catalogue</a>
    </nav>
</header>

<main>
    <div class="product-detail">

        <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($name); ?>">

        <div class="product-info">

            <div class="badges">
                <?php
                if (function_exists('displayBadges')) {
                    echo displayBadges($product);
                }
                ?>
            </div>

            <div class="price">
                <?php
                if (function_exists('displayPriceTTC')) {
                    echo displayPriceTTC($price, $vat, $discount);
                } else {
                    echo number_format($price, 2, ',', ' ') . " €";
                }
                ?>
            </div>

            <div class="stock-status">
                <?php
                if (function_exists('displayStockStatus')) {
                    echo displayStockStatus($stock);
                } else {
                    echo ($stock > 0) ? "En stock" : "Rupture";
                }
                ?>
            </div>

            <?php if ($desc): ?>
                <p><?php echo htmlspecialchars($desc); ?></p>
            <?php endif; ?>

        </div>
    </div>
</main>

</body>
</html>
