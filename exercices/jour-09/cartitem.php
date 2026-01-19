<?php

// Classe Product

class Product
{
    public string $name;
    public float $price;

    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

// Classe CartItem
class CartItem
{
    public Product $product;
    public int $quantite;

    public function __construct(Product $product, int $quantite)
    {
        $this->product = $product;
        $this->quantite = $quantite;
    }

    // Prix total de cette ligne du panier
    public function getTotal(): float
    {
        return $this->product->price * $this->quantite;
    }

    // Ajoute 1 a la quantite
    public function incremente(): void
    {
        $this->quantite++;
    }

    // Enleve 1 a la quantite sans passer en negatif
    public function decremente(): void
    {
        if ($this->quantite > 0) {
            $this->quantite--;
        }
    }
}

$spaceMarine = new Product("Space Marine", 29.99);
$ork = new Product("Ork", 19.99);

$item1 = new CartItem($spaceMarine, 2);
$item2 = new CartItem($ork, 5);

echo "<h2>Panier</h2>";

echo $item1->product->name . " x " . $item1->quantite . " = " . $item1->getTotal() . " €<br>";
echo $item2->product->name . " x " . $item2->quantite . " = " . $item2->getTotal() . " €<br>";

echo "<hr>";

// On modifie les quantites
$item1->incremente();   // 2 -> 3
$item2->decremente();   // 5 -> 4

echo "<h2>Apres modification</h2>";

echo $item1->product->name . " x " . $item1->quantite . " = " . $item1->getTotal() . " €<br>";
echo $item2->product->name . " x " . $item2->quantite . " = " . $item2->getTotal() . " €<br>";
