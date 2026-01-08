<?php

function isInStock(int $stock): bool {
    return $stock > 0;
}

function isOnSale(float $discount): bool {
    return $discount > 0;
}

function isNew(string $dateAdded): bool {
    $dateAdded = new DateTime($dateAdded);
    $dateLimit = (new DateTime())->modify('-30 days');

    return $dateAdded >= $dateLimit;
}

function canOrder(int $stock, int $quantity): bool {
    return $quantity > 0 && $quantity <= $stock;
}
$dateAdded = "2027-12-01";
$daysSince = (time() - strtotime($dateAdded)) / 86400;

echo isInStock(1) ? "En stock" : "Rupture de stock";
echo "</br>";
echo isOnSale(15.5) ? "En promotion" : "Prix normal";
echo "</br>";
echo isNew($dateAdded) ? "Nouveau produit" : "Produit ancien";
echo "</br>";
echo canOrder(5, 3) ? "Commande possible" : "Quantité non disponible";
?>