<?php
// starter-project/app/helpers.php
declare(strict_types=1);

function calculateIncludingTax(float $priceExcludingTax, float $vat = 20): float {
    return $priceExcludingTax * (1 + $vat / 100);
}

function calculateDiscount(float $price, float $percentage): float {
    return $price * (1 - $percentage / 100);
}

function formatPrice(float $amount): string {
    return number_format($amount, 2, ",", " ") . " €";
}

function displayStockStatus(int $stock): string {
    if ($stock <= 0) {
        return '<p class="stock rupture">Rupture</p>';
    }
    if ($stock < 5) {
        return '<p class="stock faible">Stock faible (' . $stock . ')</p>';
    }
    return '<p class="stock en-stock">En stock (' . $stock . ')</p>';
}

function displayBadges(array $product): string {
    $html = '';

    $isNew = !empty($product["new"]);
    $discount = (float)($product["discount"] ?? 0);

    if ($isNew) {
        $html .= '<span class="badge badge-new">Nouveau</span> ';
    }
    if ($discount > 0) {
        $html .= '<span class="badge badge-sale">Promo -' . (int)$discount . '%</span> ';
    }

    return trim($html);
}

function displayPriceTTC(float $priceHT, float $vat = 20, float $discount = 0): string {
    $ttc = calculateIncludingTax($priceHT, $vat);

    if ($discount > 0) {
        $final = calculateDiscount($ttc, $discount);
        return '<span class="price-old">' . formatPrice($ttc) . '</span> <span class="price-new">' . formatPrice($final) . '</span>';
    }

    return '<span class="price">' . formatPrice($ttc) . '</span>';
}
