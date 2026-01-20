<?php

// Inclusion du fichier contenant la classe CartItem
require_once 'cartitem.php';

// Déclaration de la classe Cart (panier)
class Cart
{
    // Tableau public contenant les items du panier (objets CartItem)
    public array $items = [];

    // Ajouter un produit au panier
    public function add(Product $product, int $quantity = 1): void
    {
        // Parcours des items déjà présents dans le panier
        foreach ($this->items as $item) {

            // Si le produit existe déjà dans le panier
            // on compare les noms des produits
            if ($item->product->name === $product->name) {

                // On augmente simplement la quantité
                $item->quantite += $quantity;

                // On quitte la méthode
                return;
            }
        }

        // Si le produit n'existe pas encore dans le panier
        // on crée un nouvel objet CartItem
        $this->items[] = new CartItem($product, $quantity);
    }

    // Retirer complètement un produit du panier
    public function remove(Product $product): void
    {
        // Parcours du panier avec l'index
        foreach ($this->items as $index => $item) {

            // Si le produit correspond
            if ($item->product->name === $product->name) {

                // Suppression de l'élément du tableau
                unset($this->items[$index]);

                // Réindexation du tableau pour éviter les "trous"
                $this->items = array_values($this->items);

                // On quitte la méthode
                return;
            }
        }
    }

    // Mettre à jour la quantité d'un produit
    public function update(Product $product, int $quantity): void
    {
        // Parcours des items du panier
        foreach ($this->items as $item) {

            // Si le produit est trouvé
            if ($item->product->name === $product->name) {

                // Mise à jour de la quantité
                $item->quantite = $quantity;

                // On quitte la méthode
                return;
            }
        }
    }

    // Calculer le total du panier
    public function getTotal(): float
    {
        // Variable pour stocker le total
        $total = 0.0;

        // Parcours de chaque item du panier
        foreach ($this->items as $item) {

            // Ajout du total de chaque CartItem
            $total += $item->getTotal();
        }

        // Retourne le total final
        return $total;
    }

    // Compter le nombre d'items différents dans le panier
    public function count(): int
    {
        return count($this->items);
    }

    // Vider complètement le panier
    public function clear(): void
    {
        $this->items = [];
    }
}

// TEST DU PANIER

// Création du panier
$cart = new Cart();

// Création des produits
$spaceMarine = new Product("Space Marine", 29.99);
$ork = new Product("Ork", 19.99);

// Ajout des produits au panier
$cart->add($spaceMarine, 2);
$cart->add($ork, 5);

// Affichage du panier
echo "<h2>Panier</h2>";
foreach ($cart->items as $item) {
    echo $item->product->name . " x " . $item->quantite . " = "
        . $item->getTotal() . " €<br>";
}

// Affichage du total et du nombre d'articles
echo "Total du panier: " . $cart->getTotal() . " €<br>";
echo "Nombre d'articles dans le panier: " . $cart->count() . "<br>";

// Mise à jour de la quantité d'un produit
$cart->update($ork, 3);

// Affichage après mise à jour
echo "<h2>Panier après mise à jour</h2>";
foreach ($cart->items as $item) {
    echo $item->product->name . " x " . $item->quantite . " = "
        . $item->getTotal() . " €<br>";
}
echo "Total du panier: " . $cart->getTotal() . " €<br>";

// Suppression d'un produit
$cart->remove($spaceMarine);

// Affichage après suppression
echo "<h2>Panier après suppression</h2>";
foreach ($cart->items as $item) {
    echo $item->product->name . " x " . $item->quantite . " = "
        . $item->getTotal() . " €<br>";
}
echo "Total du panier: " . $cart->getTotal() . " €<br>";

// Vidage du panier
$cart->clear();

// Affichage après vidage
echo "<h2>Panier après vidage</h2>";
echo "Nombre d'articles dans le panier: " . $cart->count() . "<br>";
?>