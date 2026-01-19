<?php

class Product
{
    private int $id;
    private string $name;
    private float $price;

    public function __construct(int $id, string $name, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
class CartItem
{
    private Product $product;
    private int $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function increaseQuantity(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    public function getTotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
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

    public function add(Product $product, int $quantity = 1): self
    {
        $productId = $product->getId();

        if (isset($this->items[$productId])) {
            $this->items[$productId]->increaseQuantity($quantity);
        } else {
            $this->items[$productId] = new CartItem($product, $quantity);
        }

        return $this;
    }

    public function remove(int $productId): self
    {
        unset($this->items[$productId]);

        return $this;
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


$product1 = new Product(1, "Clavier", 50);
$product2 = new Product(2, "Souris", 30);

$cart = new Cart();

$cart->add($product1)
     ->add($product2, 3)
     ->remove(1);

echo "Total panier : " . $cart->getTotal() . " €<br>";
echo "Nombre d'articles : " . $cart->getItemCount();
