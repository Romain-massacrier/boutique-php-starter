<?php

// 50 produit rétrogaming réels avec name, price, category, instock
// barre latérale avec recherche texte, filtre catégories (checkbox multiples), slider/inputs prix min-max, tri (prix croissant, décroissant, nom A-Z, Z-A), 
// pagination (10 produits par page) zone principale grille de produits filtré, compteur :" X produits trouvés"

$products = [
    ["name" => "Super Mario Bros. (NES)", "price" => 29.99, "category" => "Plateforme", "instock" => true],
    ["name" => "The Legend of Zelda (NES)", "price" => 34.99, "category" => "Aventure", "instock" => true],
    ["name" => "Sonic the Hedgehog (Sega Genesis)", "price" => 24.99, "category" => "Plateforme", "instock" => false],
    ["name" => "Street Fighter II (SNES)", "price" => 39.99, "category" => "Combat", "instock" => true],
    ["name" => "Final Fantasy VII (PS1)", "price" => 49.99, "category" => "RPG", "instock" => true],
    ["name" => "Metal Gear Solid (PS1)", "price" => 44.99, "category" => "Action", "instock" => false],
    ["name" => "Donkey Kong Country (SNES)", "price" => 27.99, "category" => "Plateforme", "instock" => true],
    ["name" => "Mega Man 2 (NES)", "price" => 22.99, "category" => "Action", "instock" => true],
    ["name" => "Castlevania III: Dracula's Curse (NES)", "price" => 31.99, "category" => "Action", "instock" => false],
    ["name" => "Chrono Trigger (SNES)", "price" => 54.99, "category" => "RPG", "instock" => true],
    ["name" => "EarthBound (SNES)", "price" => 59.99, "category" => "RPG", "instock" => true],
    ["name" => "GoldenEye 007 (N64)", "price" => 39.99, "category" => "FPS", "instock" => false],
    ["name" => "Tomb Raider (PS1)", "price" => 29.99, "category" => "Aventure", "instock" => true],
    ["name" => "Resident Evil 2 (PS1)", "price" => 34.99, "category" => "Horreur", "instock" => true],
    ["name" => "Halo: Combat Evolved (Xbox)", "price" => 44.99, "category" => "FPS", "instock" => false],
    ["name" => "F-Zero (SNES)", "price" => 24.99, "category" => "Course", "instock" => true],
    ["name" => "Mario Kart 64 (N64)", "price" => 34.99, "category" => "Course", "instock" => true],
    ["name" => "Pac-Man (Atari 2600)", "price" => 19.99, "category" => "Arcade", "instock" => true],
    ["name" => "Space Invaders (Atari 2600)", "price" => 21.99, "category" => "Arcade", "instock" => false],
    ["name" => "Duck Hunt (NES)", "price" => 14.99, "category" => "Arcade", "instock" => true],
    ["name" => "Contra (NES)", "price" => 25.99, "category" => "Action", "instock" => true],
    ["name" => "Metroid (NES)", "price" => 29.99, "category" => "Aventure", "instock" => false],
    ["name" => "Kirby's Adventure (NES)", "price" => 27.99, "category" => "Plateforme", "instock" => true],
    ["name" => "Super Metroid (SNES)", "price" => 49.99, "category" => "Aventure", "instock" => true],
    ["name" => "Banjo-Kazooie (N64)", "price" => 39.99, "category" => "Plateforme", "instock" => false],
    ["name" => "Doom (SNES)", "price" => 34.99, "category" => "FPS", "instock" => true],
    ["name" => "Wolfenstein 3D (SNES)", "price" => 29.99, "category" => "FPS", "instock" => true],
    ["name" => "The Sims (PC)", "price" => 19.99, "category" => "Simulation", "instock" => false],
    ["name" => "SimCity 2000 (PC)", "price" => 24.99, "category" => "Simulation", "instock" => true],
    ["name" => "Age of Empires II (PC)", "price" => 29.99, "category" => "Stratégie", "instock" => true],
    ["name" => "Command & Conquer (PC)", "price" => 27.99, "category" => "Stratégie", "instock" => false],
    ["name" => "Diablo II (PC)", "price" => 34.99, "category" => "RPG", "instock" => true],
    ["name" => "Baldur's Gate II (PC)", "price" => 39.99, "category" => "RPG", "instock" => true],
    ["name" => "Half-Life (PC)", "price" => 29.99, "category" => "FPS", "instock" => false],
    ["name" => "Quake II (PC)", "price" => 24.99, "category" => "FPS", "instock" => true],
    ["name" => "StarCraft (PC)", "price" => 34.99, "category" => "Stratégie", "instock" => true],
    ["name" => "Warcraft III (PC)", "price" => 39.99, "category" => "Stratégie", "instock" => false],
    ["name" => "Tony Hawk's Pro Skater (PS1)", "price" => 29.99, "category" => "Sport", "instock" => true],
    ["name" => "FIFA 98 (PS1)", "price" => 24.99, "category" => "Sport", "instock" => true],
    ["name" => "Madden NFL 2000 (PS1)", "price" => 27.99, "category" => "Sport", "instock" => false],
    ["name" => "Resident Evil (GameCube)", "price" => 34.99, "category" => "Horreur", "instock" => true],
    ["name" => "The Wind Waker (GameCube)", "price" => 44.99, "category" => "Aventure", "instock" => true],
    ["name" => "Super Smash Bros. Melee (GameCube)", "price" => 39.99, "category" => "Combat", "instock" => false],
    ["name" => "Pokémon Red (GameCube)", "price" => 39.99, "category" => "RPG", "instock" => true],
    ["name" => "Pokémon Blue (GameCube)", "price" => 39.99, "category" => "RPG", "instock" => true],
    ["name" => "Luigi's Mansion (GameCube)", "price" => 29.99, "category" => "Aventure", "instock" => false],
    ["name" => "Paper Mario (N64)", "price" => 34.99, "category" => "RPG", "instock" => true],
    ["name" => "Golden Sun (GBA)", "price" => 24.99, "category" => "RPG", "instock" => true],
    ["name" => "Advance Wars (GBA)", "price" => 19.99, "category" => "Stratégie", "instock" => false],
];
// Récupérer les filtres depuis l'URL
$search = $_GET["search"] ?? "";
$selected_categories = $_GET["categories"] ?? [];
$min_price = $_GET["min_price"] ?? "";
$max_price = $_GET["max_price"] ?? "";
$sort = $_GET["sort"] ?? "";
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$items_per_page = 10;
$results = [];
// Filtrer les produits
foreach ($products as $product) {
    if ($search !== "" && stripos($product["name"], $search) === false) {
        continue;
    }
    if (!empty($selected_categories) && !in_array($product["category"], $selected_categories)) {
        continue;
    }
    if ($min_price !== "" && $product["price"] < (float)$min_price) {
        continue;
    }
    if ($max_price !== "" && $product["price"] > (float)$max_price) {
        continue;
    }
    $results[] = $product;
}
// Trier les produits
if ($sort === "price_asc") {
    usort($results, function ($a, $b) {
        return $a["price"] <=> $b["price"];
    });
} elseif ($sort === "price_desc") {
    usort($results, function ($a, $b) {
        return $b["price"] <=> $a["price"];
    });
} elseif ($sort === "name_asc") {
    usort($results, function ($a, $b) {
        return strcmp($a["name"], $b["name"]);
    });
} elseif ($sort === "name_desc") {
    usort($results, function ($a, $b) {
        return strcmp($b["name"], $a["name"]);
    });
}
// Pagination
$total_items = count($results);
$total_pages = ceil($total_items / $items_per_page);
$start_index = ($page - 1) * $items_per_page;
$paginated_results = array_slice($results, $start_index, $items_per_page);
// Récupérer toutes les catégories uniques pour les filtres
$all_categories = array_unique(array_map(function ($product) {
    return $product["category"];
}, $products));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue Rétrogaming</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { display: flex; }
        .sidebar { width: 250px; padding: 20px; border-right: 1px solid #ccc; }
        .main { flex-grow: 1; padding: 20px; }
        .product { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
        .pagination a { margin: 0 5px; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <form method="GET" action="">
            <h3>Recherche</h3>
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>"><br><br>
            <h3>Catégories</h3>
            <?php foreach ($all_categories as $category) : ?>
                <label>
                    <input type="checkbox" name="categories[]" value="<?php echo htmlspecialchars($category); ?>" <?php if (in_array($category, $selected_categories)) echo "checked"; ?>>
                    <?php echo htmlspecialchars($category); ?>
                </label><br>
            <?php endforeach; ?>
            <br>
            <h3>Prix</h3>
            Min: <input type="number" step="0.01" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>"><br>
            Max: <input type="number" step="0.01" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>"><br><br>
            <h3>Trier par</h3>
            <select name="sort">
                <option value="">-- Aucun --</option>
                <option value="price_asc" <?php if ($sort === "price_asc") echo "selected"; ?>>Prix croissant</option>
                <option value="price_desc" <?php if ($sort === "price_desc") echo "selected"; ?>>Prix décroissant</option>
                <option value="name_asc" <?php if ($sort === "name_asc") echo "selected"; ?>>Nom A-Z</option>
                <option value="name_desc"   <?php if ($sort === "name_desc") echo "selected"; ?>>Nom Z-A</option>
            </select><br><br>
            <input type="submit" value="Appliquer les filtres">
        </form>
    </div>
    <div class="main">
        <h2>Catalogue Rétrogaming</h2>
        <p><?php echo $total_items; ?> produit(s) trouvé(s)</p>
        <?php foreach ($paginated_results as $product) : ?>
            <div class="product">
                <strong><?php echo htmlspecialchars($product["name"]); ?></strong><br>
                Prix: <?php echo number_format($product["price"], 2); ?> €<br>
                Catégorie: <?php echo htmlspecialchars($product["category"]); ?><br>
                <?php echo $product["instock"] ? "<span style='color:green;'>En stock</span>" : "<span style='color:red;'>Rupture de stock</span>"; ?>
            </div>
        <?php endforeach; ?>
        <div class="pagination">
  <?php for ($p = 1; $p <= $total_pages; $p++): ?>
    <?php
      $params = $_GET;
      $params["page"] = $p;
      $href = "?" . http_build_query($params);
      $style = ($p === $page) ? "font-weight:bold;" : "";
    ?>
    <a href="<?php echo htmlspecialchars($href); ?>" style="<?php echo $style; ?>">
      <?php echo $p; ?>
    </a>
  <?php endfor; ?>
</div>
    </div>
</div>
</body>
</html>