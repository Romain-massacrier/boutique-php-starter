<?php
session_start();

// réinitialisation compteur

if (isset($_GET["reset"])) {
    $_SESSION["visits"] = 0;
     
}

// initialisation ou incrémentation

if (isset($_SESSION["visits"])) {
    $_SESSION["visits"]++;
} else {
    $_SESSION["visits"] = 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compteur de visite</title>
</head>
<body>
    <p>Vous avez visité cette page <?php echo $_SESSION["visits"]; ?>
    <a href="?reset=1">Réinitialiser</a>

</body>
</html>
