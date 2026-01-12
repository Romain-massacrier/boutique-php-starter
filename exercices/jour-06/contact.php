<?php

// création formulaire de contact avec les champs : nom, email, message
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupérer les données du formulaire

    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $message = $_POST["message"] ?? "";

    // Validation tous les chames requis, email, valide, message minimum 10 caractères
    $errors = [];

    if (empty($name)) {
        $errors[] = "Le nom est requis.";
    }

    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }

    if (empty($message)) {
        $errors[] = "Le message est requis.";
    } elseif (strlen($message) < 10) {
        $errors[] = "Le message doit contenir au moins 10 caractères.";
    }

    // Si pas d'erreurs, afficher un message de succès
    if (empty($errors)) {
        echo "Merci " . htmlspecialchars($name) . ", votre message a été envoyé avec succès.";
    } else {
        // Afficher les erreurs
        foreach ($errors as $error) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
        ?>
        <form method="POST" action="">
            <label for="name">Nom :</label><br>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"><br><br>
            <label for="email">Email :</label><br>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br><br>
            <label for="message">Message :</label><br>
            <textarea id="message" name="message"><?php echo htmlspecialchars($message); ?></textarea><br><br>
            <input type="submit" value="Envoyer">
        </form>
        <?php
    }
} else {
    // Afficher le formulaire vide
    ?>
    <form method="POST" action="">
        <label for="name">Nom :</label><br>
        <input type="text" id="name" name="name"><br><br>
        <label for="email">Email :</label><br>
        <input type="text" id="email" name="email"><br><br>
        <label for="message">Message :</label><br>
        <textarea id="message" name="message"></textarea><br><br>
        <input type="submit" value="Envoyer">
    </form>
    <?php
}   