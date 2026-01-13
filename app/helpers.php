<?php

function formatPrice(float $price): string
{
    return number_format($price, 2, ",", " ") . " €";
}

function calculateIncludingTax(float $priceHT, float $vatPercent): float
{
    return $priceHT * (1 + ($vatPercent / 100));
}

function calculateDiscount(float $price, float $discountPercent): float
{
    return $price * (1 - ($discountPercent / 100));
}

function displayBadges(array $product): string
{
    $isNew = !empty($product["new"]);
    $discount = (float)($product["discount"] ?? 0);

    $html = "";

    if ($isNew) {
        $html .= '<span class="badge badge-new">NOUVEAU</span> ';
    }

    if ($discount > 0) {
        $html .= '<span class="badge badge-sale">PROMO -' . (int)$discount . '%</span> ';
    }

    return trim($html);
}

function displayPriceTTC(float $priceHT, float $vatPercent, float $discountPercent = 0): string
{
    $ttc = calculateIncludingTax($priceHT, $vatPercent);

    if ($discountPercent > 0) {
        $final = calculateDiscount($ttc, $discountPercent);

        return
            '<span class="price-old">' . htmlspecialchars(formatPrice($ttc)) . '</span> ' .
            '<span class="price-new">' . htmlspecialchars(formatPrice($final)) . '</span>';
    }

    return '<span class="price">' . htmlspecialchars(formatPrice($ttc)) . '</span>';
}

function displayStockStatus(int $stock): string
{
    if ($stock <= 0) {
        return '<div class="stock rupture">Rupture de stock</div>';
    }

    if ($stock <= 5) {
        return '<div class="stock faible">Stock faible (' . (int)$stock . ')</div>';
    }

    return '<div class="stock en-stock">En stock (' . (int)$stock . ')</div>';
}
