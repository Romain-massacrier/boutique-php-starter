<?php

$products = [
    ["name" => "T-shirt Adeptus Mechanicus",
        "price" => 24.90,
        "stock" => 18,
    ],
    [
        "name" => "Mug Terra Bolter",
        "price" => 12.50,
        "stock" => 0,
    ],
    [
        "name" => "Casquette Imperium",
        "price" => 19.99,
        "stock" => 42,
    ],
    [
        "name" => "Poster Codex Astartes",
        "price" => 9.90,
        "stock" => 7,
    ],
    [
        "name" => "Clavier Mécanique MK-III",
        "price" => 89.00,
        "stock" => 5,
    ],
    [
        "name" => "Tapis de souris Nécron",
        "price" => 14.90,
        "stock" => 31,
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php foreach ($products as $product): ?>
<article>
    <h3><?= $product["name"] ?></h3>
    <p class="prix"><?=number_format($product["price"], 2, ".", "") ?> €</p>
    <p class="stock">Stock : <?= $product["stock"] ?></p>
</article>
<?php endforeach; ?>
    
</body>
</html>