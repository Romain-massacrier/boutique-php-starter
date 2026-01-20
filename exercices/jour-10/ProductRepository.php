<?php

// Repository responsable uniquement de l'accès aux données "Product"
class ProductRepository
{
    // Connexion PDO privée
    private PDO $pdo;

    // Injection du PDO
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // READ - un produit
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product !== false ? $product : null;
    }

    // READ - tous les produits
    public function findAll(): array
    {
        $sql = "SELECT * FROM products ORDER BY id ASC";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CREATE
    public function save(array $product): int
    {
        $sql = "INSERT INTO products (name, price) VALUES (:name, :price)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $product['name'],
            'price' => $product['price']
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    // UPDATE
    public function update(int $id, array $product): bool
    {
        $sql = "UPDATE products SET name = :name, price = :price WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $product['name'],
            'price' => $product['price']
        ]);
    }

    // DELETE
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
