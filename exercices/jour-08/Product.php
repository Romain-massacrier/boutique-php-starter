<?php

class Product
{
    public int $id;
    public string $nom;
    public string $description;
    public float $prix;
    public int $stock;
    public string $categorie;

    public function __construct(
        int $id,
        string $nom,
        string $description,
        float $prix,
        int $stock,
        string $categorie
    ) {
        if ($id <= 0) {
            throw new InvalidArgumentException("L'id doit etre supérieur a 0");
        }
        if ($prix < 0) {
            throw new InvalidArgumentException("Le prix ne peut pas etre négatif");
        }
        if ($stock < 0) {
            throw new InvalidArgumentException("Le stock ne peut pas etre négatif");
        }

        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->stock = $stock;
        $this->categorie = $categorie;
    }

    public function getPriceIncludingTax(float $vat = 20): float
    {
        if ($vat < 0) {
            throw new InvalidArgumentException("La TVA ne peut pas etre négative");
        }

        return $this->prix * (1 + ($vat / 100));
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function reduceStock(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("La quantité doit etre supérieure a 0");
        }

        if ($quantity > $this->stock) {
            throw new RuntimeException("Stock insuffisant");
        }

        $this->stock -= $quantity;
    }

    public function applyDiscount(float $percentage): void
    {
        if ($percentage < 0 || $percentage > 100) {
            throw new InvalidArgumentException("Le pourcentage doit etre entre 0 et 100");
        }

        $this->prix = $this->prix * (1 - ($percentage / 100));
    }
}

