<?php

function calculateVAT(float $priceExcludingTax, float $rate): float {
    return $priceExcludingTax * ($rate / 100);
}
function calculateIncludingTax(float $priceExcludingTax, float $rate): float {
    return $priceExcludingTax + calculateVAT($priceExcludingTax, $rate);
}
function calculateDiscount(float $price, float $percentage): float {
    return $price * (1 - $percentage / 100);
}
$product = 100.0;
$vatRate = 20.0;
$discountPercentage = 10.0;

$vat = calculateVAT($product, $vatRate);
$ttc = calculateIncludingTax($product, $vatRate);
$finalPrice = calculateDiscount($ttc, $discountPercentage);
$discountPercentage = $ttc - $finalPrice;

echo "Prix HT : " . $product . " €</br>";
echo "TVA (" . $vatRate . "%) : " . $vat . " €</br>";
echo "Prix TTC : " . $ttc . " €</br>";
echo "Prix final après remise de " . $discountPercentage . "% : " . $finalPrice . " €</br>";
?>

