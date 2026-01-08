<?php

$stock = 10;
$active = true;
$promoEndDate = "2026-01-01";

$isAvailable = $stock > 0 && $active === true;
$isOnSale = time() < strtotime($promoEndDate);

if ($isAvailable) {
    echo "Available";
} else {
    echo "Unavailable";
}

echo "<br>";

if ($isOnSale) {
    echo "On sale";
} else {
    echo "No promotion";
}
