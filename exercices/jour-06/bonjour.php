<?php

// Récupérer le paramètre "name" depuis l'URL
$name = $_GET["name"] ?? null;

// Récupérer le paramètre "age" depuis l'URL
$age = $_GET["age"] ?? null;

// Si aucun nom n'est fourni, on met "visiteur"
if ($name === null || $name === "") {
    echo "Bonjour visiteur !";
} else {

    // Si l'âge est fourni
    if ($age !== null && $age !== "") {
        echo "Bonjour " . htmlspecialchars($name) . ", vous avez " . (int)$age . " ans !";
    } else {
        echo "Bonjour " . htmlspecialchars($name) . " !";
    }
}
