<?php

$products = [
    1 => ["name" => "Ordinateur portable", "price" => 799.99],
    2 => ["name" => "Smartphone", "price" => 499.99],
    3 => ["name" => "Tablette", "price" => 299.99],
    4 => ["name" => "Casque audio", "price" => 99.99],
    5 => ["name" => "Montre connectée", "price" => 199.99],
];

// Récupérer le paramètre "id" depuis l'URL

$id = $_GET["id"] ?? null;

// affiche le produit correspondant ou "produit non trouvé"

if ($id !== null && isset($products[$id])) {
    $product = $products[$id];
    echo "Produit : " . htmlspecialchars($product["name"]) . "<br>";
    echo "Prix : " . number_format($product["price"], 2) . " €";
} else {
    echo "Produit non trouvé.";
}

