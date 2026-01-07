<?php

$products = [];

// je génère 10 produits avec une boucle for
for ($i = 1; $i <= 10; $i++) {
    $products[] = [
        "nom" => "Produit " . $i, // Nom du produit (Produit 1, Produit 2, etc.)
        "prix" => rand(10, 100), // Prix aléatoire entre 10 et 100
        "stock" => rand(0, 50),  // Stock aléatoire entre 0 et 50
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produits</title>
</head>
<body>

<?php foreach ($products as $product): ?> <!-- On parcourt le tableau des produits -->
    <p>
        <?= $product["nom"] ?><br> <!-- On afiche le nom du produit -->
        <?= $product["prix"] ?> €<br> <!-- On afiche le prix du produit -->
        Stock : <?= $product["stock"] ?> <!-- On afiche le stock du produit -->
    </p>
<?php endforeach; ?>

</body>
</html>
