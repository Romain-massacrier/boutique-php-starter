<?php
$products = [
    [
        "name" => "Famicom",
        "price" => 39.99,
        "stock" => 12,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Nintendo-Famicom-Console-Set-FL.png/330px-Nintendo-Famicom-Console-Set-FL.png",
        "description" => "La console mythique de Nintendo qui a marqué le début du jeu vidéo familial."
    ],
    [
        "name" => "Super Famicom Jr",
        "price" => 139.99,
        "stock" => 52,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/e/e3/SuperFamicom_jr.jpg",
        "description" => "Version compacte de la Super Famicom offrant des classiques 16 bits inoubliables."
    ],
    [
        "name" => "PC Engine",
        "price" => 99.99,
        "stock" => 4,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/5/5a/PC_Engine.jpg",
        "description" => "Console culte au design minimaliste, célèbre pour ses jeux arcade de qualité."
    ],
    [
        "name" => "Neo Geo AES",
        "price" => 499.99,
        "stock" => 0,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/5/59/Neogeoaes.jpg",
        "description" => "La console de luxe des années 90, identique aux bornes d’arcade SNK."
    ],
    [
        "name" => "Playdia",
        "price" => 119.99,
        "stock" => 1,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/7/74/Playdia-Console-Set.png/2560px-Playdia-Console-Set.png",
        "description" => "Console atypique de Bandai orientée jeux interactifs et multimédia."
    ],
    [
        "name" => "Twin Famicom",
        "price" => 99.99,
        "stock" => 9,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Sharp-Twin-Famicom-Console.png/2560px-Sharp-Twin-Famicom-Console.png",
        "description" => "Console hybride combinant cartouches et disquettes Famicom."
    ],
    [
        "name" => "Megadrive",
        "price" => 69.99,
        "stock" => 26,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Sega-Mega-Drive-EU-Mk1-wController-FL.png/2560px-Sega-Mega-Drive-EU-Mk1-wController-FL.png",
        "description" => "La console emblématique de SEGA, connue pour sa vitesse et ses jeux d’action."
    ],
    [
        "name" => "Nintendo 64",
        "price" => 89.99,
        "stock" => 15,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/N64-Console-Set.png/2560px-N64-Console-Set.png",
        "description" => "Console révolutionnaire qui a popularisé la 3D dans les jeux vidéo."
    ],
];
?>


<!DOCTYPE html>
<html>
<head>
    <style>
        .grille { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .produit { border: 1px solid #ddd; padding: 15px; }
        .rupture { color: red; }
        .en-stock { color: green; }
    </style>
</head>
<body>
    <div class="grille">
        <?php foreach ($products as $product): ?>
            <div class="produit">
                <h2><?= $product["name"] ?></h2>

<img src="<?= $product["image"] ?>" alt="<?= $product["name"] ?>" width="150">
 <p class="description"><?= $product["description"] ?></p>

<p>Prix : <?= number_format($product["price"], 2, ",", " ") ?> €</p>

<?php if ($product["stock"] > 0): ?>
    <p class="en-stock">En stock (<?= $product["stock"] ?>)</p>
<?php else: ?>
    <p class="rupture">Rupture de stock</p>
<?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>