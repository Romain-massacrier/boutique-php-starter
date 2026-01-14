<?php
declare(strict_types=1);

// starter-project/app/init_db.php

require_once __DIR__ . "/../config/database.php";

$pdo = db();

// 1) Créer la table
$pdo->exec("
CREATE TABLE IF NOT EXISTS products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT NOT NULL DEFAULT 0,
    is_new TINYINT(1) NOT NULL DEFAULT 0,
    discount INT NOT NULL DEFAULT 0,
    image TEXT NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// 2) Vider la table
$pdo->exec("TRUNCATE TABLE products;");

// 3) Données
$data = [
    [
        "name" => "Famicom",
        "price" => 39.99,
        "stock" => 12,
        "is_new" => 1,
        "discount" => 10,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Nintendo-Famicom-Console-Set-FL.png/330px-Nintendo-Famicom-Console-Set-FL.png",
        "description" => "La console mythique de Nintendo qui a marqué le début du jeu vidéo familial."
    ],
    [
        "name" => "Super Famicom Jr",
        "price" => 139.99,
        "stock" => 52,
        "is_new" => 0,
        "discount" => 0,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/e/e3/SuperFamicom_jr.jpg",
        "description" => "Version compacte de la Super Famicom offrant des classiques 16 bits inoubliables."
    ],
    [
        "name" => "PC Engine",
        "price" => 99.99,
        "stock" => 4,
        "is_new" => 0,
        "discount" => 0,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/5/5a/PC_Engine.jpg",
        "description" => "Console culte au design minimaliste, célèbre pour ses jeux arcade de qualité."
    ],
    [
        "name" => "Neo Geo AES",
        "price" => 499.99,
        "stock" => 0,
        "is_new" => 1,
        "discount" => 0,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/5/59/Neogeoaes.jpg",
        "description" => "La console de luxe des années 90, identique aux bornes d’arcade SNK."
    ],
    [
        "name" => "Playdia",
        "price" => 119.99,
        "stock" => 1,
        "is_new" => 0,
        "discount" => 0,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/7/74/Playdia-Console-Set.png/2560px-Playdia-Console-Set.png",
        "description" => "Console atypique de Bandai orientée jeux interactifs et multimédia."
    ],
    [
        "name" => "Twin Famicom",
        "price" => 99.99,
        "stock" => 9,
        "is_new" => 1,
        "discount" => 0,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Sharp-Twin-Famicom-Console.png/2560px-Sharp-Twin-Famicom-Console.png",
        "description" => "Console hybride combinant cartouches et disquettes Famicom."
    ],
    [
        "name" => "Megadrive",
        "price" => 69.99,
        "stock" => 26,
        "is_new" => 0,
        "discount" => 0,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Sega-Mega-Drive-EU-Mk1-wController-FL.png/2560px-Sega-Mega-Drive-EU-Mk1-wController-FL.png",
        "description" => "La console emblématique de SEGA, connue pour sa vitesse et ses jeux d’action."
    ],
    [
        "name" => "Nintendo 64",
        "price" => 89.99,
        "stock" => 15,
        "is_new" => 1,
        "discount" => 0,
        "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/N64-Console-Set.png/2560px-N64-Console-Set.png",
        "description" => "Console révolutionnaire qui a popularisé la 3D dans les jeux vidéo."
    ],
];

// 4) Insertion
$stmt = $pdo->prepare("
    INSERT INTO products (name, price, stock, is_new, discount, image, description)
    VALUES (:name, :price, :stock, :is_new, :discount, :image, :description)
");

foreach ($data as $p) {
    $stmt->execute($p);
}

echo "<h2>Base initialisée</h2>";
echo "<p>" . count($data) . " produits insérés dans la table <strong>products</strong>.</p>";
