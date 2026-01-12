<?php
declare(strict_types=1);

/* exercices/jour-05/test-ecommerce-helpers.php
Page de test qui démontre chaque fonction
*/

require_once __DIR__ . '/ecommerce-helpers.php';

$cart = [19.99, 49.90, "12.50", "abc"]; // "abc" ignoré

$product1 = [
    'name' => 'iPhone',
    'is_new' => true,
    'discount' => 15,
    'stock' => 3,
    'featured' => true,
];

$product2 = [
    'name' => 'Clavier',
    'is_new' => false,
    'discount' => 0,
    'stock' => 0,
    'featured' => false,
];
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Test ecommerce-helpers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
       
    </style>
</head>
<body>

<h1>Tests ecommerce-helpers.php</h1>

<div class="card">
    <h2>Fonctions de calcul</h2>

    <div class="row"><div class="label">calculateIncludingTax(100, 20)</div><div><?= formatPrice(calculateIncludingTax(100, 20)) ?></div></div>
    <div class="row"><div class="label">calculateIncludingTax(59.99, 5.5)</div><div><?= formatPrice(calculateIncludingTax(59.99, 5.5)) ?></div></div>

    <div class="row"><div class="label">calculateDiscount(200, 10)</div><div><?= formatPrice(calculateDiscount(200, 10)) ?></div></div>
    <div class="row"><div class="label">calculateDiscount(49.90, 0)</div><div><?= formatPrice(calculateDiscount(49.90, 0)) ?></div></div>

    <div class="row"><div class="label">calculateTotal(cart)</div><div><?= formatPrice(calculateTotal($cart)) ?></div></div>
    <pre><?= htmlspecialchars(print_r($cart, true), ENT_QUOTES, 'UTF-8') ?></pre>
</div>

<div class="card">
    <h2>Fonctions de formatage</h2>

    <div class="row"><div class="label">formatPrice(1234.5)</div><div><?= formatPrice(1234.5) ?></div></div>
    <div class="row"><div class="label">formatDate("2024-01-15")</div><div><?= formatDate("2024-01-15") ?></div></div>
    <div class="row"><div class="label">formatDate(aujourd'hui)</div><div><?= formatDate(date('Y-m-d')) ?></div></div>
</div>

<div class="card">
    <h2>Fonctions d'affichage</h2>

    <div class="row"><div class="label">displayStockStatus(25)</div><div><?= displayStockStatus(25) ?></div></div>
    <div class="row"><div class="label">displayStockStatus(3)</div><div><?= displayStockStatus(3) ?></div></div>
    <div class="row"><div class="label">displayStockStatus(0)</div><div><?= displayStockStatus(0) ?></div></div>

    <h3>displayBadges(product1)</h3>
    <div><strong><?= htmlspecialchars($product1['name'], ENT_QUOTES, 'UTF-8') ?></strong></div>
    <?= displayBadges($product1) ?>

    <h3>displayBadges(product2)</h3>
    <div><strong><?= htmlspecialchars($product2['name'], ENT_QUOTES, 'UTF-8') ?></strong></div>
    <?= displayBadges($product2) ?>
</div>

<div class="card">
    <h2>Fonctions de validation</h2>

    <div class="row"><div class="label">validateEmail("test@example.com")</div><div><?= validateEmail("test@example.com") ? 'true' : 'false' ?></div></div>
    <div class="row"><div class="label">validateEmail("pas-un-mail")</div><div><?= validateEmail("pas-un-mail") ? 'true' : 'false' ?></div></div>

    <div class="row"><div class="label">validatePrice(10)</div><div><?= validatePrice(10) ? 'true' : 'false' ?></div></div>
    <div class="row"><div class="label">validatePrice(0)</div><div><?= validatePrice(0) ? 'true' : 'false' ?></div></div>
    <div class="row"><div class="label">validatePrice(-5)</div><div><?= validatePrice(-5) ? 'true' : 'false' ?></div></div>
    <div class="row"><div class="label">validatePrice("12.50")</div><div><?= validatePrice("12.50") ? 'true' : 'false' ?></div></div>
    <div class="row"><div class="label">validatePrice("abc")</div><div><?= validatePrice("abc") ? 'true' : 'false' ?></div></div>
</div>

<div class="card">
    <h2>Fonction de debug</h2>
    <p>Décommente pour tester : la page s'arrêtera immédiatement.</p>
    <pre><code>
$name = "iPhone";
$price = 999.99;
dump_and_die($name, $price, $product1);
    </code></pre>
</div>

</body>
</html>
