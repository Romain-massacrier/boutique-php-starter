<?php

$groceries = [
    "Clavier",
    "Souris",
    "Tapis de souris",
    "Disque Dur",
    "Ram",
];

echo "Premier article : " . $groceries[0] . "<br>";
echo "Dernier article : " . $groceries[count($groceries) - 1] . "<br>";
echo "Nombre total d'articles : " . count($groceries) . "<br><br>";

// array_push ajoute un ou plusieurs éléments à la fin d’un tableau
array_push($groceries, "Micro", "Casque");

// unset supprime un élément sélectioné 
unset($groceries[2]);

var_dump($groceries);
