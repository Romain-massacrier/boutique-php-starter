<?php

class User
{
    private string $nom;
    private string $email;

    public function __construct(string $nom, string $email)
    {
        $this->nom = $nom;
        $this->email = $email;
    }

    public function getNom(): string
    {
        return $this->nom;
    }
}

class CartItem
{
    private string $name;
    private float $price;
    private int $quantity;

    public function __construct(string $name, float $price, int $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getTotal(): float
    {
        return $this->price * $this->quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}

class Cart
{
    /**
     * @var CartItem[]
     */
    private array $items = [];

    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

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
    private int $id;
    private User $user;
    private array $items;
    private DateTime $date;
    private string $statut;

    public function __construct(int $id, User $user, Cart $cart)
    {
        $this->id = $id;
        $this->user = $user;
        $this->items = $cart->getItems();
        $this->date = new DateTime();
        $this->statut = "en attente";
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    public function getItemCount(): int
    {
        $count = 0;

        foreach ($this->items as $item) {
            $count += $item->getQuantity();
        }

        return $count;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }
}

$user = new User("Romain", "romain@email.fr");

$cart = new Cart();
$cart->addItem(new CartItem("Clavier", 50, 1));
$cart->addItem(new CartItem("Souris", 30, 2));

$order = new Order(1, $user, $cart);

echo "Total commande : " . $order->getTotal() . " €<br>";
echo "Nombre d'articles : " . $order->getItemCount() . "<br>";

$order->setStatut("payée");
echo "Statut : " . $order->getStatut();
