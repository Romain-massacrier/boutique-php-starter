<?php
// Tableau contenant la liste de prénoms
$firstNames = [
    "Pierre",
    "Loic",
    "Stephane",
    "Julie",
    "Abigaelle"
];

// Compteur pour numéroter les éléments du tableau
$i = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foreach simple</title>
</head>
<body>

<ul>
    <?php
    // Boucle foreach, qui parcourt les éléments du tableau $firstNames
    // a chaque tour, la valeur se trouve stocké dans $name
    foreach ($firstNames as $name):
    ?>
        <li>
            <!-- Affiche le numéro puis le prénom -->
            <?= $i ?> <?= $name ?>
        </li>

        <?php
        // Incrémente le compteur après chaque prénom
        $i++;
        ?>
    <?php
    // Fin de la boucle foreach
    endforeach;
    ?>
</ul>
    
</body>
</html>
