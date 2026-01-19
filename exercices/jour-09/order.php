<?php

class User
{
    // Nom de l'utilisateur
    private string $nom;

    // Email de l'utilisateur
    private string $email;

    // Constructeur appelé à la création du User
    public function __construct(string $nom, string $email)
    {
        // Initialisation des propriétés
        $this->nom = $nom;
        $this->email = $email;
    }

    // Retourne le nom de l'utilisateur
    public function getNom(): string
    {
        return $this->nom;
    }
}

class CartItem
{
    // Nom du produit
    private string $name;

    // Prix unitaire du produit
    private float $price;

    // Quantité du produit
    private int $quantity;

    // Constructeur du CartItem
    public function __construct(string $name, float $price, int $quantity)
    {
        // Initialisation des propriétés
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    // Calcule le total de la ligne (prix x quantité)
    public function getTotal(): float
    {
        return $this->price * $this->quantity;
    }

    // Retourne la quantité de cette ligne
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
class Cart
{
    /**
     * Tableau d'objets CartItem
     * @var CartItem[]
     */
    private array $items = [];

    // Ajoute un article au panier
    public function addItem(CartItem $item): void
    {
        // Ajout direct dans le tableau
        $this->items[] = $item;
    }

    // Retourne toutes les lignes du panier
    public function getItems(): array
    {
        return $this->items;
    }

    // Calcule le total du panier
    public function getTotal(): float
    {
        $total = 0;

        // Additionne le total de chaque CartItem
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    // Compte le nombre total d'articles (quantités cumulées)
    public function getItemCount(): int
    {
        $count = 0;

        foreach ($this->items as $item) {
            $count += $item->getQuantity();
        }

        return $count;
    }
}

class Order
{
    // Identifiant de la commande
    private int $id;

    // Utilisateur ayant passé la commande
    private User $user;

    // Articles de la commande (copie depuis le panier)
    private array $items;

    // Date de création de la commande
    private DateTime $date;

    // Statut de la commande (en attente, payée, etc.)
    private string $statut;

    // Constructeur de la commande
    public function __construct(int $id, User $user, Cart $cart)
    {
        $this->id = $id;
        $this->user = $user;

        // Récupère les items du panier
        $this->items = $cart->getItems();

        // Date de création automatique
        $this->date = new DateTime();

        // Statut par défaut
        $this->statut = "en attente";
    }

    // Calcule le total de la commande
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    // Compte le nombre total d'articles commandés
    public function getItemCount(): int
    {
        $count = 0;

        foreach ($this->items as $item) {
            $count += $item->getQuantity();
        }

        return $count;
    }

    // Modifie le statut de la commande
    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    // Retourne le statut actuel
    public function getStatut(): string
    {
        return $this->statut;
    }
}


// Création d'un utilisateur
$user = new User("Romain", "romain@email.fr");

// Création du panier
$cart = new Cart();

// Ajout de deux articles au panier
$cart->addItem(new CartItem("Clavier", 50, 1));
$cart->addItem(new CartItem("Souris", 30, 2));

// Création de la commande à partir du user et du panier
$order = new Order(1, $user, $cart);

// Affichage des informations principales
echo "Total commande : " . $order->getTotal() . " €<br>";
echo "Nombre d'articles : " . $order->getItemCount() . "<br>";

// Changement du statut
$order->setStatut("payée");
echo "Statut : " . $order->getStatut();
