<?php

// tabealu de 10 produits, formulaire get avec champ recherche, filtrer les produits contenant la recherche, afficher les résultats ou aucun résultat

$products = [
    ["name" => "Ordinateur portable"],
    ["name" => "Smartphone"],
    ["name" => "Tablette"],
    ["name" => "Casque audio"],
    ["name" => "Montre connectée"],
    ["name" => "Clé USB"],
    ["name" => "Imprimante"],
    ["name" => "Souris sans fil"],
    ["name" => "Clavier mécanique"],
    ["name" => "Écran 4K"],
];
$search = $_GET["search"] ?? "";
$results = [];
if ($search !== "") {
    foreach ($products as $product) {
        if (stripos($product["name"], $search) !== false) {
            $results[] = $product;
        }
    }
}
?>
<form method="GET" action="">
    <label for="search">Rechercher un produit :</label><br>
    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>"><br><br>
    <input type="submit" value="Rechercher">
</form>
<?php
if ($search !== "") {
    if (count($results) > 0) {
        echo "<h2>Résultats de la recherche :</h2>";
        echo "<ul>";
        foreach ($results as $product) {
            echo "<li>" . htmlspecialchars($product["name"]) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun produit trouvé pour la recherche \"" . htmlspecialchars($search) . "\".</p>";
    }
}