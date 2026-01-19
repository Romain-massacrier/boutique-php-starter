<?php

require_once 'cartitem.php';
class Cart
{
    public array $items = []; // Tableau pour stocker les CartItem

    // Ajouter un produit au panier
    public function add(Product $product, int $quantity = 1): void
    {
        foreach ($this->items as $item) {
            if ($item->product->name === $product->name) {
                $item->quantite += $quantity;
                return;
            }
        }
        $this->items[] = new CartItem($product, $quantity);
    }

    // Retirer un produit du panier
    public function remove(Product $product): void
    {
        foreach ($this->items as $index => $item) {
            if ($item->product->name === $product->name) {
                unset($this->items[$index]);
                $this->items = array_values($this->items); // Réindexer le tableau
                return;
            }
        }
    }

    // Mettre à jour la quantité d'un produit
    public function update(Product $product, int $quantity): void
    {
        foreach ($this->items as $item) {
            if ($item->product->name === $product->name) {
                $item->quantite = $quantity;
                return;
            }
        }
    }

    // Obtenir le total du panier
    public function getTotal(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    // Compter le nombre d'articles dans le panier
    public function count(): int
    {
        return count($this->items);
    }

    // Vider le panier
    public function clear(): void
    {
        $this->items = [];
    }
}
$cart = new Cart();
$spaceMarine = new Product("Space Marine", 29.99);
$ork = new Product("Ork", 19.99);
$cart->add($spaceMarine, 2);
$cart->add($ork, 5);
echo "<h2>Panier</h2>";
foreach ($cart->items as $item) {
    echo $item->product->name . " x " . $item->quantite . " = " . $item->getTotal() . " €<br>";
}
echo "Total du panier: " . $cart->getTotal() . " €<br>";
echo "Nombre d'articles dans le panier: " . $cart->count() . "<br>";
$cart->update($ork, 3);
echo "<h2>Panier après mise à jour</h2>";
foreach ($cart->items as $item) {
    echo $item->product->name . " x " . $item->quantite . " = " . $item->getTotal() . " €<br>";
}
echo "Total du panier: " . $cart->getTotal() . " €<br>";
$cart->remove($spaceMarine);
echo "<h2>Panier après suppression</h2>";
foreach ($cart->items as $item) {
    echo $item->product->name . " x " . $item->quantite . " = " . $item->getTotal() . " €<br>";
}
echo "Total du panier: " . $cart->getTotal() . " €<br>";
$cart->clear();
echo "<h2>Panier après vidage</h2>";
echo "Nombre d'articles dans le panier: " . $cart->count() . "<br>";
?>  
