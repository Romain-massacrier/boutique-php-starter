<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

try {
    // Connexion sans dbname (important pour pouvoir CREATE DATABASE)
    $pdo = new PDO(
        "mysql:host=localhost;charset=utf8mb4",
        "dev",   // ou "root"
        "dev",   // ou ""
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // 1) Créer la base
    $pdo->exec("
        CREATE DATABASE IF NOT EXISTS boutique
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci
    ");

    // 2) Utiliser la base
    $pdo->exec("USE boutique");

    // 3) Créer la table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            stock INT DEFAULT 0,
            category VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // 4) Insérer des données seulement si la table est vide
    $count = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    if ($count === 0) {
        $pdo->exec("
            INSERT INTO products (name, description, price, stock, category) VALUES
            ('T-shirt Blanc', 'T-shirt 100% coton', 29.99, 50, 'Vêtements'),
            ('Jean Slim', 'Jean stretch confortable', 79.99, 30, 'Vêtements'),
            ('Casquette NY', 'Casquette brodée', 19.99, 100, 'Accessoires'),
            ('Baskets Sport', 'Chaussures de running', 89.99, 25, 'Chaussures'),
            ('Sac à dos', 'Sac 20L étanche', 49.99, 15, 'Accessoires')
        ");
    }

    echo "✅ Setup OK: base + table + données prêtes.";

} catch (PDOException $e) {
    echo "❌ Setup KO: " . $e->getMessage();
}
