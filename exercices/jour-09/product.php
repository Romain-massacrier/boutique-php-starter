<?php

use Product as GlobalProduct;

class Category
{
    public int $id; // Propriété publique id qui doit être un entier
    public string $name; // Propriété publique name qui doit être une chaîne de caractères

    public function __construct(int $id, string $name) // Constructeur, appelé quand on crée une nouvelle catégorie
    {
        $this->id = $id; // On stocke la valeur reçue dans la propriété id
        $this->name = $name; // On stocke la valeur reçue dans la propriété name
    }
}

class Product // Déclare une classe Product

{
    public int $id; // Identifiant du produit
    public string $name; // Nom du produit
    public float $price; // Prix du produit
    public Category $category; // Catégorie du produit, qui doit être un objet Category

    public function __construct(int $id, string $name, float $price, Category $category) // Constructeur du produit
    {
        $this->id = $id; // Stocke l'id du produit
        $this->name = $name; // Stocke le nom du produit
        $this->price = $price; // Stocke le prix
        $this->category = $category; // Stocke la catégorie (objet Category)
    }

    public function display(): string // Méthode qui retourne une chaîne pour afficher le produit
    {
        return $this->name . "(" . $this->category->name .")" . $this->price . "€"; // retourne en phrase avec nom produit, nom catégorie et le prix
    }
}
// création catégorie
$cat1 = new Category(1, "Figurines");
$cat2 = new Category(2, "Véhicules");
$cat3 = new Category(3, "Livres");

// création produits
$p1 = new Product(1, "Space Marine", 29.99, $cat1);
$p2 = new Product(2, "Ork Boy", 24.99, $cat1);
$p3 = new product(3, "Tank Imperial", 79.99, $cat2);
$p4 = new Product(4, "Codex Space Marines", 39.99, $cat3);
$p5 = new Product(5, "Codex Chaos", 34.99, $cat3);

// Met tous les produits dans un tableau
$products = [$p1, $p2, $p3, $p4, $p5];

echo "<h2>Liste des produits</h2>";
echo "<ul>";

// Parcourt chaque produit du tableau
foreach ($products as $product) {
    echo "<li>" . $product->display() . "</li>"; // Affiche chaque produit sous forme de ligne HTML en utilisant display()
}
echo "</ul>";
