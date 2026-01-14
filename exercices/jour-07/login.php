<?php
session_start();

$error = "";

if (isset($_POST["password"])) {
    if (
        $_POST["username"] === "admin" &&
        $_POST["password"] === "1234"
    ) {
        $_SESSION["user"] = $_POST["username"];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h1>Connexion</h1>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">
    <label>
        Username :
        <input type="text" name="username" required>
    </label>
    <br><br>

    <label>
        Password :
        <input type="password" name="password" required>
    </label>
    <br><br>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>
