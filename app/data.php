<?php
// starter-project/app/data.php

use App\Entity\Product;

// Consoles en objets Product
$products = [
    new Product(
        1,
        "Famicom",
        39.99,
        12,
        true,
        10,
        "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Nintendo-Famicom-Console-Set-FL.png/330px-Nintendo-Famicom-Console-Set-FL.png",
        "La console mythique de Nintendo qui a marqué le début du jeu vidéo familial."
    ),
    new Product(
        2,
        "Super Famicom Jr",
        139.99,
        52,
        false,
        0,
        "https://upload.wikimedia.org/wikipedia/commons/e/e3/SuperFamicom_jr.jpg",
        "Version compacte de la Super Famicom offrant des classiques 16 bits inoubliables."
    ),
    new Product(
        3,
        "PC Engine",
        99.99,
        4,
        false,
        0,
        "https://upload.wikimedia.org/wikipedia/commons/5/5a/PC_Engine.jpg",
        "Console culte au design minimaliste, célèbre pour ses jeux arcade de qualité."
    ),
    new Product(
        4,
        "Neo Geo AES",
        499.99,
        0,
        true,
        0,
        "https://upload.wikimedia.org/wikipedia/commons/5/59/Neogeoaes.jpg",
        "La console de luxe des années 90, identique aux bornes d’arcade SNK."
    ),
    new Product(
        5,
        "Playdia",
        119.99,
        1,
        false,
        0,
        "https://upload.wikimedia.org/wikipedia/commons/thumb/7/74/Playdia-Console-Set.png/2560px-Playdia-Console-Set.png",
        "Console atypique de Bandai orientée jeux interactifs et multimédia."
    ),
    new Product(
        6,
        "Twin Famicom",
        99.99,
        9,
        true,
        0,
        "https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Sharp-Twin-Famicom-Console.png/2560px-Sharp-Twin-Famicom-Console.png",
        "Console hybride combinant cartouches et disquettes Famicom."
    ),
    new Product(
        7,
        "Megadrive",
        69.99,
        26,
        false,
        0,
        "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/Sega-Mega-Drive-EU-Mk1-wController-FL.png/2560px-Sega-Mega-Drive-EU-Mk1-wController-FL.png",
        "La console emblématique de SEGA, connue pour sa vitesse et ses jeux d’action."
    ),
    new Product(
        8,
        "Nintendo 64",
        89.99,
        15,
        true,
        0,
        "https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/N64-Console-Set.png/2560px-N64-Console-Set.png",
        "Console révolutionnaire qui a popularisé la 3D dans les jeux vidéo."
    ),
];

// Jeux (on les laisse en tableaux pour l’instant)
$games = [
    [
        "name" => "Super Mario Bros.",
        "price" => 29.99,
        "stock" => 34,
        "new" => true,
        "console" => "Famicom",
        "image" => "https://en.wikipedia.org/wiki/Special:FilePath/Super%20Mario%20Bros.%20box.png",
        "description" => "Le classique jeu de plateforme où Mario doit sauver la princesse Peach."
    ],
    [
        "name" => "The Legend of Zelda: Ocarina of Time",
        "price" => 49.99,
        "stock" => 12,
        "new" => false,
        "console" => "Nintendo 64",
        "image" => "https://cdn.thegamesdb.net/images/original/boxart/front/128689-1.jpg",
        "description" => "Un jeu d’aventure épique où Link doit sauver Hyrule du mal."
    ],
    [
        "name" => "Sonic the Hedgehog",
        "price" => 19.99,
        "stock" => 20,
        "new" => true,
        "console" => "Megadrive",
        "image" => "https://cdn.thegamesdb.net/images/original/boxart/front/99155-1.jpg",
        "description" => "Le jeu de plateforme rapide mettant en vedette le hérisson bleu emblématique."
    ],
    [
        "name" => "Street Fighter II",
        "price" => 39.99,
        "stock" => 8,
        "new" => false,
        "console" => "Super Famicom Jr",
        "image" => "https://cdn.thegamesdb.net/images/original/boxart/front/3122-1.jpg",
        "description" => "Le célèbre jeu de combat qui a défini le genre des jeux de combat."
    ],
    [
        "name" => "Castlevania: Symphony of the Night",
        "price" => 44.99,
        "stock" => 5,
        "new" => true,
        "console" => "Playstation 1",
        "image" => "https://cdn.thegamesdb.net/images/original/boxart/front/130812-1.jpg",
        "description" => "Un jeu d’action-aventure gothique où Alucard explore un château rempli de monstres."
    ],
    [
        "name" => "Metal Slug",
        "price" => 34.99,
        "stock" => 10,
        "new" => false,
        "console" => "Neo Geo AES",
        "image" => "https://cdn.thegamesdb.net/images/original/boxart/front/222-1.jpg",
        "description" => "Un jeu de tir à défilement horizontal connu pour son action frénétique et son humour."
    ],
    [
        "name" => "Final Fantasy VIII",
        "price" => 59.99,
        "stock" => 14,
        "new" => true,
        "console" => "Playstation 1",
        "image" => "https://cdn.thegamesdb.net/images/original/boxart/front/526-1.jpg",
        "description" => "Un RPG épique où Squall Leonhart et ses alliés affrontent une sorcière manipulant le temps et le destin du monde."
    ],
    [
        "name" => "Donkey Kong Country",
        "price" => 29.99,
        "stock" => 18,
        "new" => false,
        "console" => "Super Famicom Jr",
        "image" => "https://cdn.thegamesdb.net/images/original/boxart/front/131-1.jpg",
        "description" => "Un jeu de plateforme mettant en vedette Donkey Kong et Diddy Kong dans une aventure jungle."
    ],
    [
        "name" => "Resident Evil 2",
        "price" => 49.99,
        "stock" => 6,
        "new" => true,
        "console" => "Playstation 1",
        "image" => "https://cdn.thegamesdb.net/images/original/boxart/front/78846-1.jpg",
        "description" => "Un jeu d’horreur de survie où les joueurs affrontent des zombies dans Raccoon City."
    ],
    [
        "name" => "Mega Man 2",
        "price" => 24.99,
        "stock" => 22,
        "new" => false,
        "console" => "Famicom",
        "image" => "https://cdn.thegamesdb.net/images/original/boxart/front/104873-1.jpg",
        "description" => "Un jeu de plateforme classique où Mega Man affronte les robots du Dr. Wily."
    ],
];

// ID pour chaque jeu (on garde ca car les jeux sont encore en tableaux)
foreach ($games as $index => &$game) {
    $game["id"] = count($products) + $index + 1;
}
unset($game);
