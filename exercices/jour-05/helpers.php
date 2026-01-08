<?php


declare(strict_types=1);


function formatPrice(float $amount, string $currency = "€"): string {
    return number_format($amount, 2, ",", " ") . " " . $currency;
}

/* AFFCalculs */

function calculateVAT(float $priceExcludingTax, float $rate): float {
    return $priceExcludingTax * ($rate / 100);
}

function calculateIncludingTax(float $priceExcludingTax, float $rate): float {
    return $priceExcludingTax + calculateVAT($priceExcludingTax, $rate);
}

function calculateDiscount(float $price, float $percentage): float {
    return $price * (1 - $percentage / 100);
}

/* Validation */

function isInStock(int $stock): bool {
    return $stock > 0;
}

function isOnSale(float $discount): bool {
    return $discount > 0;
}

function isNew(string $dateAdded): bool {
    $dateAdded = new DateTime($dateAdded);
    $dateLimit = (new DateTime())->modify("-30 days");

    return $dateAdded >= $dateLimit;
}

function canOrder(int $stock, int $quantity): bool {
    return $quantity > 0 && $quantity <= $stock;
}

   /* Affichage */

function displayBadge(string $text, string $color): string {
    $text = htmlspecialchars($text);
    $color = htmlspecialchars($color);

    return '<span class="badge" style="background:' . $color . ';">' . $text . '</span>';
}

function displayPrice(float $price, float $discount = 0): string {
    if ($discount > 0) {
        $final = calculateDiscount($price, $discount);

        return
            '<span class="price-old" style="text-decoration:line-through;opacity:.6;">'
            . formatPrice($price) . '</span> '
            . '<span class="price-new" style="font-weight:700;">'
            . formatPrice($final) . '</span>';
    }

    return '<span class="price">' . formatPrice($price) . '</span>';
}

function displayStock(int $quantity): string {
    if ($quantity <= 0) {
        return displayBadge("Rupture", "#b00020");
    }
    if ($quantity < 5) {
        return displayBadge("Stock faible (" . $quantity . ")", "#b26a00");
    }
    return displayBadge("En stock", "#1b5e20");
}
