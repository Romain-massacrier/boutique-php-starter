<?php

// Déclarations
$priceExcludingTax = 100;
$vat = 20;
$quantity = 3;

// Calculs
$vatAmount = $priceExcludingTax * ($vat / 100);
$priceIncludingTax = $priceExcludingTax + $vatAmount;
$totalPrice = $priceIncludingTax * $quantity;

// Affichage
echo "<pre>";
echo "Prix HT : $priceExcludingTax €\n";
echo "TVA ($vat %) : $vatAmount €\n";
echo "Prix TTC unitaire : $priceIncludingTax €\n";
echo "Quantité : $quantity\n";
echo "Total TTC : $totalPrice €\n";
echo "</pre>";
