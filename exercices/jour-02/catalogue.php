<?php
$products = [
    [
        "name" => "T-shirt",
        "price" => 29.99,
        "stock" => 50
    ],
    [
        "name" => "Polo",
        "price" => 19.99,
        "stock" => 50
    ],
    [
        "name" => "Slip",
        "price" => 49.99,
        "stock" => 50
    ],
    [
        "name" => "Jean",
        "price" => 79.99,
        "stock" => 30
    ],
    [
        "name" => "Casquette",
        "price" => 19.99,
        "stock" => 100
    ]
];

// Nom du 3ème produit
echo "Nom du 3ème produit : " . $products[2]["name"] . "<br>";

// Prix du 1er produit
echo "Prix du 1er produit : " . $products[0]["price"] . " €<br>";

// Stock du dernier produit
echo "Stock du dernier produit : " . $products[4]["stock"] . "<br>";

// Modifier le stock du 2ème produit
$products[1]["stock"] += 10;

echo "Nouveau stock du 2ème produit : " . $products[1]["stock"];
