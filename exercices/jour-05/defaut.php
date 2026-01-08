<?php

function formatPrice($amount, $currency = "€", $decimals = 2): string {
    return number_format($amount, $decimals, ',', ' ') . ' ' . $currency;
}
echo formatPrice(99.999) . "<br>";
echo formatPrice(99.999, "$") . "<br>";
echo formatPrice(99.999, "€", 0) . "<br>";
?>
