<?php
$clothes = ["T-shirt", "Jean", "Pull"];
$accessories = ["Ceinture", "Montre", "Lunettes"];

$catalog = array_merge($clothes, $accessories);

echo "Nombre total de produits : " . count($catalog) . "<br>";

array_unshift($catalog, "Veste");

echo "<pre>";
print_r($catalog);
echo "</pre>";
