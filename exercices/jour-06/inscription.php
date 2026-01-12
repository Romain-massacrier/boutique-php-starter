<?php

// formulaire d'inscription avec validation, username, email, password, confirm password
// validation username 3-20 caractères, alphanumérique, email valide, password minimum 8 caractères, confirm password identique au password
// afficher les erreurs 
// préremplir les champs en cas d'erreur

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupérer les données du formulaire

    $username = $_POST["username"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    // Validation des champs

    $errors = [];

    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est requis.";
    } elseif (!preg_match("/^[a-zA-Z0-9]{3,20}$/", $username)) {
        $errors[] = "Le nom d'utilisateur doit contenir entre 3 et 20 caractères alphanumériques.";
    }

    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }

    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Si pas d'erreurs, afficher un message de succès

    if (empty($errors)) {
        echo "Inscription réussie pour " . htmlspecialchars($username) . " !";
    } else {

        // Afficher les erreurs

        foreach ($errors as $error) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
        ?>
        <form method="POST" action="">
            <label for="username">Nom d'utilisateur :</label><br>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>"><br><br>
            <label for="email">Email :</label><br>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br><br>
            <label for="password">Mot de passe :</label><br>
            <input type="password" id="password" name="password"><br><br>
            <label for="confirm_password">Confirmer le mot de passe :</label><br>
            <input type="password" id="confirm_password" name="confirm_password"><br><br>
            <input type="submit" value="S'inscrire">
        </form>
        <?php
    }
} else {

    // Afficher le formulaire vide
    
    ?>
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label><br>
        <input type="text" id="username" name="username"><br><br>
        <label for="email">Email :</label><br>
        <input type="text" id="email" name="email"><br><br>
        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password"><br><br>
        <label for="confirm_password">Confirmer le mot de passe :</label><br>
        <input type="password" id="confirm_password" name="confirm_password"><br><br>
        <input type="submit" value="S'inscrire">
    </form>
    <?php
}
