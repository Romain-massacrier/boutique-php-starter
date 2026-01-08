<?php

$products = [
    ["name" => "Neo Geo CD", "price" => 299.99, "stock" => 5, "onSale" => false],
    ["name" => "Neo Geo AES", "price" => 399.99, "stock" => 0, "onSale" => false],
    ["name" => "Neo Geo Pocket", "price" => 199.99, "stock" => 15, "onSale" => true],
    ["name" => "Playdia", "price" => 49.99, "stock" => 10, "onSale" => true],
    ["name" => "GameCube", "price" => 89.99, "stock" => 0, "onSale" => false],
    ["name" => "Nintendo 64", "price" => 149.99, "stock" => 8, "onSale" => true],
    ["name" => "Megadrive", "price" => 49.99, "stock" => 3, "onSale" => false],
    ["name" => "TurboGrafx-16", "price" => 499.99, "stock" => 12, "onSale" => true],
    ["name" => "Game Gear", "price" => 59.99, "stock" => 0, "onSale" => false],
    ["name" => "Virtual Boy", "price" => 179.99, "stock" => 20, "onSale" => true],
];

$filteredProducts = [];

foreach ($products as $product) {
    if ($product["stock"] <= 0 || $product["price"] >= 50) {
        continue;
    }
    $filteredProducts[] = $product;
}

echo "<h3>" . count($filteredProducts) . " produits trouvés sur " . count($products) . "</h3>";

echo "<ul>";
foreach ($filteredProducts as $product) {
    echo "<li>";
    echo $product["name"] . " - " . $product["price"] . " € (stock: " . $product["stock"] . ")";
    echo "</li>";
}
echo "</ul>";
