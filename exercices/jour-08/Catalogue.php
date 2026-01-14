<?php
require_once "Product.php";

$products = [
    new Product(1, "Space Marine", "Un soldat d'élite de l'Imperium", 50.0, 100, "Figurines"),
    new Product(2, "Ork Boyz", "Des guerriers brutaux et sauvages", 30.0, 200, "Figurines"),
    new Product(3, "Eldar Jetbike", "Un véhicule rapide et agile", 75.0, 50, "Véhicules"),
    new Product(4, "Tyranid Hive Tyrant", "Un monstre terrifiant de la ruche", 120.0, 20, "Monstres"),
    new Product(5, "Necron Warrior", "Un soldat immortel de la race Necron", 40.0, 150, "Figurines"),
];

$totalStock = 0;
$totalValue = 0;

echo "<h2>Catalogue Warhammer 40K</h2>";

foreach ($products as $product) {
    echo "<div style='border:1px solid #999; padding:10px; margin-bottom:10px'>";
    echo "<strong>Produit:</strong> " . $product->nom . "<br>";
    echo "<strong>Description:</strong> " . $product->description . "<br>";
    echo "<strong>Prix HT:</strong> " . $product->prix . " EUR<br>";
    echo "<strong>Prix TTC:</strong> " . number_format($product->getPriceIncludingTax(), 2) . " EUR<br>";
    echo "<strong>Stock:</strong> " . $product->stock . "<br>";
    echo "<strong>Catégorie:</strong> " . $product->categorie . "<br>";
    echo "</div>";

    $totalStock += $product->stock;
    $totalValue += $product->prix * $product->stock;
}

echo "<hr>";
echo "<strong>Stock total:</strong> " . $totalStock . "<br>";
echo "<strong>Valeur totale du catalogue:</strong> " . number_format($totalValue, 2) . " EUR";
