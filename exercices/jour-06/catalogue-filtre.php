<?php

// tableau 15 produits avec name, price, category, instock , formulaire get avec recherche par nom, filtre par catégorie (select), filtre par prix max (input number), checkbox "en stock uniquement", afficher les produits correspondants aux filtres ou message "aucun produit trouvé", checkbox "en stock uniquement", applique tous les filtres actifs, conserve les valeurs sélectionnées après soumission
$products = [
    ["name" => "Ordinateur portable", "price" => 799.99, "category" => "Électronique", "instock" => true],
    ["name" => "Smartphone", "price" => 499.99, "category" => "Électronique", "instock" => false],
    ["name" => "Tablette", "price" => 299.99, "category" => "Électronique", "instock" => true],
    ["name" => "Casque audio", "price" => 99.99, "category" => "Accessoires", "instock" => true],
    ["name" => "Montre connectée", "price" => 199.99, "category" => "Accessoires", "instock" => false],
    ["name" => "Clé USB", "price" => 19.99, "category" => "Accessoires", "instock" => true],
    ["name" => "Imprimante", "price" => 149.99, "category" => "Électronique", "instock" => true],
    ["name" => "Souris sans fil", "price" => 29.99, "category" => "Accessoires", "instock" => true],
    ["name" => "Clavier mécanique", "price" => 89.99, "category" => "Accessoires", "instock" => false],
    ["name" => "Écran 4K", "price" => 399.99, "category" => "Électronique", "instock" => true],
    ["name" => "Haut-parleur Bluetooth", "price" => 59.99, "category" => "Accessoires", "instock" => true],
    ["name" => "Caméra de sécurité", "price" => 129.99, "category" => "Électronique", "instock" => false],
    ["name" => "Routeur Wi-Fi", "price" => 79.99, "category" => "Électronique", "instock" => true],
    ["name" => "Disque dur externe", "price" => 109.99, "category" => "Accessoires", "instock" => true],
    ["name" => "Webcam HD", "price" => 49.99, "category" => "Accessoires", "instock" => false],
];
$search = $_GET["search"] ?? "";
$category = $_GET["category"] ?? "";
$max_price = $_GET["max_price"] ?? "";
$in_stock = isset($_GET["in_stock"]) ? true : false;
$results = [];
foreach ($products as $product) {
    if ($search !== "" && stripos($product["name"], $search) === false) {
        continue;
    }
    if ($category !== "" && $product["category"] !== $category) {
        continue;
    }
    if ($max_price !== "" && $product["price"] > (float)$max_price) {
        continue;
    }
    if ($in_stock && !$product["instock"]) {
        continue;
    }
    $results[] = $product;
}
$categories = array_unique(array_map(function ($product) {
    return $product["category"];
}, $products));
?>
<form method="GET" action="">
    <label for="search">Rechercher un produit :</label><br>
    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>"><br><br>
    <label for="category">Catégorie :</label><br>
    <select id="category" name="category">
        <option value="">Toutes</option>
        <?php foreach ($categories as $cat) : ?>
            <option value="<?php echo htmlspecialchars($cat); ?>" <?php if ($cat === $category) echo "selected"; ?>><?php echo htmlspecialchars($cat); ?></option>
        <?php endforeach; ?>
    </select><br><br>
    <label for="max_price">Prix maximum :</label><br>
    <input type="number" step="0.01" id="max_price" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>"><br><br>
    <label for="in_stock">
        <input type="checkbox" id="in_stock" name="in_stock" <?php if ($in_stock) echo "checked"; ?>>
        En stock uniquement
    </label><br><br>
    <input type="submit" value="Filtrer">
</form>
<?php
if (count($results) > 0) {
    echo "<h2>Produits trouvés :</h2>";
    echo "<ul>";
    foreach ($results as $product) {
        echo "<li>" . htmlspecialchars($product["name"]) . " - " . number_format($product["price"], 2) . " € - " . htmlspecialchars($product["category"]);
        echo $product["instock"] ? " (En stock)" : " (Rupture de stock)";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Aucun produit trouvé correspondant aux critères.</p>";
}