<?php
declare(strict_types=1);

// starter-project/config/database.php

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = "localhost";
    $db   = "maboutique";
    $user = "dev";     // ou "root"
    $pass = "dev";     // ou "" si root sans mdp
    $charset = "utf8mb4";

    $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}
