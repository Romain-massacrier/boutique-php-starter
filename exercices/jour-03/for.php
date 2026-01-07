<?php
// exercices/jour-03/for.php
// Ce fichier sert à s'entraîner avec la boucle for en PHP
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boucles for - Exercices</title>
</head>
<body>

<h2>Nombres de 1 à 10</h2>
<?php
// On démarre à 1, si $i inf ou égal à 10 on ajoute 1 a chaque tour de boucle
for ($i = 1; $i <= 10; $i++) {
    // Affiche le nombre courant
    echo $i . "<br>";
}
?>

<h2>Nombres pairs de 2 à 20</h2>
<?php
// On commence à 2 et on arrète à 20, on avant de 2 pour garder les nombres pairs
for ($i = 2; $i <= 20; $i += 2) {
    // Affiche le nombre pair
    echo $i . "<br>";
}
?>

<h2>Compte à rebours de 10 à 0</h2>
<?php
// On démarre à 10, tant que $i est sup ou égal à 0, on retire 1 a chaque tour
for ($i = 10; $i >= 0; $i--) {
    // Affiche le nombre courant
    echo $i . "<br>";
}
?>

<h2>Table de multiplication du 7</h2>
<?php
// Nombre de la table de multiplication
$number = 7;

// La boucle va de 1 à 10
for ($i = 1; $i <= 10; $i++) {
    // Calcul du résultat
    $result = $number * $i;

    // Affichela ligne de multiplication
    echo $number . " x " . $i . " = " . $result . "<br>";
}
?>

</body>
</html>
