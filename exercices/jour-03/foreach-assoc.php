<?php

// Tableau
$person = [
    "name" => "Romain",
    "age" => 44,
    "city" => "Valence",
    "job" => "Dev"
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
    
<h1>Informations de la personne</h1>

<ul>
    <?php 
    // On parcourt le tableau associatif $person
    // $key contient le nom de la clé (name, age, city, job)
    // $value contient la valeur associée à cette clé
    foreach ($person as $key => $value): ?>
    <!-- On affiche la clé en gras, et on affiche ensuite la valeur $value-->
        <li><strong><?= $key ?></strong> : <?= $value ?></li>
    <?php endforeach; ?>
</ul>

</body>
</html>