<?php
$product = [
    "name" => "Casque Titus Warhammer 40k",
    "description" => "Enfile le casque de Titus des Ultra Marines et ressent la volonté de l'Empereur",
    "images" => ["https://www.france-figurines.fr/118020-medium_default/replique-casque-ultramarines-lieutenant-titus-warhammer-40000-space-marine-2-joy-toy.jpg", "https://www.france-figurines.fr/118019-medium_default/replique-casque-ultramarines-lieutenant-titus-warhammer-40000-space-marine-2-joy-toy.jpg", "https://www.france-figurines.fr/118023-medium_default/replique-casque-ultramarines-lieutenant-titus-warhammer-40000-space-marine-2-joy-toy.jpg"],
    "sizes" => ["S", "M", "L", "XL"],
    "price" => 209.99,
    "reviews" => [
        ["author" => "Ayoub", "rating" => 5, "comment" => "J'ai l'impression que la puissance coule en moi"],
        ["author" => "Dylan", "rating" => 5, "comment" => "La classe à Dallas"],
    ]
];

// Affiche la 2eme image
echo '<p>2eme image :</p>';
echo '<img src="' . $product["images"][1] . '" alt="Casque Titus" width="300">';


// Affiche Le nombre de tailles disponibles, "count compte le nombre d’éléments dans un tableau"
echo "Taille disponible : " . count($product["sizes"]) . "<br>";

// Affiche La note du premier avis
echo "Note du 1er avis : " . $product["reviews"][0]["rating"] . "<br>";