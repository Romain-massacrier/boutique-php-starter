<?php
// Tableau de 10 produits avec des stocks variés
$products = [
    ["name" => "Clavier", "price" => 49.99, "stock" => 12],
    ["name" => "Souris", "price" => 19.99, "stock" => 0],
    ["name" => "Ecran 24 pouces", "price" => 99.99, "stock" => 5],
    ["name" => "Casque audio", "price" => 79.90, "stock" => 8],
    ["name" => "Webcam", "price" => 59.00, "stock" => 0],
    ["name" => "Micro USB", "price" => 89.90, "stock" => 3],
    ["name" => "Chaise gamer", "price" => 149.99, "stock" => 4], // > 100 € → stop
    ["name" => "Tapis de souris", "price" => 9.99, "stock" => 25],
    ["name" => "Cle USB", "price" => 14.99, "stock" => 0],
    ["name" => "Support ecran", "price" => 39.99, "stock" => 6],
];

// Parcours des produits
foreach ($products as $product) {

    // Si le stock est à 0, on saute ce produit
    if ($product["stock"] === 0) {
        continue;
    }

    // Si le prix est supérieur à 100 €, on arrête la boucle
    if ($product["price"] > 100) {
        break;
    }

    // Affichage uniquement des produits en stock et < 100 €
    echo "<p>";
    echo "<strong>" . $product["name"] . "</strong><br>";
    echo "Prix : " . $product["price"] . " €<br>";
    echo "Stock : " . $product["stock"];
    echo "</p>";
}
