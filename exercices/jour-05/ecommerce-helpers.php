<?php
declare(strict_types=1);

/*Fonctions de calcul */

function calculateIncludingTax(float $priceExcludingTax, float $vat = 20): float
{
    $multiplier = 1 + ($vat / 100);
    return round($priceExcludingTax * $multiplier, 2);
}

function calculateDiscount(float $price, float $percentage): float
{
    if ($percentage <= 0) {
        return round($price, 2);
    }
    $discounted = $price * (1 - ($percentage / 100));
    return round(max(0, $discounted), 2);
}

function calculateTotal(array $cart): float
{
    $total = 0.0;
    foreach ($cart as $item) {
        if (is_numeric($item)) {
            $total += (float) $item;
        }
    }
    return round($total, 2);
}

/* Fonctions de formatage */

function formatPrice(float $amount): string
{
    // 1234.5 -> "1 234,50 €"
    $formatted = number_format($amount, 2, ',', ' ');
    return $formatted . ' €';
}

function formatDate(string $date): string
{
    // Accepte "YYYY-MM-DD" ou toute date parseable par strtotime()
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return $date; // fallback
    }

    // Si l'extension intl est dispo, c'est le plus propre
    if (class_exists('IntlDateFormatter')) {
        $formatter = new IntlDateFormatter(
            'fr_FR',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            date_default_timezone_get(),
            IntlDateFormatter::GREGORIAN,
            'd MMMM y'
        );

        $out = $formatter->format($timestamp);
        if (is_string($out) && $out !== '') {
            return $out;
        }
    }

    // Fallback manuel
    $months = [
        1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
        5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
        9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre',
    ];

    $day = (int) date('d', $timestamp);
    $month = (int) date('n', $timestamp);
    $year = (int) date('Y', $timestamp);

    $monthName = $months[$month] ?? date('m', $timestamp);
    return $day . ' ' . $monthName . ' ' . $year;
}

/* Fonctions d'affichage */

function displayStockStatus(int $stock): string
{
    if ($stock > 10) {
        return '<span style="display:inline-block;padding:4px 10px;border-radius:999px;background:#e8f5e9;color:#1b5e20;font-weight:700;">En stock</span>';
    }

    if ($stock > 0) {
        return '<span style="display:inline-block;padding:4px 10px;border-radius:999px;background:#fff3e0;color:#e65100;font-weight:700;">Derniers articles</span>';
    }

    return '<span style="display:inline-block;padding:4px 10px;border-radius:999px;background:#ffebee;color:#b71c1c;font-weight:700;">Rupture de stock</span>';
}

function displayBadges(array $product): string
{
    $badges = [];

    $stock = isset($product['stock']) ? (int) $product['stock'] : null;
    $discount = isset($product['discount']) ? (float) $product['discount'] : 0.0;

    // NEW: bool is_new ou date_added < 30 jours
    $isNew = false;
    if (isset($product['is_new'])) {
        $isNew = (bool) $product['is_new'];
    } elseif (!empty($product['date_added'])) {
        $days = (time() - strtotime((string) $product['date_added'])) / 86400;
        if (is_finite($days) && $days >= 0 && $days < 30) {
            $isNew = true;
        }
    }

    // Badges
    if ($isNew) {
        $badges[] = '<span style="display:inline-block;padding:4px 10px;border-radius:6px;background:#e3f2fd;color:#0d47a1;font-weight:700;">Nouveau</span>';
    }

    if ($discount > 0) {
        $percent = rtrim(rtrim(number_format($discount, 0, ',', ' '), '0'), ',');
        $badges[] = '<span style="display:inline-block;padding:4px 10px;border-radius:6px;background:#fce4ec;color:#880e4f;font-weight:700;">Promo -' . htmlspecialchars($percent, ENT_QUOTES, 'UTF-8') . '%</span>';
    }

    if ($stock !== null && $stock <= 0) {
        $badges[] = '<span style="display:inline-block;padding:4px 10px;border-radius:6px;background:#eeeeee;color:#424242;font-weight:700;">Indisponible</span>';
    }

    if (!empty($product['featured'])) {
        $badges[] = '<span style="display:inline-block;padding:4px 10px;border-radius:6px;background:#fff8e1;color:#6d4c41;font-weight:700;">Best-seller</span>';
    }

    if (empty($badges)) {
        return '';
    }

    return '<div style="display:flex;gap:8px;flex-wrap:wrap;margin:8px 0;">' . implode('', $badges) . '</div>';
}

/* Fonctions de validation */

function validateEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePrice(mixed $price): bool
{
    if (!is_numeric($price)) {
        return false;
    }
    return (float) $price > 0;
}

/* Fonction de debug */

function dump_and_die(mixed ...$vars): void
{
    $containerStyle = 'background:#1e1e1e;color:#4ec9b0;padding:20px;border-radius:5px;font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;line-height:1.5;white-space:pre-wrap;';
    $blockStyle = 'background:#111;color:#c3e88d;padding:14px 16px;border-radius:5px;margin:12px 0;';

    echo '<div style="' . htmlspecialchars($containerStyle, ENT_QUOTES, 'UTF-8') . '">';

    foreach ($vars as $i => $var) {
        $type = gettype($var);

        $meta = '';
        if (is_string($var)) {
            $meta .= "Length: " . strlen($var) . "\n";
        } elseif (is_array($var)) {
            $meta .= "Count: " . count($var) . "\n";
        } elseif (is_object($var)) {
            $meta .= "Class: " . get_class($var) . "\n";
        }

        if (is_string($var)) {
            $value = 'Value: "' . $var . '"';
        } elseif (is_bool($var)) {
            $value = 'Value: ' . ($var ? 'true' : 'false');
        } elseif (is_null($var)) {
            $value = 'Value: null';
        } else {
            $value = "Value:\n" . print_r($var, true);
        }

        $out  = "Var #" . ($i + 1) . "\n";
        $out .= "Type: " . $type . "\n";
        $out .= $meta;
        $out .= $value . "\n";

        echo '<pre style="' . htmlspecialchars($blockStyle, ENT_QUOTES, 'UTF-8') . '">'
            . htmlspecialchars($out, ENT_QUOTES, 'UTF-8')
            . '</pre>';
    }

    echo '</div>';
    die();
}
