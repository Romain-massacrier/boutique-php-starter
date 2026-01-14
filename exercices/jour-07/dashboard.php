<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

<h1>Bienvenue <?php echo $_SESSION["user"]; ?> 👋</p>

<a href="logout.php">Se déconnecter</a>
    
</body>
</html>