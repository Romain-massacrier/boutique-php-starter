<?php


class Product
{
    // Identifiant unique du produit
    private int $id;

    // Nom du produit
    private string $name;

    // Prix unitaire du produit
    private float $price;

    // Constructeur appelé à la création de l'objet Product
    public function __construct(int $id, string $name, float $price)
    {
        // Initialisation des propriétés
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    // Retourne l'id du produit (utilisé comme clé dans le panier)
    public function getId(): int
    {
        return $this->id;
    }

    // Retourne le prix du produit
    public function getPrice(): float
    {
        return $this->price;
    }
}

class CartItem
{
    // Produit associé à la ligne du panier
    private Product $product;

    // Quantité de ce produit
    private int $quantity;

    // Constructeur du CartItem
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    // Augmente la quantité existante
    public function increaseQuantity(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    // Calcule le total de la ligne (prix x quantité)
    public function getTotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }

    // Retourne la quantité
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}

class Cart
{
    /**
     * Tableau d'objets CartItem
     * La clé du tableau est l'id du produit
     * @var CartItem[]
     */
    private array $items = [];

    // Ajoute un produit au panier (ou augmente la quantité)
    // Retourne $this pour permettre le chaînage
    public function add(Product $product, int $quantity = 1): self
    {
        // Récupère l'id du produit
        $productId = $product->getId();

        // Si le produit existe déjà dans le panier
        if (isset($this->items[$productId])) {
            // On augmente simplement la quantité
            $this->items[$productId]->increaseQuantity($quantity);
        } else {
            // Sinon on crée une nouvelle ligne de panier
            $this->items[$productId] = new CartItem($product, $quantity);
        }

        // Indispensable pour le fluent interface
        return $this;
    }

    // Supprime un produit du panier par son id
    // Retourne $this pour le chaînage
    public function remove(int $productId): self
    {
        // Supprime l'élément du tableau s'il existe
        unset($this->items[$productId]);

        return $this;
    }

    // Calcule le total du panier
    public function getTotal(): float
    {
        $total = 0;

        // Additionne le total de chaque ligne
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    // Compte le nombre total d'articles (toutes quantités confondues)
    public function getItemCount(): int
    {
        $count = 0;

        foreach ($this->items as $item) {
            $count += $item->getQuantity();
        }

        return $count;
    }
}


// Création de deux produits
$product1 = new Product(1, "Clavier", 50);
$product2 = new Product(2, "Souris", 30);

// Création du panier
$cart = new Cart();

// Chaînage des méthodes grâce au fluent interface
$cart->add($product1)        // ajoute 1 clavier
     ->add($product2, 3)     // ajoute 3 souris
     ->remove(1);            // supprime le produit avec l'id 1

// Affichage des résultats
echo "Total panier : " . $cart->getTotal() . " €<br>";
echo "Nombre d'articles : " . $cart->getItemCount();
